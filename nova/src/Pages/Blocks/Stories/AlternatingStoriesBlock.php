<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Stories;

use Anodyne\TablerIcons\Tabler;
use Closure;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Nova\Pages\Enums\BoxShadow;
use Nova\Pages\Enums\ButtonSize;
use Nova\Pages\Enums\Radius;
use Nova\Stories\Models\Story;

class AlternatingStoriesBlock extends StoriesBlock
{
    const component = 'stories.alternating';

    protected ?string $blockLabel = 'Stories - Alternating';

    protected string|Closure|null $preview = 'stories.alternating';

    public function blockSchema(): array
    {
        return [
            Section::make()
                ->heading('Stories')
                ->description('Customize the types of stories and how they display')
                ->icon(Tabler::Books)
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
            Section::make()
                ->heading('Appearance')
                ->description('Customize the appearance of the stories displayed in the block')
                ->icon(Tabler::Palette)
                ->schema([
                    ColorPicker::make('block.primary-text-color')->label('Primary text color'),
                    ColorPicker::make('block.secondary-text-color')->label('Secondary text color'),
                    Section::make()
                        ->heading('Go to Story button')
                        ->compact()
                        ->columnSpanFull()
                        ->columns(2)
                        ->schema([
                            Select::make('block.button.size')
                                ->label('Button size')
                                ->options(ButtonSize::class)
                                ->default(ButtonSize::Large->value),
                            ColorPicker::make('block.button.bg-color')->label('Background color')->rgba(),
                            ColorPicker::make('block.button.text-color')->label('Text color')->rgba(),
                            ToggleButtons::make('block.button.border-style')
                                ->label('Border style')
                                ->options([
                                    'none' => 'No border',
                                    'outer' => 'Outside',
                                    'inner' => 'Inside',
                                ])
                                ->inline()
                                ->default('none')
                                ->live(),
                            ColorPicker::make('block.button.border-color')
                                ->label('Border color')
                                ->rgba()
                                ->hidden(fn (Get $get): bool => $get('block.button.border-style') === 'none'),
                            Select::make('block.button.shadow')
                                ->label('Shadow')
                                ->options(BoxShadow::class)
                                ->default(BoxShadow::None->value),
                            Select::make('block.button.radius')
                                ->label('Corner radius')
                                ->options(Radius::class)
                                ->default(Radius::None->value),

                        ]),
                ])
                ->columns(2),
            Section::make()
                ->heading('Story image options')
                ->icon(Tabler::Photo)
                ->schema([
                    Select::make('block.image.radius')
                        ->label('Corner radius')
                        ->options(Radius::class)
                        ->default(Radius::ExtraLarge->value),
                    Select::make('block.image.shadow')
                        ->label('Shadow')
                        ->options(BoxShadow::class)
                        ->default(BoxShadow::ExtraLarge->value),
                ])
                ->columns(2),
        ];
    }
}
