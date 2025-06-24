<?php

namespace Step2Dev\LazyBreadcrumb\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;
use Step2dev\LazyBreadcrumb\Breadcrumbs;

class ListBreadcrumbsCommand extends Command
{
    protected $signature = 'breadcrumbs:list {--missing : Show only routes without breadcrumbs}';
    protected $description = 'List all named routes and whether they have breadcrumbs';

    public function handle(): void
    {
        $routes = collect(Route::getRoutes())->filter(fn ($route) => $route->getName());

        if ($this->option('missing')) {
            $routes = $routes->filter(fn ($route) => !Breadcrumbs::has($route->getName()));
        }

        $this->table(
            ['Route name', 'Breadcrumb'],
            $routes->map(fn ($route) => [
                $route->getName(),
                Breadcrumbs::has($route->getName()) ? '✅ defined' : '❌ missing',
            ])
        );
    }
}
