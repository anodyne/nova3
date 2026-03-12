<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Stats;

use Anodyne\TablerIcons\Tabler;
use Closure;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Nova\Pages\Blocks\Block as PageBuilderBlock;

abstract class StatsBlock extends PageBuilderBlock
{
    protected string|Closure $section = 'Stats';

    public function blockSchema(): array
    {
        return [
            Section::make()
                ->heading('Appearance')
                ->icon(Tabler::Palette)
                ->schema([
                    Grid::make(2)->schema([
                        ColorPicker::make('block.appearance.stat-color')->rgba(),
                        ColorPicker::make('block.appearance.label-color')->rgba(),
                    ]),
                ]),

            Section::make()
                ->heading('Stats')
                ->icon(Tabler::ChartDots)
                ->schema([
                    Repeater::make('block.stats')
                        ->hiddenLabel()
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

    protected function getStatOptions(): array
    {
        return [
            'all-time-posts' => 'All-time posts',
            'all-time-post-words' => 'All-time post words',
            'current-month-posts' => 'Posts this month',
            'current-month-post-words' => 'Post words this month',
            'current-year-posts' => 'Posts this year',
            'current-year-post-words' => 'Post words this year',
            'previous-month-posts' => 'Posts last month',
            'previous-month-post-words' => 'Post words last month',
            'previous-year-posts' => 'Posts last year',
            'previous-year-post-words' => 'Post words last year',
            'current-user-count' => 'Total active users',
            'current-character-count' => 'Total active characters',
        ];
    }
}
