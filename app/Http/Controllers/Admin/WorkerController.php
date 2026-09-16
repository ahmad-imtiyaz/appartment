<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class WorkerController extends Controller
{
    // password default untuk semua akun pekerja yang dibuat admin
    private const DEFAULT_WORKER_PASSWORD = 'password';

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:30'],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'role' => 'pekerja',
            // 'password' => 'hashed' di cast User model otomatis hash ini pas disimpan
            'password' => self::DEFAULT_WORKER_PASSWORD,
        ]);

        return back()->with('success', 'Akun pekerja berhasil dibuat. Password default: "' . self::DEFAULT_WORKER_PASSWORD . '"');
    }
}
