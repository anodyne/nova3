<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Stories;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Get;
use Nova\Pages\Blocks\FormSchema;
use Nova\Stories\Models\Story;

class AlternatingStoriesBlock extends StoriesBlock
{
    public ?string $label = 'Stories - Alternating';

    public string $rendered = 'pages.pages.blocks.stories.alternating';

    public string $preview = 'pages.pages.blocks.stories.alternating-preview';

    public function getFormSchema(): array
    {
        return [
            ...parent::getFormSchema(),
            ...FormSchema::background(),
            ...FormSchema::dark(),
            Section::make('Stories')->schema([
                Select::make('type')
                    ->options([
                        'current' => 'Current stories',
                        'upcoming' => 'Upcoming stories',
                        'ongoing' => 'Ongoing stories (story arcs)',
                        'custom' => 'Select stories to display',
                    ])
                    ->live(),
                Select::make('selectedStories')
                    ->options(fn () => Story::get()->pluck('title', 'id'))
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->visible(fn (Get $get): bool => $get('type') === 'custom'),
                Toggle::make('showDescription')->label('Show story description'),
                Toggle::make('showStats')->label('Show story stats'),
            ]),
        ];
    }
}
