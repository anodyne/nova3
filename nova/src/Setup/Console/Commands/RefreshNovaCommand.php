<?php

namespace Nova\Setup\Console\Commands;

use Illuminate\Console\Command;

class RefreshNovaCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nova:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh the Nova installation';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->call('migrate:fresh', ['--seed' => true]);
        $this->call('cache:clear');
        $this->call('optimize:clear');
        $this->call('package:discover');
    }
}
