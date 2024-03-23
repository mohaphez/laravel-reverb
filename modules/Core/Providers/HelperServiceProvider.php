<?php

declare(strict_types=1);

namespace Modules\Core\Providers;

use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{
    /**
     * Register all helper functions
     */
    public function register(): void
    {
        $allHelperFiles = glob(base_path('modules/*/Helpers/*.php'));

        foreach ($allHelperFiles as $key => $helperFile) {
            require_once $helperFile;
        }
    }
}
