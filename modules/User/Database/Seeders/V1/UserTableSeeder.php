<?php

declare(strict_types=1);

namespace Modules\User\Database\Seeders\V1;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\User\Enums\V1\AccountStatus\AccountStatus;
use Modules\User\Enums\V1\AccountType\AccountType;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Model::unguard();

        if (0 === DB::table(user()->getTable())->count()) {
            user()->create(
                [
                    'name'           => 'Uber Driver',
                    'email'          => 'admin@example.com',
                    'password'       => bcrypt('password'),
                    'account_type'   => AccountType::Sudo,
                    'account_status' => AccountStatus::Free,
                ],
            );

            user()->create(
                [
                    'name'           => 'Uber Driver',
                    'email'          => 'driver@example.com',
                    'password'       => bcrypt('password'),
                    'account_type'   => AccountType::Sudo,
                    'account_status' => AccountStatus::Free,
                ],
            );

            user()->create(
                [
                    'name'           => 'Uber Passenger',
                    'email'          => 'passenger@example.com',
                    'password'       => bcrypt('password'),
                    'account_type'   => AccountType::Sudo,
                    'account_status' => AccountStatus::Free,
                ],
            );
        }

    }
}
