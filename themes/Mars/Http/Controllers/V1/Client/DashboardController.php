<?php

declare(strict_types=1);

namespace Themes\Mars\Http\Controllers\V1\Client;

use Modules\Base\Http\Controllers\Web\V1\BaseController;
use Themes\Mars\Http\Resources\V1\OrderResource\OrderResource;

class DashboardController extends BaseController
{
    public function __invoke()
    {
        return view('client.dashboard');
    }
}
