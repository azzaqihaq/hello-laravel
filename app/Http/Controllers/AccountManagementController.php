<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AccountManagementController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index()
    {
        // Fetch all users with their roles, excluding administrators
        $users = User::with('role')
            ->whereDoesntHave('role', function ($query) {
                $query->where('slug', 'administrator');
            })
            ->get();

        return view('accounts', compact('users'));
    }

    /**
     * Toggle the active status of a user.
     */
    public function toggleStatus(User $user)
    {
        // Safety check: Don't allow administrators to deactivate themselves
        if (auth()->id() === $user->id) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You cannot deactivate your own account.'
                ], 403);
            }
            return back()->with('error', 'You cannot deactivate your own account.');
        }

        $user->is_active = !$user->is_active;
        $user->save();

        // If deactivated, delete all active database session records for this user
        if (!$user->is_active) {
            \Illuminate\Support\Facades\DB::table('sessions')
                ->where('user_id', $user->id)
                ->delete();
        }

        $status = $user->is_active ? 'activated' : 'deactivated';
        $message = "User account {$user->name} has been successfully {$status}.";

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'is_active' => $user->is_active,
                'message' => $message
            ]);
        }

        return back()->with('success', $message);
    }
}
