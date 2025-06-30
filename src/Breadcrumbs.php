<?php

namespace Step2Dev\LazyBreadcrumb;

use Closure;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use Step2Dev\LazyBreadcrumb\Breadcrumbs\Trail;

class Breadcrumbs
{
    private static array $definitions = [];

    public static function for(string $name, Closure $callback): void
    {
        self::$definitions[$name] = $callback;
    }

    public static function generate(?string $name = null, array $params = []): array
    {
        $name ??= Route::current()?->getName();
        if (! $name || ! isset(self::$definitions[$name])) {
            return [];
        }

        $trail = new Trail;
        self::$definitions[$name]($trail, $params);

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

        return $name && array_key_exists($name, self::$definitions);
    }

    public static function all(): array
    {
        return array_keys(self::$definitions);
    }

    public static function macro(string $name, Closure $callback): void
    {
        self::$definitions[$name] = $callback;
    }
}
