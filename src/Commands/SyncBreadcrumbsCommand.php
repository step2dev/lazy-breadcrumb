<?php

namespace Step2Dev\LazyBreadcrumb\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;
use Illuminate\Filesystem\Filesystem;
use Step2dev\LazyBreadcrumb\Breadcrumbs;

class SyncBreadcrumbsCommand extends Command
{
    protected $signature = 'route:breadcrumbs:sync {--force : Overwrite existing routes/breadcrumbs.php file}';
    protected $description = 'Generate breadcrumbs stubs for all named routes not yet defined';

    public function handle(): void
    {
        $fs = new Filesystem();
        $path = base_path('routes/breadcrumbs.php');

        if (!$fs->exists($path)) {
            $fs->put($path, "<?php\n\nuse Step2dev\\LazyBreadcrumb\\Breadcrumbs;\nuse Step2dev\\LazyBreadcrumb\\Breadcrumbs\\Trail;\n");
            $this->info('Created routes/breadcrumbs.php');
        } elseif (!$this->option('force')) {
            $this->info('Breadcrumbs file exists. Use --force to regenerate.');
        }

        $existing = file_get_contents($path);
        $added = 0;

        foreach (Route::getRoutes() as $route) {
            $name = $route->getName();
            if (!$name || Breadcrumbs::has($name) || str_contains($existing, "Breadcrumbs::for('{$name}'")) {
                continue;
            }

            $stub = <<<EOT

Breadcrumbs::for('{$name}', function (Trail \$trail) {
    \$trail->push(__('Breadcrumb Title'), route('{$name}'));
});
EOT;

            $fs->append($path, $stub . PHP_EOL);
            $added++;
        }

        $this->info("✅ Added {$added} breadcrumb definitions.");
    }
}
