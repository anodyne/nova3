<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Stories;

use Closure;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Get;
use Nova\Pages\Blocks\Block as PageBuilderBlock;
use Nova\Stories\Models\Story;

abstract class StoriesBlock extends PageBuilderBlock
{
    protected string|Closure $section = 'Stories';

    protected function storiesSection(): array
    {
        return [
            Section::make()
                ->heading('Stories')
                ->description('Customize the types of stories and how they display')
                ->icon(iconName('books'))
                ->schema([
                    Select::make('block.storyType')
                        ->options([
                            'current' => 'Current stories',
                            'upcoming' => 'Upcoming stories',
                            'ongoing' => 'Ongoing stories (story arcs)',
                            'custom' => 'Select stories to display',
                        ])
                        ->live(),
                    Select::make('block.selectedStories')
                        ->options(fn () => Story::get()->pluck('title', 'id'))
                        ->multiple()
                        ->preload()
                        ->searchable()
                        ->visible(fn (Get $get): bool => $get('block.storyType') === 'custom'),
                    Toggle::make('block.showStoryDescription')->label('Show story description'),
                    Toggle::make('block.showStoryStats')->label('Show story stats'),
                ]),
        ];
    }
}
