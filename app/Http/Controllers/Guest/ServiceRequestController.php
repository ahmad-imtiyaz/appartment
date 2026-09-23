<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\LaundryPricing;
use App\Models\CleaningPricing;
use App\Models\AcPricing;
use App\Models\MaintenanceDetail;
use App\Models\Service;
use App\Models\ServiceRequest;
use App\Models\ServiceRequestPhoto;
use App\Services\RepairPaymentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ServiceRequestController extends Controller
{
    public function index()
    {
        $requests = auth()->user()->serviceRequests()
            ->with(['service', 'worker', 'feedback'])
            ->latest()
            ->get();

        return view('guest.service-requests.index', compact('requests'));
    }

    public function category(string $category): View|RedirectResponse
    {
        $categories = [
            'laundry' => [
                'slug'  => 'laundry',
                'title' => 'Laundry Services',
                'bg'    => 'bg-blue-50',
                'options' => [
                    ['id' => 'laundry-weight', 'label' => 'By Weight', 'icon' => '<svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8 3v3M16 3v3M3 9h18M5 5h14a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z" /></svg>'],
                    ['id' => 'laundry-item', 'label' => 'By Item', 'icon' => '<svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 3v3a1 1 0 001 1h4a1 1 0 001-1V3M6 21h12a2 2 0 002-2V9l-4-4H8L4 9v10a2 2 0 002 2z" /></svg>'],
                    ['id' => 'laundry-vip', 'label' => 'VIP', 'icon' => '<svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 2l2.4 6.6L21 9l-5 4.4L17.4 21 12 17.3 6.6 21 8 13.4 3 9l6.6-.4L12 2z" /></svg>'],
                    ['id' => 'laundry-curtain', 'label' => 'Curtains', 'icon' => '<svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v16M20 4v16M4 4h16" /></svg>'],
                    ['id' => 'laundry-ironing', 'label' => 'Ironing Only', 'icon' => '<svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16h13a3 3 0 003-3V9H8L3 16z" /></svg>'],
                    ['id' => 'laundry-express', 'label' => 'Express', 'icon' => '<svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>'],
                ],
            ],
            'cleaning' => [
                'slug'  => 'cleaning',
                'title' => 'Cleaning Services',
                'bg'    => 'bg-purple-50',
                'options' => [
                    ['id' => 'cleaning-regular', 'label' => 'Regular Cleaning', 'icon' => '<svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5" /></svg>'],
                    ['id' => 'cleaning-deep', 'label' => 'Deep Cleaning', 'icon' => '<svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.8 15.3l-1.57.393A9.065 9.065 0 0112 15" /></svg>'],
                    ['id' => 'cleaning-postmove', 'label' => 'Post Move-in', 'icon' => '<svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3l9 6-9 6-9-6 9-6z" /></svg>'],
                ],
            ],
            'repair' => [
                'slug'  => 'repair',
                'title' => 'Repair & Maintenance',
                'bg'    => 'bg-orange-50',
                'options' => [
                    ['id' => 'repair-plumbing', 'label' => 'Plumbing', 'icon' => '<svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21" /></svg>'],
                    ['id' => 'repair-electric', 'label' => 'Electrical', 'icon' => '<svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>'],
                    ['id' => 'repair-furniture', 'label' => 'Furniture', 'icon' => '<svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v16M20 4v16M4 4h16" /></svg>'],
                ],
            ],
            'ac' => [
                'slug'  => 'ac',
                'title' => 'Air Conditioner',
                'bg'    => 'bg-cyan-50',
                'options' => [
                    ['id' => 'ac-cleaning', 'label' => 'AC Cleaning', 'icon' => '<svg class="w-6 h-6 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125" /></svg>'],
                    ['id' => 'ac-refill', 'label' => 'Freon Refill', 'icon' => '<svg class="w-6 h-6 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 2v20M2 12h20" /></svg>'],
                    ['id' => 'ac-repair', 'label' => 'AC Repair', 'icon' => '<svg class="w-6 h-6 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21" /></svg>'],
                ],
            ],
        ];

        abort_unless(isset($categories[$category]), 404);

        // Semua kategori (termasuk repair/MnR) diarahkan ke halaman service-detail
        // yang sama, dengan card-based selector.
        if (in_array($category, ['laundry', 'cleaning', 'ac', 'repair'])) {
            $slug = $category === 'repair' ? 'maintenance-repair' : $category;
            return redirect()->route('guest.services.show', $slug);
        }

        $categoryData = $categories[$category];

        $activeRequests = auth()->user()->serviceRequests()
            ->with(['service', 'worker', 'feedback'])
            ->whereHas('service', function ($q) use ($category) {
                $q->where('services.slug', $category);
            })
            ->whereNotIn('status', ['completed', 'rejected'])
            ->latest()
            ->get();

        return view('guest.service-requests.category', [
            'category' => $categoryData,
            'activeRequests' => $activeRequests,
        ]);
    }

    public function serviceDetail(string $slug): View
    {
        $service = Service::where('slug', $slug)->where('is_active', true)->firstOrFail();

        $requests = auth()->user()->serviceRequests()
            ->where('service_id', $service->id)
            ->with(['service', 'worker', 'feedback'])
            ->latest()
            ->get();

        $laundryPricings = $service->slug === 'laundry'
            ? LaundryPricing::active()->latest()->get()
            : collect();

        $cleaningPricing = $service->slug === 'cleaning'
            ? \App\Models\CleaningPricing::current()
            : null;

        $cleaningAddons = $service->slug === 'cleaning'
            ? \App\Models\CleaningAddon::active()->orderBy('name')->get()
            : collect();

        $acPricings = $service->slug === 'ac'
            ? AcPricing::active()->latest()->get()
            : collect();

        $locations = \App\Models\ApartmentLocation::with('towers')->where('is_active', true)->orderBy('name')->get();

        return view('guest.service-requests.service-detail', compact(
            'service',
            'requests',
            'laundryPricings',
            'cleaningPricing',
            'cleaningAddons',
            'acPricings',
            'locations'
        ));
    }

    public function create(): View
    {
        $services = Service::where('is_active', true)->get();

        return view('guest.service-requests.create', compact('services'));
    }

    public function show(ServiceRequest $serviceRequest): View
    {
        abort_unless($serviceRequest->user_id === auth()->id(), 403);

        $serviceRequest->load(['service', 'worker', 'maintenanceDetail', 'photos', 'feedback']);

        return view('guest.service-requests.show', compact('serviceRequest'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'service_id' => ['required', 'exists:services,id'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'scheduled_at' => ['nullable', 'date', 'after:now'],

            // lokasi — wajib untuk semua jasa
            'daerah' => ['required', 'in:Jakarta'],
            'apartment_location_id' => ['required', 'exists:apartment_locations,id'],
            'apartment_tower_id' => [
                'required',
                Rule::exists('apartment_towers', 'id')->where('apartment_location_id', $request->apartment_location_id),
            ],

            // laundry-specific fields
            'laundry_type' => ['nullable', 'in:cuci,cuci_setrika,setrika'],
            'laundry_duration' => ['nullable', 'in:reguler,express'],
            'snapshot_price_per_kg' => ['nullable', 'numeric', 'min:0'],

            // cleaning-specific fields
            'cleaning_duration_hours' => ['nullable', 'integer', 'min:1', 'max:12'],
            'cleaning_addon_ids' => ['nullable', 'array'],
            'cleaning_addon_ids.*' => ['exists:cleaning_addons,id'],

            // ac-specific fields
            'ac_type' => ['nullable', 'in:ac-cleaning,ac-refill,ac-repair,ac-full-service'],
            'snapshot_ac_price' => ['nullable', 'numeric', 'min:0'],

            // maintenance fields
            'damage_category' => ['nullable', 'string', 'max:100'],
            'location' => ['nullable', 'string', 'max:100'],
            'urgency' => ['nullable', 'in:low,medium,high'],
            'photos' => ['nullable', 'array', 'max:5'],
            'photos.*' => ['image', 'max:2048'],
        ], [
            // pesan error custom
            'apartment_tower_id.exists' => 'Tower yang dipilih tidak sesuai dengan lokasi.',
        ]);

        $service = Service::findOrFail($validated['service_id']);
        $isMaintenance = $service->slug === 'maintenance-repair';
        $isLaundry = $service->slug === 'laundry';
        $isCleaning = $service->slug === 'cleaning';
        $isAc = $service->slug === 'ac';

        if ($isMaintenance) {
            $request->validate([
                'damage_category' => ['required', 'string', 'max:100'],
            ]);
        }

        if ($isLaundry) {
            $request->validate([
                'laundry_type' => ['required', 'in:cuci,cuci_setrika,setrika'],
                'laundry_duration' => ['required', 'in:reguler,express'],
            ]);

            $pricing = LaundryPricing::byTypeAndDuration(
                $request->laundry_type,
                $request->laundry_duration
            )->firstOrFail();

            $validated['snapshot_price_per_kg'] = $pricing->price_per_kg;
        }

        if ($isCleaning) {
            $request->validate([
                'cleaning_duration_hours' => ['required', 'integer', 'min:1', 'max:12'],
            ]);

            $pricing = \App\Models\CleaningPricing::current();
            abort_if(!$pricing, 422, 'Tarif cleaning belum diatur admin.');

            $validated['snapshot_cleaning_price_per_hour'] = $pricing->price_per_hour;
        }

        if ($isAc) {
            $request->validate([
                'ac_type' => ['required', 'in:ac-cleaning,ac-refill,ac-repair,ac-full-service'],
            ]);

            $needsUpfrontPrice = in_array($request->ac_type, ['ac-cleaning', 'ac-refill']);

            if ($needsUpfrontPrice) {
                $request->validate([
                    'snapshot_ac_price' => ['required', 'numeric', 'min:0'],
                ]);
            } else {
                // ac-repair & ac-full-service: survey dulu, harga ditentukan belakangan
                $validated['snapshot_ac_price'] = null;
            }
        }

        $serviceRequest = DB::transaction(function () use ($request, $validated, $service, $isMaintenance, $isLaundry, $isCleaning, $isAc) {
            $serviceRequest = ServiceRequest::create([
                'user_id' => auth()->id(),
                'service_id' => $service->id,
                'status' => 'pending',
                'notes' => $validated['notes'] ?? null,
                'scheduled_at' => $validated['scheduled_at'] ?? null,
                'daerah' => $validated['daerah'],
                'apartment_location_id' => $validated['apartment_location_id'],
                'apartment_tower_id' => $validated['apartment_tower_id'],
                'laundry_type' => $isLaundry ? $validated['laundry_type'] : null,
                'laundry_duration' => $isLaundry ? $validated['laundry_duration'] : null,
                'snapshot_price_per_kg' => $isLaundry ? $validated['snapshot_price_per_kg'] : null,
                'cleaning_duration_hours' => $isCleaning ? $validated['cleaning_duration_hours'] : null,
                'snapshot_cleaning_price_per_hour' => $isCleaning ? $validated['snapshot_cleaning_price_per_hour'] : null,
                'ac_type' => $isAc ? $validated['ac_type'] : null,
                'snapshot_ac_price' => $isAc ? $validated['snapshot_ac_price'] : null,
            ]);

            if ($isCleaning) {

                if (!empty($validated['cleaning_addon_ids'])) {
                    $addons = \App\Models\CleaningAddon::whereIn('id', $validated['cleaning_addon_ids'])
                        ->active()
                        ->get();

                    foreach ($addons as $addon) {
                        $serviceRequest->cleaningAddons()->attach($addon->id, [
                            'snapshot_price' => $addon->price,
                        ]);
                    }
                }

                $serviceRequest->calculateTotalPrice();
            }

            if ($isMaintenance) {
                MaintenanceDetail::create([
                    'service_request_id' => $serviceRequest->id,
                    'damage_category' => $validated['damage_category'],
                    'location' => $validated['location'] ?? null,
                    'description' => $validated['notes'] ?? null,
                    'urgency' => $validated['urgency'] ?? 'medium',
                ]);
            }

            foreach ($request->file('photos', []) as $photo) {
                ServiceRequestPhoto::create([
                    'service_request_id' => $serviceRequest->id,
                    'type' => 'before',
                    'photo_path' => $photo->store('service-request-photos', 'public'),
                ]);
            }

            return $serviceRequest;
        });

        return redirect()
            ->route('guest.service-requests.index')
            ->with('success', 'Permintaan jasa "' . $service->name . '" berhasil diajukan, menunggu diproses admin.');
    }

    public function destroy(ServiceRequest $serviceRequest): RedirectResponse
    {
        abort_unless($serviceRequest->user_id === auth()->id(), 403);
        abort_unless(in_array($serviceRequest->status, ['pending', 'assigned']), 422, 'Hanya pesanan pending atau assigned yang bisa dibatalkan.');

        $serviceName = $serviceRequest->service->name;
        $serviceRequest->delete();

        return redirect()
            ->back()
            ->with('success', 'Pesanan "' . $serviceName . '" berhasil dibatalkan.');
    }

    public function approvePrice(ServiceRequest $serviceRequest, RepairPaymentService $paymentService): RedirectResponse
    {
        abort_unless($serviceRequest->user_id === auth()->id(), 403);
        abort_if($serviceRequest->status !== 'waiting_approval', 422, 'Tidak ada harga yang menunggu persetujuan.');

        $paid = $paymentService->charge($serviceRequest);

        if (!$paid) {
            return back()->with('error', 'Saldo tidak cukup. Silakan top up terlebih dahulu.');
        }

        return back()->with('success', 'Harga disetujui, saldo telah dipotong. Pekerjaan akan dilanjutkan.');
    }

    public function rejectPrice(ServiceRequest $serviceRequest): RedirectResponse
    {
        abort_unless($serviceRequest->user_id === auth()->id(), 403);
        abort_if($serviceRequest->status !== 'waiting_approval', 422, 'Tidak ada harga yang menunggu persetujuan.');

        $serviceRequest->update(['status' => 'rejected']);

        return redirect()
            ->route('guest.service-requests.index')
            ->with('success', 'Harga ditolak. Silakan ajukan permintaan baru jika masih diperlukan.');
    }

    public function payLaundry(ServiceRequest $serviceRequest, \App\Services\LaundryPaymentService $paymentService): RedirectResponse
    {
        abort_unless($serviceRequest->user_id === auth()->id(), 403);
        abort_unless($serviceRequest->isLaundry(), 404);
        abort_if($serviceRequest->status !== 'waiting_payment', 422, 'Tidak ada tagihan laundry yang menunggu pembayaran.');
        abort_if($serviceRequest->laundry_paid_at !== null, 422, 'Laundry ini sudah dibayar.');

        $paid = $paymentService->charge($serviceRequest);

        if (!$paid) {
            return back()->with('error', 'Saldo tidak cukup. Silakan top up terlebih dahulu.');
        }

        return back()->with('success', 'Pembayaran berhasil. Laundry akan segera diantar.');
    }
}
