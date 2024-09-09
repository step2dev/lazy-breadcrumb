<?php

namespace Step2Dev\LazyBreadcrumb\Tests;

use Illuminate\Support\Facades\Config;
use PHPUnit\Framework\TestCase;
use Step2Dev\LazyBreadcrumb\LazyBreadcrumb;

class LazyBreadcrumbTest extends TestCase
{
    public function testInitialBreadcrumbs()
    {
        $breadcrumbs = new LazyBreadcrumb();
        $this->assertEquals(Config::get('lazy_breadcrumb.default'), $breadcrumbs->getBreadcrumbs());
    }

    public function testAddBreadcrumb()
    {
        $breadcrumbs = new LazyBreadcrumb();
        $breadcrumbs->add('/new-url', 'New Label');

        $this->assertEquals([
            Config::get('lazy_breadcrumb.default'),
            [
                'url'   => '/new-url',
                'label' => 'New Label',
            ],
        ], $breadcrumbs->getBreadcrumbs());
    }
}
