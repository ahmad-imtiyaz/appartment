<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    private const ROLES = [
        'admin'   => 'Admin',
        'pekerja' => 'Pekerja',
        'guest'   => 'Guest',
    ];

    public function index(Request $request)
    {
        $roles = self::ROLES;

        $role = array_key_exists($request->role, $roles) ? $request->role : null;
        $search = trim((string) $request->search);

        // Statistik: jumlah user per role
        $counts = User::selectRaw('role, count(*) as total')
            ->groupBy('role')
            ->pluck('total', 'role');
        $totalUsers = $counts->sum();

        $users = User::query()
            ->when($role, fn ($q) => $q->where('role', $role))
            ->when($search !== '', function ($q) use ($search) {
                $q->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.users.index', compact('users', 'roles', 'role', 'search', 'counts', 'totalUsers'));
    }

    public function show(User $user)
    {
        // Guest: request yang dia ajukan. Pekerja: tugas yang dia kerjakan. Admin: tidak ada.
        $requestColumn = match ($user->role) {
            'guest'   => 'user_id',
            'pekerja' => 'worker_id',
            default   => null,
        };

        $totalRequests = 0;
        $completedRequests = 0;
        $recentRequests = collect();

        if ($requestColumn) {
            $totalRequests = ServiceRequest::where($requestColumn, $user->id)->count();

            $completedRequests = ServiceRequest::where($requestColumn, $user->id)
                ->where('status', 'completed')
                ->count();

            $recentRequests = ServiceRequest::with('service')
                ->where($requestColumn, $user->id)
                ->latest()
                ->take(5)
                ->get();
        }

        return view('admin.users.show', compact(
            'user',
            'totalRequests',
            'completedRequests',
            'recentRequests'
        ));
    }

    public function create()
    {
        return view('admin.users.create', [
            'roles'    => self::ROLES,
            'services' => $this->serviceNames(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'                  => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'role'                  => ['required', Rule::in(array_keys(self::ROLES))],
            'phone'                 => ['nullable', 'string', 'max:20'],
            'apartment_unit_number' => ['nullable', 'string', 'max:50'],
            'specialization'        => ['nullable', 'string', Rule::in($this->serviceNames()->all())],
            'password'              => ['required', 'confirmed', Password::defaults()],
        ]);

        // Nomor unit hanya relevan untuk role guest
        $unit = $validated['role'] === 'guest'
            ? ($validated['apartment_unit_number'] ?? null)
            : null;

        // Spesialisasi hanya untuk pekerja; kosong = null = bisa semua jasa
        $specialization = $validated['role'] === 'pekerja'
            ? ($validated['specialization'] ?: null)
            : null;

        $user = new User();
        $user->forceFill([
            'name'                  => $validated['name'],
            'email'                 => $validated['email'],
            'role'                  => $validated['role'],
            'phone'                 => $validated['phone'] ?? null,
            'apartment_unit_number' => $unit,
            'specialization'        => $specialization,
            'password'              => Hash::make($validated['password']),
            'email_verified_at'     => now(),
        ])->save();

        $roleLabel = self::ROLES[$validated['role']];

        return redirect()
            ->route('admin.users.index', ['role' => $validated['role']])
            ->with('success', "Akun {$roleLabel} {$user->name} berhasil dibuat.");
    }

    /**
     * Nama jasa unik (nama yang sama digabung jadi satu).
     */
    private function serviceNames()
    {
        return Service::orderBy('name')->pluck('name')->unique()->values();
    }
}
