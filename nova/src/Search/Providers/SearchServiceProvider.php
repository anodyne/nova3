<?php

declare(strict_types=1);

namespace Nova\Search\Providers;

use Nova\DomainServiceProvider;
use Nova\Search\Actions\BuildSearchIndex;
use Nova\Search\Actions\FlushSearchIndex;
use Nova\Search\Livewire\GlobalSearch;

class SearchServiceProvider extends DomainServiceProvider
{
    public function consoleCommands(): array
    {
        return [
            BuildSearchIndex::class,
            FlushSearchIndex::class,
        ];
    }

    public function livewireComponents(): array
    {
        return [
            'global-search' => GlobalSearch::class,
        ];
    }
}
