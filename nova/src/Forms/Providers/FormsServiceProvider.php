<?php

declare(strict_types=1);

namespace Nova\Forms\Providers;

use Nova\DomainServiceProvider;
use Nova\Forms\Livewire\FormsList;

class FormsServiceProvider extends DomainServiceProvider
{
    public function livewireComponents(): array
    {
        return [
            'forms:list' => FormsList::class,
        ];
    }
}
