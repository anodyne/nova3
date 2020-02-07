<?php

namespace Nova\Setup\Console\Commands;

use Illuminate\Console\Command;
use Spatie\MediaLibrary\Models\Media;

class RefreshNovaCommand extends Command
{
    protected $signature = 'nova:refresh';

    protected $description = 'Refresh the Nova installation';

    public function handle()
    {
        Media::get()->each->delete();

        $this->call('migrate:fresh', ['--seed' => true]);
        $this->call('cache:clear');
        $this->call('optimize:clear');
        $this->call('package:discover');
    }
}
