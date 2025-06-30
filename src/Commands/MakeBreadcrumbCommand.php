<?php

namespace Step2Dev\LazyBreadcrumb\Commands;

use Illuminate\Console\Command;

class MakeBreadcrumbCommand extends Command
{
    protected $signature = 'make:breadcrumb {name : The route name for the breadcrumb}';

    protected $description = 'Create a breadcrumb entry in routes/breadcrumbs.php';

    final public function handle(): void
    {
        $name = $this->argument('name');
        $file = base_path('routes/breadcrumbs.php');

        if (! file_exists($file)) {
            file_put_contents($file, "<?php\n\nuse Step2dev\\LazyBreadcrumb\\Breadcrumbs;\nuse Step2dev\\LazyBreadcrumb\\Breadcrumbs\\Trail;\n\n");
            $this->info('Created routes/breadcrumbs.php');
        }

        $stub = <<<EOT

Breadcrumbs::for('{$name}', function (Trail \$trail) {
    \$trail->push(__('Breadcrumb Title'), route('{$name}'));
});
EOT;

        file_put_contents($file, $stub.PHP_EOL, FILE_APPEND);

        $this->info("Breadcrumb '{$name}' added to routes/breadcrumbs.php");
    }
}
