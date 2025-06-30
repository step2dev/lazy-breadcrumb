<?php

namespace Step2Dev\LazyBreadcrumb;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use Step2Dev\LazyBreadcrumb\Breadcrumbs\Trail;

class Breadcrumbs
{
    private static array $definitions = [];

    public static function for(string $name, \Closure $callback): void
    {
        static::$definitions[$name] = $callback;
    }

    public static function generate(?string $name = null, array $params = []): array
    {
        $name ??= Route::current()?->getName();
        if (! $name || ! isset(static::$definitions[$name])) {
            return [];
        }

        $trail = new Trail;
        static::$definitions[$name]($trail, $params);

        return $trail->get();
    }

    public static function renderJsonLd(?string $name = null, array $params = []): string
    {
        $items = static::generate($name, $params);

        $structured = [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => [],
        ];

        foreach ($items as $i => $crumb) {
            $structured['itemListElement'][] = [
                '@type' => 'ListItem',
                'position' => $i + 1,
                'name' => $crumb['title'],
                'item' => $crumb['url'],
            ];
        }

        return '<script type="application/ld+json">'.
            json_encode($structured, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
            .'</script>';
    }

    public static function toArray(?string $name = null, array $params = []): array
    {
        return static::generate($name, $params);
    }

    public static function toCollection(?string $name = null, array $params = []): Collection
    {
        return collect(static::generate($name, $params));
    }

    public static function has(?string $name = null): bool
    {
        $name ??= Route::current()?->getName();

        return $name && array_key_exists($name, static::$definitions);
    }

    public static function all(): array
    {
        return array_keys(static::$definitions);
    }

    public function import(array $breadcrumbs): static
    {
        foreach ($breadcrumbs as $crumb) {
            $this->breadcrumbs[] = $crumb;
        }

        return $this;
    }

    public static function macro(string $name, \Closure $callback): void
    {
        self::$definitions[$name] = $callback;
    }
}
