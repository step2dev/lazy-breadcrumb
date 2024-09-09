<?php

namespace Step2Dev\LazyBreadcrumb;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Step2Dev\LazyBreadcrumb\Commands\LazyBreadcrumbCommand;

class LazyBreadcrumbServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('lazy-breadcrumb')
            ->hasConfigFile();
//            ->hasViews()
//            ->hasMigration('create_lazy_breadcrumb_table')
//            ->hasCommand(LazyBreadcrumbCommand::class);
    }
}
