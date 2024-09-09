<?php

namespace Step2Dev\LazyBreadcrumb;

class LazyBreadcrumb
{
    /**
     * @var array|array[]
     */
    private array $breadcrumbs;

    public function __construct()
    {
        $this->breadcrumbs = (array) config('lazy-breadcrumb.default', []);
    }

    public function add(string|null $url, string|null $label): static
    {
        if (! $url && ! $label) {
            return $this;
        }

        $this->breadcrumbs[] = array_filter(compact('url', 'label'));

        return $this;
    }

    public function getBreadcrumbs(): array
    {
        return $this->breadcrumbs;
    }
}
