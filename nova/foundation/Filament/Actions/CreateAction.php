<?php

declare(strict_types=1);

namespace Nova\Foundation\Filament\Actions;

class CreateAction extends \Filament\Actions\CreateAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->color('primary');
        $this->icon(iconName('add'));
        $this->iconSize('md');
    }
}
