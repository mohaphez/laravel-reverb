<?php

declare(strict_types=1);

namespace Modules\Travel\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Travel\Database\Seeders\V1\TravelTableSeeder;

class TravelDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Model::unguard();

        $this->call(TravelTableSeeder::class);
    }
}
