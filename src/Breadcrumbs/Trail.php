<?php

namespace Step2Dev\LazyBreadcrumb\Breadcrumbs;

use Illuminate\Database\Eloquent\Model;

class Trail
{
    protected array $breadcrumbs = [];

    public function push(string $title, string $url): static
    {
        $this->breadcrumbs[] = compact('title', 'url');
        return $this;
    }

    public function get(): array
    {
        return $this->breadcrumbs;
    }

    public function model(Model $model, ?string $url = null): static
    {
        $title = $model->name ?? $model->title ?? $model->slug ?? '…';
        $url ??= url()->current();
        return $this->push($title, $url);
    }

    public function replaceLast(string $title): static
    {
        if (!empty($this->breadcrumbs)) {
            $this->breadcrumbs[array_key_last($this->breadcrumbs)]['title'] = $title;
        }
        return $this;
    }
}
