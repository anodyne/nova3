<?php

declare(strict_types=1);

namespace Nova\Foundation\Filament\Actions;

use Filament\Tables\Actions\ReplicateAction as FilamentReplicateAction;

class ReplicateAction extends FilamentReplicateAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->color('gray');
        $this->icon(iconName('copy'));
        $this->label('Duplicate');

        $this->modalIcon(iconName('copy'));
        $this->modalWidth('xl');
    }
}
