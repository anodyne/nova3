<?php

declare(strict_types=1);

namespace Nova\Foundation\Filament\Actions;

use Filament\Support\Enums\Width;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Nova\Foundation\Filament\Actions\Concerns\HasModalContentView;
use Nova\Foundation\Icons\Icon;

class RestoreBulkAction extends \Filament\Actions\RestoreBulkAction
{
    use HasModalContentView;

    protected function setUp(): void
    {
        parent::setUp();

        $this->icon(Icon::Restore);

        $this->requiresConfirmation(false);

        $this->modalWidth(Width::Large);
        $this->modalIcon(null);
        $this->modalHeading('');
        $this->modalDescription(null);
        $this->modalSubmitActionLabel('Yes, restore them');
        $this->modalCancelActionLabel('No, keep them deleted');
        $this->modalContent(fn (Collection $records): View => view($this->modalContentView, [
            'records' => $records,
            'action' => $this,
        ]));
    }
}
