<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Form\Settings;

use Awcodes\Scribble\Enums\SlideDirection;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Support\Enums\MaxWidth;
use Nova\Forms\Models\Form;
use Nova\Foundation\Scribble\ScribbleModal;
use Nova\Pages\Blocks\FormSchema;

class FormBlockSettings extends ScribbleModal
{
    public ?string $header = 'Form block';

    public ?string $identifier = 'form';

    public static function getSlideDirection(): SlideDirection
    {
        return SlideDirection::Right;
    }

    public static function getMaxWidth(): MaxWidth
    {
        return MaxWidth::ExtraLarge;
    }

    public function mount(): void
    {
        $this->form->fill([
            'form' => $this->data['form'] ?? null,
            'formWidth' => $this->data['formWidth'] ?? '2xl',
            'formOrientation' => $this->data['formOrientation'] ?? 'center',

            'heading' => $this->data['heading'] ?? null,
            'description' => $this->data['description'] ?? null,
            'headerOrientation' => $this->data['headerOrientation'] ?? null,

            'bgOption' => $this->data['bgOption'] ?? null,
            'bgColor' => $this->data['bgColor'] ?? null,

            'spacingHorizontal' => $this->data['spacingHorizontal'] ?? null,
            'spacingVertical' => $this->data['spacingVertical'] ?? null,

            'dark' => $this->data['dark'] ?? false,
        ]);
    }

    public function getFormFields(): array
    {
        return [
            ...FormSchema::heading(withOrientation: true),
            ...FormSchema::backgroundColor(),
            Section::make('Form options')->schema([
                Select::make('form')->options(Form::active()->pluck('name', 'key')),
                Select::make('formWidth')
                    ->options([
                        'lg' => 'Large',
                        'xl' => 'Extra large',
                        '2xl' => '2 extra large',
                        '3xl' => '3 extra large',
                        '4xl' => '4 extra large',
                        'full' => 'Full width',
                    ]),
                Select::make('formOrientation')->options([
                    'left' => 'Left',
                    'center' => 'Center',
                ]),
            ]),
        ];
    }
}
