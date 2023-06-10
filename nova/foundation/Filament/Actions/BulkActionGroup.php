<?php

declare(strict_types=1);

namespace Nova\Foundation\Filament\Actions;

use Filament\Tables\Actions\BulkActionGroup as FilamentBulkActionGroup;

class BulkActionGroup extends FilamentBulkActionGroup
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->color('gray');
        $this->icon(iconName('more'));
        $this->size('h-7 w-7');
        $this->dropdownPlacement('bottom-end');
    }

    public function divided(): self
    {
        $this->dropdown(false);

        return $this;
    }
}
