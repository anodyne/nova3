<?php

declare(strict_types=1);

namespace Nova\Foundation\Filament\Actions;

use Filament\Tables\Actions\ReplicateAction as FilamentReplicateAction;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;

class ReplicateAction extends FilamentReplicateAction
{
    use Concerns\HasModalContentView;

    protected function setUp(): void
    {
        parent::setUp();

        $this->color('gray');
        $this->icon(iconName('copy'));
        $this->label('Duplicate');

        $this->modalWidth('xl');
        $this->modalIcon(null);
        $this->modalHeading('');
        $this->modalDescription(null);
        $this->modalSubmitActionLabel('Duplicate');
        $this->modalContent(fn (Model $record): View => view($this->modalContentView, [
            'record' => $record,
        ]));
    }
}
