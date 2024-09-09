<?php

namespace Step2Dev\LazyBreadcrumb\Commands;

use Illuminate\Console\Command;

class LazyBreadcrumbCommand extends Command
{
    public $signature = 'lazy-breadcrumb';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
