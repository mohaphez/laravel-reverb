<?php

declare(strict_types=1);

namespace Modules\Base\Http\Controllers\API\V1;

use Illuminate\Routing\Controller as BaseController;
use Modules\Support\Traits\V1\ApiResponse\ApiResponse;

class BaseAPIController extends BaseController
{
    use ApiResponse;
}
