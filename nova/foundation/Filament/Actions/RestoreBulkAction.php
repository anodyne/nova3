<?php

declare(strict_types=1);

namespace Nova\Foundation\Filament\Actions;

use Filament\Tables\Actions\RestoreBulkAction as FilamentRestoreBulkAction;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;

class RestoreBulkAction extends FilamentRestoreBulkAction
{
    use Concerns\HasModalContentView;

    protected function setUp(): void
    {
        parent::setUp();

        $this->icon(iconName('history'));

        $this->requiresConfirmation(false);

        $this->modalWidth('lg');
        $this->modalIcon(null);
        $this->modalHeading('');
        $this->modalDescription(null);
        $this->modalSubmitActionLabel('Restore');
        $this->modalContent(fn (Collection $records): View => view($this->modalContentView, [
            'records' => $records,
        ]));
    }
}
