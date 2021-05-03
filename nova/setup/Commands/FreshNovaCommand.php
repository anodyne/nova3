<?php

namespace Nova\Setup\Commands;

use Illuminate\Console\Command;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Throwable;

class FreshNovaCommand extends Command
{
    protected $signature = 'nova:fresh';

    public function handle()
    {
        try {
            Media::get()->each->delete();
        } catch (Throwable $th) {
            // Ignore...
        }

        $this->call('migrate:fresh', ['--seed' => true]);
        $this->call('optimize:clear');
        $this->call('package:discover');
    }
}
