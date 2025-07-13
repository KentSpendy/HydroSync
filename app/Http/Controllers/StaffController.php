<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    /**
     * Display a listing of staff users.
     */
    public function index()
    {
        $staff = User::where('role', 'employee')->paginate(10);
        return view('staff.index', compact('staff'));
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
    public function update(Request $request, User $staff)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $staff->id,
        ]);

        $staff->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('staff.index')->with('success', 'Staff updated successfully.');
    }

    /**
     * Remove the specified staff from storage.
     */
    public function destroy(User $staff)
    {
        $staff->delete();
        return redirect()->route('staff.index')->with('success', 'Staff deleted successfully.');
    }
}
