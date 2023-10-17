<?php

declare(strict_types=1);

namespace Nova\Foundation\Filament\Actions;

use Filament\Tables\Actions\ForceDeleteBulkAction as FilamentForceDeleteBulkAction;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;

class ForceDeleteBulkAction extends FilamentForceDeleteBulkAction
{
    use Concerns\HasModalContentView;

    protected function setUp(): void
    {
        parent::setUp();

        $this->icon(iconName('trash'));

        $this->requiresConfirmation(false);

        $this->modalWidth('lg');
        $this->modalIcon(null);
        $this->modalHeading('');
        $this->modalDescription(null);
        $this->modalSubmitActionLabel('Force delete');
        $this->modalContent(fn (Collection $records): View => view($this->modalContentView, [
            'records' => $records,
        ]));
    }
}
