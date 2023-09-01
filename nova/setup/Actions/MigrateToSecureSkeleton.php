<?php

declare(strict_types=1);

namespace Nova\Setup\Actions;

use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Lorisleiva\Actions\Concerns\AsAction;

class MigrateToSecureSkeleton
{
    use AsAction;

    public string $commandSignature = 'nova:secure-skeleton';

    protected Filesystem $disk;

    public function handle(): void
    {
        $this->disk = Storage::disk('root');

        $this->disk->makeDirectory('public');

        $this->moveFiles([
            '.htaccess',
            'index.php',
            'robots.txt',
        ], '');

        foreach (['dist', 'media'] as $directory) {
            $this->disk->makeDirectory(public_path($directory));

            $this->moveFiles($this->disk->allFiles($directory), $directory);

            foreach ($this->disk->allDirectories() as $dir) {
                $this->moveFiles(
                    $this->disk->allFiles($directory.DIRECTORY_SEPARATOR.$dir),
                    $directory.DIRECTORY_SEPARATOR.$dir
                );
            }
        }

        Artisan::call('storage:link');

        $this->disk->put(base_path('secure-skeleton.md'), '');
    }

    public function asCommand(Command $command): void
    {
        if (is_dir(base_path('public'))) {
            $command->error('A public directory already exists. Aborting migration.');
        } else {
            $this->handle();

            $command->info('Migrated to secure skeleton');
        }
    }

    protected function moveFiles(array $files, string $directory): void
    {
        foreach ($files as $file) {
            $this->disk->move(
                $directory.DIRECTORY_SEPARATOR.$file,
                public_path($directory).DIRECTORY_SEPARATOR.$file
            );
        }
    }
}
