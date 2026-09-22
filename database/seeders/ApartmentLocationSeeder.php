<?php

namespace Database\Seeders;

use App\Models\ApartmentLocation;
use Illuminate\Database\Seeder;

class ApartmentLocationSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'Apartemen Taman Anggrek' => [
                'Tower Azalea', 'Tower Beech', 'Tower Calypso',
                'Tower Daffodil', 'Tower Espiritu', 'Tower Fragrant',
            ],
            'Apartemen Menara Jakarta' => [
                'Tower Azure', 'Tower Breeze', 'Tower Celestial',
                'Tower Destiny', 'Tower Equinox', 'Tower Fortune',
            ],
        ];

        foreach ($data as $locationName => $towers) {
            $location = ApartmentLocation::create(['name' => $locationName]);

            foreach ($towers as $towerName) {
                $location->towers()->create(['name' => $towerName]);
            }
        }
    }
}
