<?php

namespace Database\Seeders;

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
            'id' => 1,
            'name' => 'Julio Acosta',
            'email' => 'julio.acosta@gmail.com',
            'phone' => '7777-8888',
        ]);

        Customer::create([
            'id' => 2,
            'name' => 'María Cartagena',
            'email' => 'maria.cartagena@gmail.com',
            'phone' => '7666-9999',
        ]);

        Customer::create([
            'id' => 3,
            'name' => 'Sebastian Martínez',
            'email' => 'sebastian.martinez@hotmail.com',
            'phone' => null,
        ]);
    }
}
