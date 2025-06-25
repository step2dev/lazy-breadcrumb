# 🧭 Lazy Breadcrumb

> A modern, developer-first breadcrumb generator for Laravel with Blade components, SEO-ready JSON-LD, Artisan tooling, and flexible DSL/macros.

---

## 🚀 Installation

```bash
composer require step2dev/lazy-breadcrumb
```

### Optional: Publish config and views

```bash
php artisan vendor:publish --tag=lazy-breadcrumb-config
php artisan vendor:publish --tag=lazy-breadcrumb-views
```

---

## ✨ Features

- `Breadcrumbs::for()` API
- Blade components (`<x-breadcrumbs />`, `<x-breadcrumbs-json-ld />`)
- Auto-title support: `$trail->model($model)`
- Custom push: `$trail->push('Title', 'url')`
- Replacing last item: `$trail->replaceLast('New Title')`
- Copy parent trail: `$trail->import([...])`
- Macro support: `Breadcrumbs::macro('key', fn ($trail) => ...)`
- SEO-ready: JSON-LD output for search engines
- Auto-discovery: optional `route:breadcrumbs:sync`
- Full Artisan tooling

---

## 📌 Defining Breadcrumbs

Create a `routes/breadcrumbs.php` file:

```php
use Step2dev\LazyBreadcrumb\Breadcrumbs;
use Step2dev\LazyBreadcrumb\Breadcrumbs\Trail;

Breadcrumbs::for('dashboard', function (Trail $trail) {
    $trail->push(__('Dashboard'), route('dashboard'));
});

Breadcrumbs::for('profile', function (Trail $trail) {
    $trail->push(__('Dashboard'), route('dashboard'))
          ->push(__('Profile'), route('profile'));
});
```

You can also use:

```php
$trail->model($user); // Auto title from $user->name, title, or slug
$trail->replaceLast('Editing');
$trail->import([...]); // Reuse a parent breadcrumb
```

---

## 🧩 Blade Components

Use directly in any view:

```blade
<x-breadcrumbs />
<x-breadcrumbs-json-ld /> {{-- SEO only --}}
```

To customize the view, publish and modify `resources/views/components/breadcrumbs.blade.php`.

---

## 🧪 Artisan Commands

| Command                          | Description                          |
|----------------------------------|--------------------------------------|
| `make:breadcrumb name`           | Add breadcrumb entry to `routes/breadcrumbs.php` |
| `breadcrumbs:list`               | List all route-to-breadcrumb matches |
| `breadcrumbs:list --missing`     | Show named routes without breadcrumbs |
| `breadcrumbs:test`               | Run tests against all definitions    |
| `route:breadcrumbs:sync`         | Autogenerate missing breadcrumb stubs |

---

## 🧠 View Sharing

To make breadcrumbs available globally:

```php
// Middleware registration
\Step2dev\LazyBreadcrumb\Middleware\ShareBreadcrumbs::class
```

Then in views:

```blade
@foreach ($breadcrumbs as $crumb)
    <a href="{{ $crumb['url'] }}">{{ $crumb['title'] }}</a>
@endforeach
```

---

## 📦 Preset (Optional)

Register the service provider:

```php
\Step2dev\LazyBreadcrumb\LazyBreadcrumbPresetServiceProvider::class
```

Then run:

```bash
php artisan preset lazy-breadcrumb
```

---

## 🧪 Testing

```bash
composer test
```

---

## 📝 License

MIT
