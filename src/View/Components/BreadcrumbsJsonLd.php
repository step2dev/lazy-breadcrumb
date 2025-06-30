<?php

namespace Step2Dev\LazyBreadcrumb\View\Components;

use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;
use Step2Dev\LazyBreadcrumb\Breadcrumbs;

class BreadcrumbsJsonLd extends Component
{
    public string $json;

    public function __construct()
    {
        $this->json = Breadcrumbs::renderJsonLd(
            Route::current()?->getName(),
            Route::current()?->parameters() ?? []
        );
    }

    public function render()
    {
        return function () {
            return $this->json;
        };
    }
}
