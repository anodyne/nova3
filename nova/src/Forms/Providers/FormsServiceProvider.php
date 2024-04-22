<?php

declare(strict_types=1);

namespace Nova\Forms\Providers;

use Nova\DomainServiceProvider;
use Nova\Forms\Livewire\FormDesigner;
use Nova\Forms\Livewire\FormsList;

class FormsServiceProvider extends DomainServiceProvider
{
    public function livewireComponents(): array
    {
        return [
            'forms-designer' => FormDesigner::class,
            'forms-list' => FormsList::class,
        ];
    }
}
