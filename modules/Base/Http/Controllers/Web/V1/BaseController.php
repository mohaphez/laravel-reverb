<?php

declare(strict_types=1);

namespace Modules\Base\Http\Controllers\Web\V1;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;

class BaseController extends Controller
{
    use AuthorizesRequests;
    use ValidatesRequests;
}
