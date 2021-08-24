<?php

declare(strict_types=1);

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
            // Don't do anything
        }

        $this->call('migrate:fresh', ['--seed' => true]);
        $this->call('cache:clear');
        $this->call('optimize:clear');
        $this->call('package:discover');
    }
}
