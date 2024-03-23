<?php

declare(strict_types=1);

namespace Modules\Travel\Enums\V1\TravelStatus;

use Modules\Support\Traits\V1\CleanEnum\CleanEnum;

enum TravelStatus: int
{
    use CleanEnum;

    case Accepted = 0;
    case Canceled = 1;
}
