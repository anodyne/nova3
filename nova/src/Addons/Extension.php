<?php

declare(strict_types=1);

namespace Nova\Addons;

use Illuminate\Support\Facades\Artisan;

abstract class Extension extends BaseAddon
{
    public function hasMigrations(): bool
    {
        return is_dir(addon_path($this->location.DIRECTORY_SEPARATOR.'Migrations'));
    }

    public function install(): void {}

    public function uninstall(): void {}

    public function update(): void {}

    public function settingsForm(): array
    {
        return [];
    }

    public function rollbackMigrations(): void
    {
        Artisan::call('migrate:rollback', [
            '--force' => true,
            '--path' => 'addons/'.$this->location.'/Migrations',
        ]);
    }

    public function runMigrations(): void
    {
        Artisan::call('migrate', [
            '--force' => true,
            '--path' => 'addons/'.$this->location.'/Migrations',
        ]);
    }

    final public function runScript(string $name): void
    {
        if (method_exists($this, $name)) {
            $this->{$name}();

            $event = match ($name) {
                'rollbackMigrations' => 'ran-migrations-rollback',
                'runMigrations' => 'ran-migrations',
                default => "ran-{$name}",
            };

            activity()
                ->performedOn($this->getModel())
                ->event($event)
                ->log($event);
        }
    }
}
