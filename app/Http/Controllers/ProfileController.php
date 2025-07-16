<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Support\Str;


class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
{
    $user = $request->user();

    // ✅ Handle profile photo upload
    if ($request->hasFile('profile_photo')) {
        $file = $request->file('profile_photo');

        // Optional: delete old photo if exists
        if ($user->profile_photo && Storage::disk('public')->exists('avatars/' . $user->profile_photo)) {
            Storage::disk('public')->delete('avatars/' . $user->profile_photo);
        }

        // Store new photo
        $filename = Str::random(20) . '.' . $file->getClientOriginalExtension();
        $file->storeAs('avatars', $filename, 'public'); // ⬅️ important: 'public' disk
        $user->profile_photo = $filename;
    }

    // ✅ Update name and email
    $user->fill($request->only('name', 'email'));

    if ($user->isDirty('email')) {
        $user->email_verified_at = null;
    }

    $user->save();

    return Redirect::route('profile.edit')->with('status', 'profile-updated');
}

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function show()
    {
        return view('profile.show', [
            'user' => auth()->user()
        ]);
    }
}
