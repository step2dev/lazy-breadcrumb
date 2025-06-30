<?php

namespace Step2Dev\LazyBreadcrumb\View\Components;

use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;
use Step2Dev\LazyBreadcrumb\Breadcrumbs as BreadcrumbsGenerator;

class Breadcrumbs extends Component
{
    public array $breadcrumbs = [];

    public function __construct()
    {
        $this->breadcrumbs = BreadcrumbsGenerator::generate(
            Route::current()?->getName(),
            Route::current()?->parameters() ?? []
        );
    }

    public function render()
    {
        return view(config('breadcrumbs.view', 'breadcrumbs::components.breadcrumbs'));
    }
}
