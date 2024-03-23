<?php

declare(strict_types=1);

namespace Modules\Travel\Database\Seeders\V1;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\Travel\Enums\V1\TravelStatus\TravelStatus;

class TravelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Model::unguard();

        if (0 === DB::table(travel()->getTable())->count()) {
            $driver = user()->where('email', 'driver@example.com')->first();
            $passenger = user()->where('email', 'passenger@example.com')->first();

            travel()->create(
                [
                    'passenger_id'  => $driver->id,
                    'driver_id'     => $passenger->id,
                    'tracking_code' => Str::uuid(),
                    'status'        => TravelStatus::Accepted,
                ],
            );
        }

    }
}
