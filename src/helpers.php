<?php

use Step2Dev\LazyBreadcrumb\LazyBreadcrumb;

if (! function_exists('breadcrumbs')) {
    /**
     * Generate breadcrumbs.
     *
     * @return LazyBreadcrumb
     */
    function breadcrumbs(): LazyBreadcrumb
    {
        return new LazyBreadcrumb();
    }
}
