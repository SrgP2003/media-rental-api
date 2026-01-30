<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Media;

class MediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Media::create([
            'name' => 'Valla Centro Histórico',
            'type' => 'billboard',
            'location' => 'San Salvador',
            'dimensions' => '10x5',
            'price_per_day' => 75.00,
            'status' => 'active',
        ]);

        Media::create([
            'name' => 'Pantalla LED Escalón',
            'type' => 'screen',
            'location' => 'Colonia Escalón',
            'dimensions' => '6x4',
            'price_per_day' => 120.00,
            'status' => 'active',
        ]);

        Media::create([
            'name' => 'Mupi Zona Rosa',
            'type' => 'mupi',
            'location' => 'Zona Rosa',
            'dimensions' => '2x1',
            'price_per_day' => 35.00,
            'status' => 'inactive',
        ]);
    }
}
