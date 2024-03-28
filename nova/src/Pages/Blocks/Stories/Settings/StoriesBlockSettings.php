<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Stories\Settings;

use Awcodes\Scribble\Enums\SlideDirection;
use Awcodes\Scribble\Livewire\ScribbleModal;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Get;
use Filament\Support\Enums\MaxWidth;
use Nova\Pages\Blocks\FormSchema;
use Nova\Stories\Models\Story;

abstract class StoriesBlockSettings extends ScribbleModal
{
    public static function getSlideDirection(): SlideDirection
    {
        return SlideDirection::Right;
    }

    public static function getMaxWidth(): MaxWidth
    {
        return MaxWidth::ExtraLarge;
    }

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

            'storyType' => $this->data['storyType'] ?? null,
            'selectedStories' => $this->data['selectedStories'] ?? [],
            'showStoryDescription' => $this->data['showStoryDescription'] ?? null,
            'showStoryStats' => $this->data['showStoryStats'] ?? null,
        ]);
    }

    public function getFormFields(): array
    {
        return [
            ...FormSchema::heading(withOrientation: true),
            ...FormSchema::backgroundColor(),
            Section::make('Stories')->schema([
                Select::make('storyType')
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
                Toggle::make('showStoryDescription')->label('Show story description'),
                Toggle::make('showStoryStats')->label('Show story stats'),
            ]),
        ];
    }
}
