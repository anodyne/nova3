<?php

declare(strict_types=1);

namespace Nova\Foundation\Filament\Actions;

use Filament\Support\Enums\Width;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Nova\Foundation\Filament\Actions\Concerns\HasModalContentView;
use Nova\Foundation\Icons\Icon;

class ForceDeleteBulkAction extends \Filament\Actions\ForceDeleteBulkAction
{
    use HasModalContentView;

    protected function setUp(): void
    {
        parent::setUp();

        $this->icon(Icon::Trash);

        $this->requiresConfirmation(false);

        $this->modalWidth(Width::Large);
        $this->modalIcon(null);
        $this->modalHeading('');
        $this->modalDescription(null);
        $this->modalSubmitActionLabel('Yes, delete them forever');
        $this->modalCancelActionLabel('No, keep them');
        $this->modalContent(fn (Collection $records): View => view($this->modalContentView, [
            'records' => $records,
            'action' => $this,
        ]));
    }
}
