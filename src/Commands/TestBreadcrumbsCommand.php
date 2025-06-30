<?php

namespace Step2Dev\LazyBreadcrumb\Commands;

use Illuminate\Console\Command;
use Step2Dev\LazyBreadcrumb\Breadcrumbs;

class TestBreadcrumbsCommand extends Command
{
    protected $signature = 'breadcrumbs:test';

    protected $description = 'Test all registered breadcrumb definitions';

    final public function handle(): void
    {
        $all = Breadcrumbs::all();
        $failures = [];

        foreach ($all as $name) {
            try {
                $items = Breadcrumbs::generate($name);
                if (! is_array($items)) {
                    $failures[] = [$name, 'Returned non-array'];
                }
            } catch (\Throwable $e) {
                $failures[] = [$name, $e->getMessage()];
            }
        }

        if (count($failures)) {
            $this->table(['Route', 'Error'], $failures);
            $this->error(count($failures).' failed.');
        } else {
            $this->info('✅ All breadcrumbs passed');
        }
    }
}
