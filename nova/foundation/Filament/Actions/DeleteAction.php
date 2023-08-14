<?php

declare(strict_types=1);

namespace Nova\Foundation\Filament\Actions;

use Filament\Tables\Actions\DeleteAction as FilamentDeleteAction;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;

class DeleteAction extends FilamentDeleteAction
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
        $this->modalSubmitActionLabel('Delete');
        $this->modalContent(fn (Model $record): View => view($this->modalContentView, [
            'record' => $record,
        ]));
    }
}
