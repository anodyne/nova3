<?php

declare(strict_types=1);

namespace Nova\Dashboards\Livewire;

use Illuminate\Foundation\Console\DownCommand;
use Illuminate\Foundation\Console\UpCommand;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Livewire\Component;
use Nova\Foundation\Filament\Notifications\Notification;

class MaintenanceModeSwitch extends Component
{
    public bool $maintenance;

    public function updatedMaintenance($value): void
    {
        if ($value === true) {
            $secret = Str::uuid();

            Artisan::call(DownCommand::class, [
                '--secret' => $secret,
                '--render' => 'maintenance',
            ]);

            Notification::make()->success()
                ->title('Maintenance mode has been turned on')
                ->body('Your site is now down for maintenance and cannot be accessed by users.')
                ->send();

            $this->redirect("/{$secret}");
        } else {
            Artisan::call(UpCommand::class);

            Notification::make()->success()
                ->title('Maintenance mode has been turned off')
                ->body('Your site is now available to all user traffic.')
                ->send();

            $this->redirectRoute('admin.system-overview');
        }
    }

    public function render(): string
    {
        return <<<'blade'
            <x-switch wire:model.live="maintenance"></x-switch>
        blade;
    }
}
