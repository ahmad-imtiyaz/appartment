<?php

namespace App\Services;

use App\Models\User;

class AdminWhatsappLink
{
    /**
     * Bangun link wa.me ke admin, dengan pesan awal berisi data user
     * yang sudah terdaftar. Return null kalau nomor admin belum diisi.
     * 
     * Sekarang pakai nomor telepon admin dari database (bisa diubah lewat /admin/profile)
     */
    public static function for(User $user): ?string
    {
        // Ambil admin pertama yang punya nomor telepon
        $admin = User::where('role', 'admin')
            ->whereNotNull('phone')
            ->where('phone', '!=', '')
            ->first();

        if (!$admin) {
            // Fallback ke env kalau tidak ada admin dengan nomor telepon
            $number = preg_replace('/\D+/', '', (string) config('oregonet.admin_whatsapp'));
            
            if ($number === '') {
                return null;
            }
        } else {
            $number = preg_replace('/\D+/', '', (string) $admin->phone);
        }

        // 08xxx -> 628xxx, 8xxx -> 628xxx, 62xxx tetap
        if (str_starts_with($number, '0')) {
            $number = '62' . substr($number, 1);
        } elseif (str_starts_with($number, '8')) {
            $number = '62' . $number;
        }

        // Sanity check
        if (! str_starts_with($number, '62') || strlen($number) < 10 || strlen($number) > 15) {
            return null;
        }

        $user->loadMissing(['apartmentLocation', 'apartmentTower']);

        $lines = [
            'Halo Admin Oregonet, saya butuh bantuan.',
            '',
            'Nama: ' . $user->name,
            'Email: ' . $user->email,
        ];

        if ($user->phone) {
            $lines[] = 'No. HP: ' . $user->phone;
        }

        if ($user->status) {
            $lines[] = 'Status: ' . ucfirst($user->status);
        }

        $lokasi = collect([
            $user->apartmentLocation?->name,
            $user->apartmentTower?->name,
        ])->filter()->implode(' - ');

        if ($lokasi !== '') {
            $lines[] = 'Lokasi: ' . $lokasi;
        }

        if ($user->apartment_unit_number) {
            $lines[] = 'Unit: ' . $user->apartment_unit_number;
        }

        $lines[] = '';
        $lines[] = 'Kendala saya: ';

        return 'https://wa.me/' . $number . '?text=' . rawurlencode(implode("\n", $lines));
    }
}