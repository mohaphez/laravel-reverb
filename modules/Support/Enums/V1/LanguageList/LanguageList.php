<?php

declare(strict_types=1);

namespace Modules\Support\Enums\V1\LanguageList;

use Modules\Support\Traits\V1\CleanEnum\CleanEnum;

enum LanguageList: string
{
    use CleanEnum;

    case English = 'en';
    case Dutch = 'nl';
    case Germany = 'de';
}
