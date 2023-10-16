<?php

declare(strict_types=1);

namespace Nova\Foundation\Filament\Actions;

use Filament\Tables\Actions\RestoreAction as FilamentRestoreAction;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Nova\Foundation\Filament\Actions\Concerns\HasModalContentView;

class RestoreAction extends FilamentRestoreAction
{
    use HasModalContentView;

    protected function setUp(): void
    {
        parent::setUp();

        $this->icon(iconName('history'));

        if (filled($this->modalContentView)) {
            $this->requiresConfirmation(false);

            $this->modalWidth('lg');
            $this->modalIcon(null);
            $this->modalHeading('');
            $this->modalDescription(null);
            $this->modalSubmitActionLabel('Restore');
            $this->modalContent(fn (Model $record): View => view($this->modalContentView, [
                'record' => $record,
            ]));
        }
    }
}
