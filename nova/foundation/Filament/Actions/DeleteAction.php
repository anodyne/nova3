<?php

namespace Nova\Foundation\Filament\Actions;

use Filament\Tables\Actions\DeleteAction as FilamentDeleteAction;

class DeleteAction extends FilamentDeleteAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->color('danger');
        $this->icon(iconName('trash'));

        $this->modalWidth('xl');
    }
}
