<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::create([
            'name' => 'Juan Pérez',
            'email' => 'juan.perez@gmail.com',
            'phone' => '7777-8888',
        ]);

        Customer::create([
            'name' => 'María Cartagena',
            'email' => 'maria.cartagena@gmail.com',
            'phone' => '7666-9999',
        ]);

        Customer::create([
            'name' => 'Sebastian Martínez',
            'email' => 'sebastian.martinez@hotmail.com',
            'phone' => null,
        ]);
    }
}
