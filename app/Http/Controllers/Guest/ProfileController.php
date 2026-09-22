<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\ApartmentLocation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Tampilkan form profil guest.
     */
    public function edit(Request $request): View
    {
        $locations = ApartmentLocation::where('is_active', true)
            ->with([
                'towers' => fn ($q) => $q->where('is_active', true),
            ])
            ->orderBy('name')
            ->get();

        return view('guest.profile', [
            'user' => $request->user(),
            'locations' => $locations,
        ]);
    }

    /**
     * Update data profil guest.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('guest.profile.edit')
            ->with('status', 'profile-updated');
    }

    /**
     * Hapus akun guest.
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
}
