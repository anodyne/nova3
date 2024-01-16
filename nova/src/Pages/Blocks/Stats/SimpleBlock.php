<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Stats;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Set;

class SimpleBlock extends StatsBlock
{
    public ?string $label = 'Stats - Simple';

    public string $preview = 'pages.pages.blocks.stats.simple';

    public string $rendered = 'pages.pages.blocks.stats.simple';

    public function getFormSchema(): array
    {
        return [
            Toggle::make('dark'),
            Section::make('Column 1')->schema([
                Select::make('col1Stat')
                    ->options($this->getStatOptions())
                    ->label('Stat')
                    ->live()
                    ->afterStateUpdated(fn (?string $state, Set $set) => $set('col1Heading', $this->getStatOptions()[$state])),
                TextInput::make('col1Heading')
                    ->label('Heading'),
            ]),
            Section::make('Column 2')->schema([
                Select::make('col2Stat')
                    ->options($this->getStatOptions())
                    ->label('Stat')
                    ->live()
                    ->afterStateUpdated(fn (?string $state, Set $set) => $set('col2Heading', $this->getStatOptions()[$state])),
                TextInput::make('col2Heading')
                    ->label('Heading'),
            ]),
            Section::make('Column 3')->schema([
                Select::make('col3Stat')
                    ->options($this->getStatOptions())
                    ->label('Stat')
                    ->live()
                    ->afterStateUpdated(fn (?string $state, Set $set) => $set('col3Heading', $this->getStatOptions()[$state])),
                TextInput::make('col3Heading')
                    ->label('Heading'),
            ]),
        ];
    }
}
