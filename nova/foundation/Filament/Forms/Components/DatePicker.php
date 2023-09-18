<?php

declare(strict_types=1);

namespace Nova\Foundation\Filament\Forms\Components;

use Filament\Forms\Components\DatePicker as FilamentDatePicker;

class DatePicker extends FilamentDatePicker
{
    protected string $view = 'filament.forms.components.date-picker';
}
