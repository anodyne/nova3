<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Stats\Settings;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Set;
use Nova\Pages\Blocks\FormSchema;

class SimpleStatsBlockSettings extends StatBlockSettings
{
    public ?string $header = 'Simple Stats block';

    public ?string $identifier = 'stats-simple';

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

            'stats' => $this->data['stats'] ?? [],
        ]);
    }

    public function getFormFields(): array
    {
        return [
            ...FormSchema::heading(withOrientation: true),
            ...FormSchema::backgroundColor(),
            Section::make('Stats')->schema([
                Repeater::make('stats')
                    ->defaultItems(1)
                    ->maxItems(4)
                    ->deletable(true)
                    ->schema([
                        Select::make('stat')
                            ->options($this->getStatOptions())
                            ->live()
                            ->afterStateUpdated(fn (?string $state, Set $set) => $set('heading', $this->getStatOptions()[$state])),
                        TextInput::make('heading')->label('Heading'),
                    ]),
            ]),
        ];
    }
}
