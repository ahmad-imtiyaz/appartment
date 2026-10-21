<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('worker.profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        $user->update($validated);

        return redirect()
            ->route('worker.profile.edit')
            ->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Rekening tujuan pencairan pendapatan.
     */
    public function updateBank(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updateBank', [
            'bank_name' => ['required', 'string', 'max:100'],
            'bank_account_number' => ['required', 'string', 'max:50', 'regex:/^[0-9\- ]+$/'],
            'bank_account_holder' => ['required', 'string', 'max:255'],
        ], [
            'bank_account_number.regex' => 'Nomor rekening hanya boleh berisi angka.',
        ]);

        $request->user()->update($validated);

        return redirect()
            ->route('worker.profile.edit')
            ->with('success', 'Data rekening berhasil disimpan.');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        // Cast 'hashed' di model User otomatis meng-hash password
        $request->user()->update([
            'password' => $validated['password'],
        ]);

        return redirect()
            ->route('worker.profile.edit')
            ->with('success', 'Password berhasil diubah.');
    }
}
