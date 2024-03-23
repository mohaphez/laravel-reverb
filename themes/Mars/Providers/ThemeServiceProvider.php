<?php

namespace Themes\Mars\Providers;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\Livewire;
use ReflectionClass;
use Symfony\Component\Finder\SplFileInfo;

class ThemeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application service.
     */
    public function boot(): void
    {
    }

}
