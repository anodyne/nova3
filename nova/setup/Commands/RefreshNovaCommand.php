<?php

namespace Nova\Setup\Commands;

use Illuminate\Console\Command;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Throwable;

class RefreshNovaCommand extends Command
{
    protected $signature = 'nova:refresh';

    public function handle()
    {
        try {
            Media::get()->each->delete();
        } catch (Throwable $th) {
            // Ignore...
        }

        $this->call('migrate-data:rollback');

        $this->call('migrate:fresh', ['--seed' => true]);
        $this->call('optimize:clear');
        $this->call('package:discover');
    }
}
