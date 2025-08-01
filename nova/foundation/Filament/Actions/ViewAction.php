<?php

declare(strict_types=1);

namespace Nova\Foundation\Filament\Actions;

class ViewAction extends \Filament\Actions\ViewAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->color('gray');
        $this->icon(iconName('show'));
        $this->size('md');
    }
}
