<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Stats;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Set;
use FilamentTiptapEditor\TiptapBlock;
use Nova\Pages\Blocks\FormSchema;

abstract class StatsBlock extends TiptapBlock
{
    public string $width = 'xl';

    public bool $slideOver = true;

    public ?string $icon = 'tabler-chart-bar';

    public function getFormSchema(): array
    {
        return [
            TextInput::make('heading'),
            Textarea::make('description'),
            ...FormSchema::background(),
            Toggle::make('dark')->label('Invert text colors for dark backgrounds'),
            Repeater::make('stats')
                ->maxItems(4)
                ->deletable(true)
                ->schema([
                    Select::make('stat')
                        ->options($this->getStatOptions())
                        ->live()
                        ->afterStateUpdated(fn (?string $state, Set $set) => $set('heading', $this->getStatOptions()[$state])),
                    TextInput::make('heading')->label('Heading'),
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
