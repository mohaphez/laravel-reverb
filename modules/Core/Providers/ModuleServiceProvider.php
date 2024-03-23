<?php

declare(strict_types=1);

namespace Modules\Core\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Nwidart\Modules\Laravel\Module;
use Throwable;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application service
     *
     * @return void
     */
    public function boot(): void
    {
        URL::forceRootUrl(config('app.url'));
        if (str_contains(config('app.url'), 'https://')) {
            URL::forceScheme('https');
            request()->server->set('HTTPS', 'https' === request()->header('X-Forwarded-Proto', 'https') ? 'on' : 'off');
        }

        $this->registerSentryForHandler();
    }

    /**
     * Bootstrap any application services.
     */
    public function register(): void
    {
        $this->initModules();
        $this->registerExceptions();
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
            $this->loadTranslations($module);
            $this->loadConfigs($module);
            $this->loadMigrations($module);
            $this->registerPolicies($module);
        }

    }

    /**
     * Load translations for the given module.
     */
    private function loadTranslations(Module $module): void
    {
        $translationsPath = "{$module->getPath()}/Lang";
        $this->loadTranslationsFrom($translationsPath, $module->get('alias'));
    }

    /**
     * Load configs for the given module.
     */
    private function loadConfigs(Module $module): void
    {
        $configPath = "{$module->getPath()}/Config";

        if (is_dir($configPath)) {
            collect(File::files($configPath))
                ->each(function ($file) use ($module): void {
                    $filename = $file->getFilenameWithoutExtension();
                    $moduleConfig = include $file->getPathname();

                    $currentConfig = config($filename) ?? [];

                    $newConfig = array_merge($currentConfig, $moduleConfig);

                    config([$filename => $newConfig]);
                });
        }
    }

    /**
     * Load migrations for the given module.
     */
    private function loadMigrations(Module $module): void
    {
        $this->loadMigrationsFrom("{$module->getPath()}/Database/Migrations");
    }

    /**
     * Register Module policies
     */
    private function registerPolicies(Module $module): void
    {
        $policy_path = "{$module->getPath()}/Policies";

        if ( ! file_exists($policy_path)) {
            return;
        }

        $policies = scandir($policy_path);

        foreach ($policies as $policy) {
            if ( ! preg_match('/^(.+)\.php$/', $policy, $matches)) {
                continue;
            }

            $policy_class = "Modules\\{$module->getStudlyName()}\\Policies\\{$matches[1]}";

            if ( ! class_exists($policy_class)) {
                continue;
            }

            $target_entity = $policy_class::$entity;

            if (isset($target_entity) && class_exists($target_entity)) {
                Gate::policy($target_entity, $policy_class);
            }
        }
    }


    /**
     * Register the exception handling callbacks for the application.
     */
    private function registerExceptions(): void
    {
        $this->app->bind(
            \Illuminate\Contracts\Debug\ExceptionHandler::class,
            \Modules\Core\Exceptions\BaseExceptionHandler::class
        );
    }

    private function registerSentryForHandler(): void
    {
        $this->app->make('Illuminate\Contracts\Debug\ExceptionHandler')->reportable(
            function (Throwable $e): void {
                if (app()->bound('sentry')) {
                    app('sentry')->captureException($e);
                }
            }
        );
    }
}
