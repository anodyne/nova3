<?php

declare(strict_types=1);

namespace Nova\Addons\Concerns;

use Illuminate\Contracts\Filesystem\Filesystem as FilesystemContract;
use Illuminate\Support\Facades\Storage;

trait MovesRankImages
{
    public function appendImages(): void
    {
        $addonDisk = $this->addonDisk();
        $ranksDisk = $this->ranksDisk();

        foreach ($addonDisk->allFiles('ranks') as $file) {
            $filename = str($file)->remove('ranks'.DIRECTORY_SEPARATOR)->toString();

            if (! $ranksDisk->exists($filename)) {
                $ranksDisk->put(
                    $filename,
                    $addonDisk->get($file)
                );
            }
        }
    }

    public function replaceImages(): void
    {
        $addonDisk = $this->addonDisk();
        $ranksDisk = $this->ranksDisk();

        foreach ($addonDisk->allFiles('ranks') as $file) {
            $filename = str($file)->remove('ranks'.DIRECTORY_SEPARATOR)->toString();

            if ($ranksDisk->exists($filename)) {
                $ranksDisk->put(
                    $filename,
                    $addonDisk->get($file)
                );
            }
        }
    }

    public function installRankImages(): void
    {
        $addonDisk = $this->addonDisk();
        $ranksDisk = $this->ranksDisk();

        foreach ($addonDisk->allFiles('ranks') as $file) {
            $filename = str($file)->remove('ranks'.DIRECTORY_SEPARATOR)->toString();

            $ranksDisk->put(
                $filename,
                $addonDisk->get($file)
            );
        }
    }

    public function uninstallRankImages(): void
    {
        $disk = $this->ranksDisk();

        $disk->delete($disk->allFiles());

        collect($disk->allDirectories())->each(
            fn (string $dir): bool => $disk->deleteDirectory($dir)
        );
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
