<?php

declare(strict_types=1);

namespace Nova\Foundation\Filament\Actions;

use Filament\Tables\Actions\Action as FilamentAction;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;

class Action extends FilamentAction
{
    use Concerns\HasModalContentView;

    protected function setUp(): void
    {
        parent::setUp();

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
