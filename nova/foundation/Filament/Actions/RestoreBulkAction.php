<?php

declare(strict_types=1);

namespace Nova\Foundation\Filament\Actions;

use Anodyne\TablerIcons\Tabler;
use Filament\Support\Enums\Width;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Nova\Foundation\Filament\Actions\Concerns\HasModalContentView;

class RestoreBulkAction extends \Filament\Actions\RestoreBulkAction
{
    use HasModalContentView;

    protected function setUp(): void
    {
        parent::setUp();

        $this->icon(Tabler::Restore);

        $this->requiresConfirmation(false);

        $this->modalWidth(Width::Large);
        $this->modalIcon();
        $this->modalHeading('');
        $this->modalDescription();
        $this->modalSubmitActionLabel('Yes, restore them');
        $this->modalCancelActionLabel('No, keep them deleted');
        $this->modalContent(fn (Collection $records): View => view($this->getModalContentView(), [
            'records' => $records,
            'action' => $this,
        ]));
    }
}
