<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AccountManagementController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    
    Route::get('/register', [LoginController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [LoginController::class, 'register']);

    // Forgot Password
    Route::get('/forgot-password', function () {
        return view('forgot-password');
    })->name('password.request');

    Route::post('/forgot-password', function (\Illuminate\Http\Request $request) {
        $request->validate(['email' => ['required', 'email']]);

        $status = \Illuminate\Support\Facades\Password::sendResetLink(
            $request->only('email')
        );

        return $status === \Illuminate\Support\Facades\Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)])->onlyInput('email');
    })->name('password.email');

    // Reset Password
    Route::get('/reset-password/{token}', function (string $token, \Illuminate\Http\Request $request) {
        return view('reset-password', [
            'token' => $token,
            'email' => $request->query('email', ''),
        ]);
    })->name('password.reset');

    Route::post('/reset-password', function (\Illuminate\Http\Request $request) {
        $request->validate([
            'token'    => ['required'],
            'email'    => ['required', 'email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $status = \Illuminate\Support\Facades\Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, string $password) {
                $user->forceFill([
                    'password'            => \Illuminate\Support\Facades\Hash::make($password),
                    'password_changed_at' => now(),
                ])->setRememberToken(\Illuminate\Support\Str::random(60));
                $user->save();
            }
        );

        return $status === \Illuminate\Support\Facades\Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', 'Your password has been reset! You can now sign in.')
            : back()->withErrors(['email' => [__($status)]]);
    })->name('password.update');
});

Route::middleware(['auth', 'active'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/dashboard/profile', [ProfileController::class, 'show'])->name('profile');
    Route::put('/dashboard/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/dashboard/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo');
    
    Route::get('/dashboard/settings', function () {
        $user = Auth::user()->load('settings');

        // Fetch all active sessions for this user
        $currentSessionId = session()->getId();
        $rawSessions = DB::table('sessions')
            ->where('user_id', $user->id)
            ->orderByDesc('last_activity')
            ->get();

        $sessions = $rawSessions->map(function ($session) use ($currentSessionId) {
            $ua = $session->user_agent ?? '';

            // Parse browser
            $browser = 'Unknown Browser';
            if (str_contains($ua, 'Edg/') || str_contains($ua, 'EdgA/')) {
                $browser = 'Microsoft Edge';
            } elseif (str_contains($ua, 'Chrome') && !str_contains($ua, 'Chromium')) {
                $browser = 'Chrome';
            } elseif (str_contains($ua, 'Firefox')) {
                $browser = 'Firefox';
            } elseif (str_contains($ua, 'Safari') && !str_contains($ua, 'Chrome')) {
                $browser = 'Safari';
            } elseif (str_contains($ua, 'OPR') || str_contains($ua, 'Opera')) {
                $browser = 'Opera';
            } elseif (str_contains($ua, 'curl')) {
                $browser = 'API / curl';
            }

            // Parse OS / device type
            $os = 'Unknown OS';
            $isMobile = false;
            if (str_contains($ua, 'iPhone') || str_contains($ua, 'Android') && str_contains($ua, 'Mobile')) {
                $os = str_contains($ua, 'iPhone') ? 'iPhone' : 'Android Phone';
                $isMobile = true;
            } elseif (str_contains($ua, 'iPad')) {
                $os = 'iPad';
                $isMobile = true;
            } elseif (str_contains($ua, 'Android')) {
                $os = 'Android Tablet';
                $isMobile = true;
            } elseif (str_contains($ua, 'Windows')) {
                $os = 'Windows';
            } elseif (str_contains($ua, 'Macintosh') || str_contains($ua, 'Mac OS')) {
                $os = 'macOS';
            } elseif (str_contains($ua, 'Linux')) {
                $os = 'Linux';
            }

            return (object) [
                'id'           => $session->id,
                'browser'      => $browser,
                'os'           => $os,
                'is_mobile'    => $isMobile,
                'ip_address'   => $session->ip_address ?? '—',
                'last_activity'=> $session->last_activity,
                'is_current'   => $session->id === $currentSessionId,
            ];
        });

        $passwordChangedAt = $user->password_changed_at
            ? $user->password_changed_at->diffForHumans()
            : null;

        return view('settings', compact('user', 'sessions', 'passwordChangedAt'));
    })->name('settings');

    Route::post('/dashboard/settings', function (\Illuminate\Http\Request $request) {
        $request->validate([
            'notifications'   => ['required', 'string', 'in:all,mentions,none'],
            'public_profile'  => ['nullable', 'boolean'],
            'show_active'     => ['nullable', 'boolean'],
            'crash_telemetry' => ['nullable', 'boolean'],
        ]);

        $user = Auth::user();
        $user->settings()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'notifications'   => $request->notifications,
                'public_profile'  => $request->boolean('public_profile'),
                'show_active'     => $request->boolean('show_active'),
                'crash_telemetry' => $request->boolean('crash_telemetry'),
            ]
        );

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Settings saved successfully.'
            ]);
        }

        return back()->with('success', 'Settings saved successfully.');
    })->name('settings.update');

    // Change Password
    Route::post('/dashboard/settings/password', function (\Illuminate\Http\Request $request) {
        $request->validate([
            'current_password' => ['required', 'string'],
            'new_password'     => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();

        if (!\Illuminate\Support\Facades\Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'errors'  => ['current_password' => ['The current password is incorrect.']],
            ], 422);
        }

        $user->update([
            'password'            => \Illuminate\Support\Facades\Hash::make($request->new_password),
            'password_changed_at' => now(),
        ]);

        return response()->json([
            'success'              => true,
            'message'              => 'Password changed successfully.',
            'password_changed_at'  => $user->fresh()->password_changed_at->diffForHumans(),
        ]);
    })->name('settings.password.change');

    // Revoke a specific session
    Route::post('/dashboard/settings/sessions/{sessionId}/revoke', function (string $sessionId) {
        $user = Auth::user();
        $currentSessionId = session()->getId();

        if ($sessionId === $currentSessionId) {
            return response()->json(['success' => false, 'message' => 'Cannot revoke your current session.'], 403);
        }

        $deleted = DB::table('sessions')
            ->where('id', $sessionId)
            ->where('user_id', $user->id)
            ->delete();

        if (!$deleted) {
            return response()->json(['success' => false, 'message' => 'Session not found.'], 404);
        }

        return response()->json(['success' => true, 'message' => 'Session revoked.']);
    })->name('settings.sessions.revoke');

    // Revoke all sessions except current
    Route::post('/dashboard/settings/sessions/revoke-others', function () {
        $user = Auth::user();
        $currentSessionId = session()->getId();

        DB::table('sessions')
            ->where('user_id', $user->id)
            ->where('id', '!=', $currentSessionId)
            ->delete();

        return response()->json(['success' => true, 'message' => 'All other sessions have been revoked.']);
    })->name('settings.sessions.revoke-others');

    // Administrator-only routes
    Route::middleware('admin')->group(function () {
        Route::get('/dashboard/accounts', [AccountManagementController::class, 'index'])->name('admin.accounts');
        Route::post('/dashboard/accounts/{user}/toggle', [AccountManagementController::class, 'toggleStatus'])->name('admin.accounts.toggle');
    });
});

