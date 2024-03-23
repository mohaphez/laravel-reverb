<?php

declare(strict_types=1);

namespace Modules\Support\Http\Middleware\V1\ForcedJsonHeaders;

use Closure;
use Illuminate\Http\Request;
use Modules\Base\Http\Middleware\V1\Api\BaseApiMiddleware;

class ForcedJsonHeaders extends BaseApiMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $request->headers->set('Accept', 'application/json');
        $request->headers->set('Content-Type', 'application/json');

        return $next($request);
    }
}
