<?php

declare(strict_types=1);

namespace Nova\Foundation\Filament\Actions;

use Anodyne\TablerIcons\Tabler;
use Filament\Support\Enums\Size;

class BulkActionGroup extends \Filament\Actions\BulkActionGroup
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->color('gray');
        $this->icon(Tabler::DotsVertical);
        $this->size(Size::Medium);
        $this->dropdownPlacement('bottom-end');
    }

    public function divided(): self
    {
        $this->dropdown(false);

        return $this;
    }
}
