<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Step2Dev\LazyBreadcrumb\Breadcrumbs;
use Step2Dev\LazyBreadcrumb\Breadcrumbs\Trail;

Route::macro('breadcrumbs', function ($callback = null) {
    /** @var LaravelRoute $this */
    // @phpstan-ignore-next-line
    $name = $this->getName();

    if ($name && is_callable($callback)) {
        Breadcrumbs::for($name, $callback);
    }

    // @phpstan-ignore-next-line
    return $this;
});

Router::macro('resourceWithBreadcrumbs', function (
    string $name,
    string $controller,
    array $options = []
) {
    /** @var Router $this */
    $routes = $this->resource($name, $controller, $options);

    $titles = $options['titles'] ?? [];

    $parts = explode('.', $name);
    $lastPart = end($parts);
    $baseTitle = $titles[$lastPart] ?? ucfirst(str_replace('_', ' ', $lastPart));

    // @phpstan-ignore-next-line
    foreach ($routes->getRoutes() as $route) {
        $routeName = $route->getName();
        if (! $routeName) {
            continue;
        }

        Breadcrumbs::for($routeName, function (Trail $trail, $params = []) use ($routeName, $parts, $titles) {
            foreach ($parts as $i => $segment) {
                $paramKey = Str::singular($segment);
                $hasParam = array_key_exists($paramKey, $params);

                $titleKey = $titles[$segment] ?? $segment;
                $title = __($titleKey);
                $urlParts = array_slice($parts, 0, $i + 1);
                $routeGuess = implode('.', $urlParts).'.index';

                $routeParams = [];
                foreach ($urlParts as $seg) {
                    $key = Str::singular($seg);
                    if (array_key_exists($key, $params)) {
                        $routeParams[$key] = $params[$key];
                    }
                }

                $trail->push($title, route($routeGuess, $routeParams));
            }

            if (str_ends_with($routeName, '.create')) {
                $trail->push('Створити', route($routeName, $params));
            } elseif (str_ends_with($routeName, '.edit')) {
                $trail->push('Редагувати', route($routeName, $params));
            } elseif (str_ends_with($routeName, '.show')) {
                $trail->push('Деталі', route($routeName, $params));
            }
        });
    }

    return $routes;
});
