<?php

namespace App\Services;

class UserWhatsappLink
{
    /**
     * Link wa.me ke nomor user. Return null kalau nomor kosong/tidak valid.
     */
    public static function for(?string $phone, ?string $message = null): ?string
    {
        $number = preg_replace('/\D+/', '', (string) $phone);

        if ($number === '') {
            return null;
        }

        // 08xxx -> 628xxx, 8xxx -> 628xxx, 62xxx tetap
        if (str_starts_with($number, '0')) {
            $number = '62' . substr($number, 1);
        } elseif (str_starts_with($number, '8')) {
            $number = '62' . $number;
        }

        // Sanity check: nomor Indonesia umumnya 10-15 digit termasuk 62
        if (! str_starts_with($number, '62') || strlen($number) < 10 || strlen($number) > 15) {
            return null;
        }

        $url = 'https://wa.me/' . $number;

        return $message ? $url . '?text=' . rawurlencode($message) : $url;
    }
}