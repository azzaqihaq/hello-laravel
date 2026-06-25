<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the user's profile page.
     */
    public function show()
    {
        $user = Auth::user()->load('role');
        return view('profile', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name'  => ['nullable', 'string', 'max:255'],
        ]);

        $user->first_name = $validated['first_name'];
        $user->last_name  = $validated['last_name'] ?? '';
        $user->save();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully.',
                'user'    => [
                    'name'       => $user->name,
                    'first_name' => $user->first_name,
                    'last_name'  => $user->last_name,
                    'email'      => $user->email,
                    'initials'   => strtoupper(substr($user->name, 0, 2)),
                    'photo_url'  => $user->profile_photo ? asset('storage/' . $user->profile_photo) : null,
                ],
            ]);
        }

        return back()->with('success', 'Profile updated successfully.');
    }

    /**
     * Update the user's profile photo.
     */
    public function updatePhoto(Request $request)
    {
        $request->validate([
            'profile_photo' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        $user = Auth::user();

        // Delete old photo if exists
        if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
            Storage::disk('public')->delete($user->profile_photo);
        }

        // Store new photo
        $path = $request->file('profile_photo')->store('profile-photos', 'public');
        $user->profile_photo = $path;
        $user->save();

        if ($request->expectsJson()) {
            return response()->json([
                'success'   => true,
                'message'   => 'Photo updated successfully.',
                'photo_url' => asset('storage/' . $path),
                'initials'  => strtoupper(substr($user->name, 0, 2)),
            ]);
        }

        return back()->with('success', 'Profile photo updated successfully.');
    }
}
