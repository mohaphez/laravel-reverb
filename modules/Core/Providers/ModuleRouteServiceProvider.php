<?php

declare(strict_types=1);

namespace Modules\Core\Providers;

use Illuminate\Http\Request;
use Nwidart\Modules\Laravel\Module;
use Illuminate\Support\Facades\Route;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class ModuleRouteServiceProvider extends ServiceProvider
{
    /**
     * Define the routes for the application.
     */
    public function map(): void
    {
        RateLimiter::for('api', fn (Request $request) => Limit::perMinute(60)->by($request->user()?->id ?: $request->ip()));

        $this->initModules();
    }

    /**
     * Initialize specified list of modules.
     *
     * @note if module list not specified, all enabled modules will list.
     */
    private function initModules(): void
    {
        $modules = $this->app['modules']->allEnabled();

        foreach ($modules as $module) {
            $this->mapModuleRoutes($module);
        }
    }

    /**
     * Map routes of the given module.
     */
    private function mapModuleRoutes(Module $module): void
    {
        $base = $module->getPath();
        $this->mapPublicRoutes("{$base}/Routes/web.php");
        $this->mapApiRoutes("{$base}/Routes/api.php");
        $this->mapChannelRoutes("{$base}/Routes/channel.php");
    }

    /**
     * Map public routes.
     */
    private function mapPublicRoutes(string $path): void
    {
        if ( ! file_exists($path)) {
            return;
        }

        Route::group(
            [
                'middleware' => ['web'],
            ],
            fn () => require $path,
        );
    }

    /**
     * Map api routes.
     */
    private function mapApiRoutes($path): void
    {
        if ( ! file_exists($path)) {
            return;
        }

        Route::group(
            [
                'prefix'     => 'api',
                'middleware' => ['api'],
            ],
            fn () => require $path,
        );
    }

    /**
     * Map channel routes.
     */
    private function mapChannelRoutes($path): void
    {
        if ( ! file_exists($path)) {
            return;
        }

        Route::group(
            [
                'prefix' => 'api',
            ],
            fn () => require $path,
        );
    }
}
