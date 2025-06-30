<?php

namespace Step2Dev\LazyBreadcrumb\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Step2Dev\LazyBreadcrumb\LazyBreadcrumb
 */
class LazyBreadcrumb extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        // @phpstan-ignore-next-line
        return \Step2Dev\LazyBreadcrumb\Breadcrumbs::class;
    }
}
