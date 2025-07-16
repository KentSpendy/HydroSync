<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    /**
     * Display a listing of staff users with optional search.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');

        $staff = User::where('role', 'employee')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->orderBy('name')
            ->paginate(10)
            ->appends(['search' => $search]);

        return view('staff.index', compact('staff', 'search'));
    }

    /**
     * Show the form for creating a new staff.
     */
    public function create()
    {
        return view('staff.create');
    }

    /**
     * Store a newly created staff in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => 'employee',
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('staff.index')->with('success', 'Staff created successfully.');
    }

    /**
     * Show the form for editing the specified staff.
     */
    public function edit(User $staff)
    {
        return view('staff.edit', compact('staff'));
    }

    /**
     * Update the specified staff in storage.
     */


    /**
     * Remove the specified staff from storage.
     */
    public function destroy(User $staff)
    {
        $staff->delete();
        return redirect()->route('staff.index')->with('success', 'Staff deleted successfully.');
    }


    public function update(Request $request, User $staff)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $staff->id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $staff->name = $request->name;
        $staff->email = $request->email;

        if ($request->filled('password')) {
            $staff->password = \Hash::make($request->password);
        }

        $staff->save();

        return redirect()->route('staff.edit', $staff)->with('success', 'Staff updated successfully.');

        ActivityLogger::log('Account Unlocked', "{$user->name}'s account was updated.");

    }


    public function unlock(User $user)
    {
        if (!auth()->user()->can('admin')) {
            abort(403, 'Unauthorized');
        }

        $updated = $user->update([
            'is_locked' => false,
            'otp_attempts' => 0,
            'login_attempts' => 0,
            'last_failed_login_at' => null,
        ]);

        if ($updated) {
            return redirect()->route('staff.index')->with('success', "{$user->name}'s account has been unlocked successfully.");
        } else {
            return redirect()->route('staff.index')->with('error', "Failed to unlock {$user->name}'s account.");
        }
        
        ActivityLogger::log('Account Unlocked', "{$user->name}'s account was unlocked by admin: " . auth()->user()->name);

    }

}
