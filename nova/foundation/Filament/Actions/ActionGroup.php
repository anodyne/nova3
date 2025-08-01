<?php

declare(strict_types=1);

namespace Nova\Foundation\Filament\Actions;

class ActionGroup extends \Filament\Actions\ActionGroup
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->color('gray');
        $this->icon(iconName('more'));
        $this->dropdownPlacement('bottom-end');
    }

    public function divided(): self
    {
        $this->dropdown(false);

        return $this;
    }
}
