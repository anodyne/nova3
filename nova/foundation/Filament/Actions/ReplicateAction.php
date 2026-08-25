<?php

declare(strict_types=1);

namespace Nova\Foundation\Filament\Actions;

use Anodyne\TablerIcons\Tabler;
use Filament\Support\Enums\Width;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Nova\Foundation\Filament\Actions\Concerns\CanSetRecordDisplayName;
use Nova\Foundation\Filament\Actions\Concerns\HasModalContentView;

class ReplicateAction extends \Filament\Actions\ReplicateAction
{
    use CanSetRecordDisplayName;
    use HasModalContentView;

    protected function setUp(): void
    {
        parent::setUp();

        $this->color('gray');
        $this->icon(Tabler::Copy);
        $this->label('Duplicate');

        $this->successNotificationTitle(fn (Model $record): string => trans('messages.table.replicate-success', [
            'title' => $record->{$this->getRecordDisplayNameAttribute()},
            'label' => $this->getRecordTitle(),
        ]));

        $this->failureNotificationTitle(fn (Model $record): string => trans('messages.table.replicate-failure', [
            'title' => $record->{$this->getRecordDisplayNameAttribute()},
            'label' => $this->getRecordTitle(),
        ]));

        $this->modalWidth(Width::ExtraLarge);
        $this->modalIcon();
        $this->modalHeading('');
        $this->modalDescription();
        $this->modalSubmitActionLabel('Yes, duplicate it');
        $this->modalContent(fn (Model $record): View => view($this->getModalContentView(), [
            'record' => $record,
            'action' => $this,
        ]));
    }
}
