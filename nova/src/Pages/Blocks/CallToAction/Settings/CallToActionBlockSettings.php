<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\CallToAction\Settings;

use Awcodes\Scribble\Enums\SlideDirection;
use Awcodes\Scribble\Livewire\ScribbleModal;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Get;
use Filament\Support\Enums\MaxWidth;
use Nova\Pages\Blocks\FormSchema;

abstract class CallToActionBlockSettings extends ScribbleModal
{
    protected bool $useHeaderOrientation = false;

    public static function getSlideDirection(): SlideDirection
    {
        return SlideDirection::Right;
    }

    public static function getMaxWidth(): MaxWidth
    {
        return MaxWidth::ExtraLarge;
    }

    public function getFormFields(): array
    {
        return [
            ...FormSchema::heading(withOrientation: $this->useHeaderOrientation),
            ...FormSchema::primaryButtonSection(),
            ...FormSchema::secondaryButtonSection(),
            ...FormSchema::backgroundSection(),
            Section::make('Card layout')
                ->schema([
                    Toggle::make('card')
                        ->label('Put the content inside a card')
                        ->live(),
                    Grid::make(1)
                        ->schema([
                            Grid::make(2)->schema([
                                ColorPicker::make('cardBg')->label('Background color'),
                                TextInput::make('cardBgOpacity')
                                    ->label('Background opacity')
                                    ->numeric()
                                    ->minValue(0)
                                    ->maxValue(100),
                            ]),
                            Toggle::make('cardBgBlur')->label('Blur the background beneath the card'),
                            Select::make('cardSpacing')
                                ->label('Spacing')
                                ->options([
                                    'small' => 'Small',
                                    'medium' => 'Medium',
                                    'large' => 'Large',
                                    'none' => 'None',
                                ]),
                            Toggle::make('cardDark')
                                ->label('Invert text colors for dark backgrounds in the card')
                                ->helperText('You may also need to turn on/off the invert text colors option in the background section to get your card to look the way you want.'),
                        ])
                        ->columnSpanFull()
                        ->visible(fn (Get $get): bool => $get('card') === true),
                ]),
        ];
    }
}
