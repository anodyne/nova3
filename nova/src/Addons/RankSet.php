<?php

declare(strict_types=1);

namespace Nova\Addons;

use Illuminate\Contracts\Filesystem\Filesystem as FilesystemContract;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;

abstract class RankSet extends BaseAddon
{
    public function append(): void
    {
        $disk = $this->addonDisk();

        $files = new Filesystem;

        foreach ($disk->allFiles() as $file) {
            $filename = str($file)->remove('ranks'.DIRECTORY_SEPARATOR)->toString();

            if (! file_exists(rank_path($filename))) {
                $files->copy(
                    addon_path($this->location.DIRECTORY_SEPARATOR.$file),
                    rank_path($filename)
                );
            }
        }
    }

    public function install(): void
    {
        $this->uninstall();

        $disk = $this->addonDisk();

        $directories = $disk->directories('ranks');

        $files = new Filesystem;

        foreach ($directories as $directory) {
            $files->copyDirectory(
                addon_path($this->location.DIRECTORY_SEPARATOR.$directory),
                rank_path(str($directory)->remove('ranks'.DIRECTORY_SEPARATOR)->toString())
            );
        }
    }

    public function replace(): void
    {
        $disk = $this->addonDisk();

        $files = new Filesystem;

        foreach ($disk->allFiles() as $file) {
            $filename = str($file)->remove('ranks'.DIRECTORY_SEPARATOR)->toString();

            if (file_exists(rank_path($filename))) {
                $files->copy(
                    addon_path($this->location.DIRECTORY_SEPARATOR.$file),
                    rank_path($filename)
                );
            }
        }
    }

    public function uninstall(): void
    {
        $disk = $this->ranksDisk();

        $disk->delete($disk->allFiles());

        collect($disk->allDirectories())->each(fn (string $dir): bool => $disk->deleteDirectory($dir));
    }

    protected function addonDisk(): FilesystemContract
    {
        return Storage::build([
            'driver' => 'local',
            'root' => addon_path($this->location),
        ]);
    }

    protected function ranksDisk(): FilesystemContract
    {
        return Storage::disk('ranks');
    }
}
