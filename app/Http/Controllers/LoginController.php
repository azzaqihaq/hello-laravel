<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Display the login view.
     */
    public function showLoginForm()
    {
        return view('login');
    }

    /**
     * Handle an authentication attempt.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $user = Auth::user();
            
            // Check if the user's account is active
            if (!$user->is_active) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors([
                    'email' => 'Your account is not yet active. Please contact an administrator.',
                ])->onlyInput('email');
            }

            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Display the registration form.
     */
    public function showRegisterForm()
    {
        // Only fetch Editor and User roles (exclude Administrator)
        $roles = UserRole::where('slug', '!=', 'administrator')->get();
        return view('register', compact('roles'));
    }

    /**
     * Handle a registration request.
     */
    public function register(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'user_role_id' => ['required', 'exists:user_roles,id'],
        ]);

        // Secure API validation: do not allow signing up as Administrator
        $role = UserRole::findOrFail($request->user_role_id);
        if ($role->slug === 'administrator') {
            return back()->withErrors([
                'user_role_id' => 'Unauthorized role assignment attempt.',
            ])->withInput();
        }

        User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'user_role_id' => $request->user_role_id,
            'is_active' => false, // Default state is inactive
        ]);

        return redirect('/login')->with('success', 'Registration successful! Your account is pending administrator activation.');
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
