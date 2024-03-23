<?php

declare(strict_types=1);

namespace Modules\Support\Enums\V1\Status;

use Modules\Support\Traits\V1\CleanEnum\CleanEnum;

enum Status: int
{
    use CleanEnum;

    case Inactive = 0;
    case Active = 1;
}
