<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Features\Settings;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Illuminate\Support\Facades\Cache;

class CardsFeatureBlockSettings extends FeatureBlockSettings
{
    public ?string $header = 'Cards Features block';

    public ?string $identifier = 'features-cards';

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

            'rows' => $this->data['rows'] ?? [],
        ]);
    }

    public function getFormFields(): array
    {
        $page = Cache::get('page-designer-page');

        return [
            ...parent::getFormFields(),
            Section::make('Grid rows and columns')->schema([
                Repeater::make('rows')->schema([
                    Select::make('layout')
                        ->options([
                            'sm-md' => '1 small column, 1 medium column',
                            'md-sm' => '1 medium column, 1 small column',
                            'sm' => '3 small columns',
                            'lg' => '1 large column',
                        ])
                        ->live(),
                    Repeater::make('columns')
                        ->maxItems(fn (Get $get): int => match ($get('layout')) {
                            'lg' => 1,
                            'sm' => 3,
                            default => 2
                        })
                        ->schema([
                            TextInput::make('heading'),
                            Textarea::make('description'),
                            FileUpload::make('image')
                                ->disk('media')
                                ->directory('pages/'.$page),
                        ]),
                ]),
            ]),
        ];
    }
}
