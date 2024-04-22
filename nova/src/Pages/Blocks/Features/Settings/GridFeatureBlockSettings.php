<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Features\Settings;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class GridFeatureBlockSettings extends FeatureBlockSettings
{
    public ?string $header = 'Grid Features block';

    public ?string $identifier = 'features-grid';

    public function mount(): void
    {
        $this->form->fill([
            'heading' => $this->data['heading'] ?? null,
            'description' => $this->data['description'] ?? null,
            'headerOrientation' => $this->data['headerOrientation'] ?? null,

            'bgOption' => $this->data['bgOption'] ?? null,
            'bgColor' => $this->data['bgColor'] ?? null,

            'dark' => $this->data['dark'] ?? false,

            'spacingHorizontal' => $this->data['spacingHorizontal'] ?? null,
            'spacingVertical' => $this->data['spacingVertical'] ?? null,

            'features' => $this->data['features'] ?? [],
        ]);
    }

    public function getFormFields(): array
    {
        return [
            ...parent::getFormFields(),
            Section::make('Features')->schema([
                Repeater::make('features')->schema([
                    TextInput::make('heading'),
                    Textarea::make('description'),
                    TextInput::make('icon')
                        ->helperText('You have access to the full Tabler icon set for these icons'),
                ]),
            ]),
        ];
    }
}
