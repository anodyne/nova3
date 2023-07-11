<?php

declare(strict_types=1);

namespace Nova\Foundation\Filament\Actions;

use Filament\Tables\Actions\DeleteAction as FilamentDeleteAction;

class DeleteAction extends FilamentDeleteAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->icon(iconName('trash'));

        $this->modalIcon(iconName('trash'));
        $this->modalWidth('lg');
    }
}
