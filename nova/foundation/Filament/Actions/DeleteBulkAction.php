<?php

declare(strict_types=1);

namespace Nova\Foundation\Filament\Actions;

use Anodyne\TablerIcons\Tabler;
use Filament\Support\Enums\Width;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Nova\Foundation\Filament\Actions\Concerns\HasModalContentView;

class DeleteBulkAction extends \Filament\Actions\DeleteBulkAction
{
    use HasModalContentView;

    protected function setUp(): void
    {
        parent::setUp();

        $this->icon(Tabler::Trash);

        $this->requiresConfirmation(false);

        $this->successNotificationTitle(function (Collection $records): string {
            return trans_choice('messages.table.bulk-delete-success', $records->count(), [
                'count' => $records->count(),
                'label' => str($this->getRecordTitle())->plural($records->count()),
            ]);
        });

        $this->failureNotificationTitle(function (int $successCount, int $totalCount): string {
            if ($successCount) {
                return trans_choice('messages.table.bulk-delete-failure', $totalCount, [
                    'success' => $successCount,
                    'total' => $totalCount,
                    'label' => str($this->getRecordTitle())->plural($totalCount),
                ]);
            }

            return trans_choice('messages.table.bulk-delete-total-failure', $totalCount, [
                'label' => str($this->getRecordTitle())->plural($totalCount),
            ]);
        });

        $this->modalWidth(Width::Large);
        $this->modalIcon(null);
        $this->modalHeading('');
        $this->modalDescription(null);
        $this->modalSubmitActionLabel('Yes, delete them');
        $this->modalCancelActionLabel('No, keep them');
        $this->modalContent(fn (Collection $records): View => view($this->modalContentView, [
            'records' => $records,
            'action' => $this,
        ]));
    }
}
