<?php

declare(strict_types=1);

namespace Themes\Mars\Http\Controllers\V1\Document;

use Modules\Base\Http\Controllers\Web\V1\BaseController;

class DocumentController extends BaseController
{
    public function document()
    {
        return view('document.index');
    }
}
