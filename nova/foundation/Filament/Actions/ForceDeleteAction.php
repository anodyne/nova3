<?php

declare(strict_types=1);

namespace Nova\Foundation\Filament\Actions;

use Filament\Tables\Actions\ForceDeleteAction as FilamentForceDeleteAction;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Nova\Foundation\Filament\Actions\Concerns\HasModalContentView;

class ForceDeleteAction extends FilamentForceDeleteAction
{
    use HasModalContentView;

    protected function setUp(): void
    {
        parent::setUp();

        $this->color('danger');
        $this->icon(iconName('trash'));

        $this->requiresConfirmation(false);

        $this->modalWidth('lg');
        $this->modalIcon(null);
        $this->modalHeading('');
        $this->modalDescription(null);
        $this->modalSubmitActionLabel('Force delete');
        $this->modalContent(fn (Model $record): View => view($this->modalContentView, [
            'record' => $record,
        ]));
    }
}
