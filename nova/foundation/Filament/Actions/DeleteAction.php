<?php

declare(strict_types=1);

namespace Nova\Foundation\Filament\Actions;

use Nova\Foundation\Filament\Actions\Concerns\HasModalContentView;
use Filament\Support\Enums\Width;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;

class DeleteAction extends \Filament\Actions\DeleteAction
{
    use HasModalContentView;

    protected function setUp(): void
    {
        parent::setUp();

        $this->icon(iconName('trash'));

        $this->requiresConfirmation(false);

        $this->modalWidth(Width::Large);
        $this->modalIcon(null);
        $this->modalHeading('');
        $this->modalDescription(null);
        $this->modalSubmitActionLabel('Yes, delete it');
        $this->modalCancelActionLabel('No, keep it');
        $this->modalContent(fn (Model $record): View => view($this->modalContentView, [
            'record' => $record,
            'action' => $this,
        ]));
    }
}
