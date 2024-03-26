<?php

declare(strict_types=1);

namespace Themes\Mars\Http\Controllers\V1\Travel;

use Modules\Base\Http\Controllers\Web\V1\BaseController;
use Themes\Mars\Http\Resources\V1\OrderResource\OrderResource;

class TravelController extends BaseController
{
    public function show()
    {
        return view('travel.index');
    }
}
