<?php

namespace App\Services;

use App\Models\User;

class AdminWhatsappLink
{
    /**
     * Bangun link wa.me ke admin, dengan pesan awal berisi data user
     * yang sudah terdaftar. Return null kalau nomor admin belum diisi.
     */
    public static function for(User $user): ?string
    {
        $number = preg_replace('/\D+/', '', (string) config('oregonet.admin_whatsapp'));

        if ($number === '') {
            return null;
        }

        // 08xxx -> 628xxx (wa.me butuh format internasional tanpa + / 0)
        if (str_starts_with($number, '0')) {
            $number = '62' . substr($number, 1);
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

        // Nomor unit opsional (privasi), hanya ikut kalau user mengisinya.
        if ($user->apartment_unit_number) {
            $lines[] = 'Unit: ' . $user->apartment_unit_number;
        }

        $lines[] = '';
        $lines[] = 'Kendala saya: ';

        return 'https://wa.me/' . $number . '?text=' . rawurlencode(implode("\n", $lines));
    }
}
