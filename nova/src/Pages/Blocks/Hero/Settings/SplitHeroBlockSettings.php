<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Hero\Settings;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Nova\Pages\Blocks\FormSchema;

class SplitHeroBlockSettings extends HeroBlockSettings
{
    public ?string $header = 'Hero - Split block';

    public ?string $identifier = 'hero-split';

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

            'mediaType' => $this->data['mediaType'] ?? null,
            'orientation' => $this->data['orientation'] ?? null,
            'image' => $this->data['image'] ?? null,
            'video' => $this->data['video'] ?? null,
        ]);
    }

    public function getFormFields(): array
    {
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
            ...FormSchema::backgroundSection(),
            ...FormSchema::mediaLeftRight(),
        ];
    }
}
