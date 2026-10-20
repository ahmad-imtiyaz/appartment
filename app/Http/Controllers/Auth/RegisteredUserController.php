<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ApartmentLocation;
use App\Models\ApartmentTower;
use App\Models\LegalDocument;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Tampilkan formulir pendaftaran.
     * Jika belum menyetujui dokumen legal, arahkan ke halaman persetujuan.
     */
    public function create(): View|RedirectResponse
    {
        if (! $this->hasValidConsent()) {
            return redirect()->route('register.consent');
        }

        $locations = ApartmentLocation::with('towers')
            ->orderBy('name')
            ->get();

        $towers = ApartmentTower::orderBy('name')->get();

        return view('auth.register', compact('locations', 'towers'));
    }

    /**
     * Proses pendaftaran.
     */
    public function store(Request $request): RedirectResponse
    {
        // Persetujuan wajib valid (juga mencegah POST langsung tanpa persetujuan)
        if (! $this->hasValidConsent()) {
            session()->forget('register_consent');

            return redirect()
                ->route('register.consent')
                ->with('status', 'Mohon setujui Syarat dan Ketentuan serta Kebijakan Privasi terlebih dahulu.');
        }

        $consent = session('register_consent');

        $request->merge([
            'email' => strtolower(trim((string) $request->input('email'))),
        ]);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'max:255',
                'email:rfc,dns',
                // Hapus baris regex ini jika semua domain email boleh
                'regex:/^[a-z0-9._%+\-]+@gmail\.com$/',
                'unique:' . User::class,
            ],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],

            'status'                => ['nullable', 'in:penyewa,pemilik,agent'],
            'daerah'                => ['nullable', 'string', 'max:255'],
            'apartment_location_id' => ['required', 'exists:apartment_locations,id'],
            'apartment_tower_id'    => ['nullable', 'exists:apartment_towers,id'],
            'apartment_unit_number' => ['nullable', 'string', 'max:50'],
            'phone'                 => ['nullable', 'string', 'max:20'],
        ], [
            'name.required'  => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email'    => 'Gunakan alamat email asli yang valid.',
            'email.regex'    => 'Email harus menggunakan alamat @gmail.com.',
            'email.unique'   => 'Email ini sudah terdaftar.',
            'password.required'  => 'Kata sandi wajib diisi.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'apartment_location_id.required' => 'Lokasi unit wajib dipilih.',
        ]);

        $user = User::create([
            'name'                  => $validated['name'],
            'email'                 => $validated['email'],
            'password'              => $validated['password'], // otomatis di-hash oleh cast 'hashed'
            'role'                  => 'guest',
            'status'                => $validated['status'] ?? null,
            'daerah'                => $validated['daerah'] ?? null,
            'apartment_location_id' => $validated['apartment_location_id'],
            'apartment_tower_id'    => $validated['apartment_tower_id'] ?? null,
            'apartment_unit_number' => $validated['apartment_unit_number'] ?? null,
            'phone'                 => $validated['phone'] ?? null,
            'terms_version'         => $consent['terms_version'],
            'privacy_version'       => $consent['privacy_version'],
            'consented_at'          => now(),
        ]);

        session()->forget('register_consent');

        event(new Registered($user)); // mengirim email verifikasi

        Auth::login($user);

        return redirect()->route('verification.notice');
    }

    /**
     * Persetujuan dianggap valid bila ada di session dan versi dokumen
     * masih sama dengan versi terbaru di database.
     */
    private function hasValidConsent(): bool
    {
        $consent = session('register_consent');

        if (! $consent) {
            return false;
        }

        return ($consent['terms_version'] ?? null) === LegalDocument::terms()->version
            && ($consent['privacy_version'] ?? null) === LegalDocument::privacy()->version;
    }
}
