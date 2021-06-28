<?php

namespace Nova\Foundation\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Application;
use Nova\Foundation\Nova;

class SupportDetails extends Command
{
    protected $signature = 'nova:support-details';

    protected $description = 'Outputs details helpful for support requests.';

    public function handle()
    {
        $this->line(sprintf('<info>Nova</info> %s', Nova::version()));
        $this->line(sprintf('<info>Laravel</info> %s', Application::VERSION));
        $this->line(sprintf('<info>PHP</info> %s', phpversion()));
        $this->extensions();
    }

    private function extensions()
    {
        return $this->line('No addons installed');

        // foreach ($addons as $addon) {
        //     $this->line(sprintf('<info>%s</info> %s', $addon->package(), $addon->version()));
        // }
    }
}
