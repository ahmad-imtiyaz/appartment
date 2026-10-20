<?php

namespace Database\Seeders;

use App\Models\LegalDocument;
use Illuminate\Database\Seeder;

class LegalDocumentSeeder extends Seeder
{
    public function run(): void
    {
        LegalDocument::firstOrCreate(['type' => 'terms'], [
            'title'   => 'Syarat dan Ketentuan',
            'summary' => 'Aturan penggunaan layanan Oregonet.',
            'content' => 'Isi Syarat dan Ketentuan. Silakan ubah dari dasbor admin.',
        ]);

        LegalDocument::firstOrCreate(['type' => 'privacy'], [
            'title'   => 'Kebijakan Privasi',
            'summary' => 'Cara data pribadi Anda dikelola.',
            'content' => 'Isi Kebijakan Privasi. Silakan ubah dari dasbor admin.',
        ]);
    }
}
