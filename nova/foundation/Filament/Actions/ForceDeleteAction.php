<?php

declare(strict_types=1);

namespace Nova\Foundation\Filament\Actions;

use Filament\Support\Enums\Width;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Nova\Foundation\Filament\Actions\Concerns\HasModalContentView;
use Nova\Foundation\Icons\Icon;

class ForceDeleteAction extends \Filament\Actions\ForceDeleteAction
{
    use HasModalContentView;

    protected function setUp(): void
    {
        parent::setUp();

        $this->color('danger');
        $this->icon(Icon::Trash);

        $this->requiresConfirmation(false);

        $this->modalWidth(Width::Large);
        $this->modalIcon(null);
        $this->modalHeading('');
        $this->modalDescription(null);
        $this->modalSubmitActionLabel('Yes, delete it forever');
        $this->modalCancelActionLabel('No, keep it');
        $this->modalContent(fn (Model $record): View => view($this->modalContentView, [
            'record' => $record,
            'action' => $this,
        ]));
    }
}
