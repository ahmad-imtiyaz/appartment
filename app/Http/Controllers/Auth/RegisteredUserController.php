<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ApartmentLocation;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        $locations = ApartmentLocation::where('is_active', true)
            ->with(['towers' => fn ($q) => $q->where('is_active', true)])
            ->orderBy('name')
            ->get();

        return view('auth.register', compact('locations'));
    }

    /**
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone' => ['nullable', 'string', 'max:30'],
            'apartment_unit_number' => ['nullable', 'string', 'max:50'],
            'status' => ['required', Rule::in(['penyewa', 'pemilik', 'agent'])],
            'daerah' => ['required', Rule::in(['Jakarta'])],
            'apartment_location_id' => ['required', 'exists:apartment_locations,id'],
            'apartment_tower_id' => [
                'required',
                Rule::exists('apartment_towers', 'id')
                    ->where(fn ($q) => $q->where('apartment_location_id', $request->apartment_location_id)),
            ],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'apartment_unit_number' => $request->apartment_unit_number,
            'status' => $request->status,
            'daerah' => $request->daerah,
            'apartment_location_id' => $request->apartment_location_id,
            'apartment_tower_id' => $request->apartment_tower_id,
            'role' => 'guest',
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('guest.service-requests.index', absolute: false));
    }
}
