<?php

declare(strict_types=1);

namespace Nova\Foundation\Filament\Actions;

class EditAction extends \Filament\Actions\EditAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->color('gray');
        $this->icon(iconName('edit'));
        $this->size('md');
    }
}
