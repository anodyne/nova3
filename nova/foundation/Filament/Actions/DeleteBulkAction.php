<?php

namespace Nova\Foundation\Filament\Actions;

use Filament\Tables\Actions\DeleteBulkAction as FilamentDeleteBulkAction;

class DeleteBulkAction extends FilamentDeleteBulkAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->icon(iconName('trash'));
    }
}
