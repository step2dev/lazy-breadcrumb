<?php

namespace Step2dev\LazyBreadcrumb\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Route;
use Step2dev\LazyBreadcrumb\Breadcrumbs;

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
