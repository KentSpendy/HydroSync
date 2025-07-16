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
use App\Helpers\ActivityLogger;


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

        ActivityLogger::log('Profile Updated', 'User edited their profile.');

    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $changes = [];

        // ✅ Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');

            // Delete old photo if it exists
            if ($user->profile_photo && Storage::disk('public')->exists('avatars/' . $user->profile_photo)) {
                Storage::disk('public')->delete('avatars/' . $user->profile_photo);
            }

            // Store new photo
            $filename = Str::random(20) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('avatars', $filename, 'public');
            $user->profile_photo = $filename;

            $changes[] = 'photo';
        }

        // ✅ Track name/email changes
        if ($user->name !== $request->name) {
            $changes[] = 'name';
        }
        if ($user->email !== $request->email) {
            $changes[] = 'email';
            $user->email_verified_at = null;
        }

        $user->fill($request->only('name', 'email'));
        $user->save();

        // ✅ Log the activity
        if (!empty($changes)) {
            $desc = 'Updated: ' . implode(', ', $changes);
            ActivityLogger::log('Profile Updated', $desc);
        }

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

        ActivityLogger::log('Profile Updated', 'User destroyed their profile.');

    }

    public function show()
    {
        return view('profile.show', [
            'user' => auth()->user()
        ]);
    }
}
