<?php

declare(strict_types=1);

namespace Modules\User\Data\V1;

use Carbon\Carbon;
use Modules\User\Enums\V1\AccountStatus\AccountStatus;
use Modules\User\Enums\V1\AccountType\AccountType;
use Spatie\LaravelData\Data;

class UserData extends Data
{
    public function __construct(
        public string  $name,
        public string  $email,
        public ?string $password,
        public ?AccountType $account_type,
        public ?AccountStatus $account_status,
        public ?Carbon $last_login_date,
        public ?Carbon $limitation_end_date
    ) {
    }
}
