<?php

declare(strict_types=1);

namespace Nova\Foundation\Filament\Actions;

use Nova\Foundation\Filament\Actions\Concerns\HasModalContentView;
use Filament\Support\Enums\Width;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;

class ReplicateAction extends \Filament\Actions\ReplicateAction
{
    use HasModalContentView;

    protected function setUp(): void
    {
        parent::setUp();

        $this->color('gray');
        $this->icon(iconName('copy'));
        $this->label('Duplicate');

        $this->modalWidth(Width::ExtraLarge);
        $this->modalIcon(null);
        $this->modalHeading('');
        $this->modalDescription(null);
        $this->modalSubmitActionLabel('Yes, duplicate it');
        $this->modalContent(fn (Model $record): View => view($this->modalContentView, [
            'record' => $record,
            'action' => $this,
        ]));
    }
}
