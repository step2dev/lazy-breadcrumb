<?php

namespace Step2Dev\LazyBreadcrumb;

use Illuminate\Support\Facades\Blade;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Step2Dev\LazyBreadcrumb\Commands\ListBreadcrumbsCommand;
use Step2Dev\LazyBreadcrumb\Commands\MakeBreadcrumbCommand;
use Step2Dev\LazyBreadcrumb\Commands\SyncBreadcrumbsCommand;
use Step2dev\LazyBreadcrumb\Commands\TestBreadcrumbsCommand;
use Step2dev\LazyBreadcrumb\View\Components\BreadcrumbsJsonLd;

class LazyBreadcrumbServiceProvider extends PackageServiceProvider
{
    final public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('lazy-breadcrumb')
            ->hasConfigFile()
            ->hasViews()
//            ->hasMigration('create_lazy_breadcrumb_table')
            ->hasCommand(ListBreadcrumbsCommand::class)
            ->hasCommand(MakeBreadcrumbCommand::class)
            ->hasCommand(SyncBreadcrumbsCommand::class)
        ;
//            ->hasCommand(LazyBreadcrumbCommand::class);

        $this->registerMacros();

        Blade::component('breadcrumbs', Breadcrumbs::class);
        Blade::component('breadcrumbs-json-ld', BreadcrumbsJsonLd::class);
    }

    final protected function registerMacros(): void
    {
        require_once __DIR__.'/Breadcrumbs/RouteMacro.php';
    }

    final public function bootingPackage(): void
    {
        if (file_exists(base_path('routes/breadcrumbs.php'))) {
            require base_path('routes/breadcrumbs.php');
        }
    }
}
