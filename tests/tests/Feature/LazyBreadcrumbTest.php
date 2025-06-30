<?php

use Illuminate\Support\Facades\Route;
use Step2dev\LazyBreadcrumb\Breadcrumbs as BreadcrumbsGenerator;
use Step2Dev\LazyBreadcrumb\Facades\LazyBreadcrumb;
use Step2Dev\LazyBreadcrumb\View\Components\Breadcrumbs;
use Step2Dev\LazyBreadcrumb\View\Components\BreadcrumbsJsonLd;

it('renders the blade components', function () {
    $breadcrumbsComponent = new Breadcrumbs();
    $jsonLdComponent = new BreadcrumbsJsonLd([]);

    expect($breadcrumbsComponent->render())->not()->toBeNull()
        ->and($jsonLdComponent->render())->not()->toBeNull();
});

it('runs the test artisan command', function () {
    $this
        ->artisan('breadcrumbs:test')
        ->assertExitCode(0);
});

it('resolves the facade', function () {
    expect(LazyBreadcrumb::class)->toBeString()
        ->and(app(LazyBreadcrumb::class))->toBeInstanceOf(BreadcrumbsGenerator::class);
});

it('registers route macro', function () {
    Route::breadcrumbs(function () {
        return ['Dashboard'];
    });

    expect(Route::getMacro('breadcrumbs'))->not()->toBeNull();
});
