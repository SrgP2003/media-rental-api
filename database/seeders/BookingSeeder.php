<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Booking;
use App\Models\Media;
use App\Models\Customer;
use Carbon\Carbon;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $media = Media::first();
        $customer = Customer::first();

        if (!$media || !$customer) {
            return; //No hay medios publicitarios o clientes disponibles para crear reservas.
        }

        Booking::create([
            'media_id' => $media->id,
            'customer_id' => $customer->id,
            'starts_at' => Carbon::now()->addDays(1),
            'ends_at' => Carbon::now()->addDays(5),
            'total_price' => Booking::calculatePriceFromDates( //Para 5 dias de reserva
                Carbon::now()->addDays(1),
                Carbon::now()->addDays(5),
                $media->price_per_day
            ),
            'status' => 'confirmed',
        ]);
    }
}
