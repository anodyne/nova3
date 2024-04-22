<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Hero\Settings;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Illuminate\Support\Facades\Cache;
use Nova\Pages\Blocks\FormSchema;

class OffsetImageHeroBlockSettings extends HeroBlockSettings
{
    public ?string $header = 'Hero - Offset Image block';

    public ?string $identifier = 'hero-offset-image';

    public function mount(): void
    {
        $this->form->fill([
            'heading' => $this->data['heading'] ?? null,
            'description' => $this->data['description'] ?? null,

            'primaryButtonLabel' => $this->data['primaryButtonLabel'] ?? null,
            'primaryButtonUrl' => $this->data['primaryButtonUrl'] ?? null,
            'primaryButtonBgColor' => $this->data['primaryButtonBgColor'] ?? null,
            'primaryButtonTextColor' => $this->data['primaryButtonTextColor'] ?? null,

            'secondaryButtonLabel' => $this->data['secondaryButtonLabel'] ?? null,
            'secondaryButtonUrl' => $this->data['secondaryButtonUrl'] ?? null,

            'calloutText' => $this->data['calloutText'] ?? null,
            'calloutUrl' => $this->data['calloutUrl'] ?? null,
            'calloutColor' => $this->data['calloutColor'] ?? null,

            'bgOption' => $this->data['bgOption'] ?? null,
            'bgColor' => $this->data['bgColor'] ?? null,
            'bgImage' => $this->data['bgImage'] ?? null,
            'bgImageIntensity' => $this->data['bgImageIntensity'] ?? null,
            'dark' => $this->data['dark'] ?? false,

            'spacingHorizontal' => $this->data['spacingHorizontal'] ?? null,
            'spacingVertical' => $this->data['spacingVertical'] ?? null,

            'image' => $this->data['image'] ?? null,
        ]);
    }

    public function getFormFields(): array
    {
        $page = Cache::get('page-designer-page');

        return [
            ...FormSchema::heading(),
            ...FormSchema::primaryButtonSection(),
            ...FormSchema::secondaryButtonSection(),
            Section::make('Callout')
                ->description('The callout will appear if the text field is filled')
                ->schema([
                    TextInput::make('calloutText')
                        ->label('Text')
                        ->live(),
                    TextInput::make('calloutUrl')
                        ->label('URL')
                        ->url()
                        ->visible(fn (Get $get): bool => filled($get('calloutText'))),
                    FormSchema::tailwindColor('calloutColor')
                        ->label('Color')
                        ->visible(fn (Get $get): bool => filled($get('calloutText'))),
                ]),
            Section::make('Background')
                ->description('When dealing with background colors, keep in mind that the ribbon overlay uses transparency as well so you may have to adjust your background color to get your desired outcome.')
                ->schema([
                    FormSchema::backgroundOption(withImageOption: false)->live(),
                    FormSchema::tailwindColor('bgColor')
                        ->label('Background color')
                        ->visible(fn (Get $get): bool => $get('bgOption') === 'tailwind'),
                    ColorPicker::make('bgColor')
                        ->label('Background color')
                        ->default('#ffffff')
                        ->visible(fn (Get $get): bool => $get('bgOption') === 'color'),
                    // ...FormSchema::tailwindColor('backgroundColor'),
                    // ColorPicker::make('darkModeBackground')->default('#111827'),
                    FormSchema::tailwindColor('ribbonColor'),
                    ...FormSchema::dark('Use dark mode'),
                    ...FormSchema::spacing(),
                ]),
            FileUpload::make('image')
                ->disk('media')
                ->directory('pages/'.$page)
                ->image(),
        ];
    }
}
