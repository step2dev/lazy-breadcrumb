<?php

namespace Step2Dev\LazyBreadcrumb\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Step2Dev\LazyBreadcrumb\Breadcrumbs;

class ShareBreadcrumbs
{
    public function handle(Request $request, Closure $next)
    {
        View::share('breadcrumbs', Breadcrumbs::generate());

        return $next($request);
    }
}
