<?php

declare(strict_types=1);

namespace Modules\Support\Enums\V1\HttpMethod;

use Modules\Support\Traits\V1\CleanEnum\CleanEnum;

enum HttpMethod: string
{
    use CleanEnum;

    case POST = 'post';
    case GET = 'get';
    case PUT = 'put';
    case PATCH = 'patch';
    case DELETE = 'delete';
    case HEAD = 'head';
}
