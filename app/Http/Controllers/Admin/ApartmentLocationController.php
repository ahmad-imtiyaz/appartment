<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ApartmentLocation;
use App\Models\ApartmentTower;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ApartmentLocationController extends Controller
{
    public function index(): View
    {
        $locations = ApartmentLocation::with('towers')->orderBy('name')->get();

        return view('admin.apartment-locations.index', compact('locations'));
    }

    public function storeLocation(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:apartment_locations,name'],
        ]);

        ApartmentLocation::create(['name' => $request->name]);

        return back()->with('success', 'Lokasi unit berhasil ditambahkan.');
    }

    public function destroyLocation(ApartmentLocation $apartmentLocation): RedirectResponse
    {
        if ($apartmentLocation->users()->exists()) {
            return back()->with('error', 'Lokasi tidak bisa dihapus karena masih ada user terdaftar di lokasi ini.');
        }

        $apartmentLocation->delete();

        return back()->with('success', 'Lokasi unit berhasil dihapus.');
    }

    public function storeTower(Request $request, ApartmentLocation $apartmentLocation): RedirectResponse
    {
        $request->validate([
            'name' => [
                'required', 'string', 'max:255',
                \Illuminate\Validation\Rule::unique('apartment_towers', 'name')
                    ->where('apartment_location_id', $apartmentLocation->id),
            ],
        ]);

        $apartmentLocation->towers()->create(['name' => $request->name]);

        return back()->with('success', 'Tower berhasil ditambahkan.');
    }

    public function destroyTower(ApartmentTower $apartmentTower): RedirectResponse
    {
        if ($apartmentTower->users()->exists()) {
            return back()->with('error', 'Tower tidak bisa dihapus karena masih ada user terdaftar di tower ini.');
        }

        $apartmentTower->delete();

        return back()->with('success', 'Tower berhasil dihapus.');
    }
}
