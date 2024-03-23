<?php

declare(strict_types=1);

namespace Modules\Support\Enums\V1\EntityList;

use Modules\Support\Traits\V1\CleanEnum\CleanEnum;

enum EntityList: int
{
    use CleanEnum;

    case Shared = 0;
    case Land = 1;
    case Product = 2;
}
