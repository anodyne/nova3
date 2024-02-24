<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Get;

class FormSchema
{
    public static function background(): array
    {
        return [
            Section::make('Background')->schema([
                Select::make('backgroundType')
                    ->options([
                        'Solid color' => [
                            'transparent' => 'Transparent',
                            'color' => 'Pick a color',
                        ],
                        'Light image' => [
                            'peak' => 'Peak',
                            'ribbon' => 'Ribbon',
                            'ribbon-full' => 'Ribbon (full)',
                            'waves-flat' => 'Waves (flat)',
                            'waves-narrow' => 'Waves (narrow)',
                            'waves-tall' => 'Waves (tall)',
                        ],
                        'Dark image' => [
                            'aurora' => 'Aurora',
                            'nebula' => 'Nebula',
                            'nebula-blue' => 'Nebula (blue)',
                            'nebula-purple' => 'Nebula (purple)',
                            'pixels' => 'Pixels',
                            'stars' => 'Stars',
                            'warp' => 'Warp',
                            'warp-horizon' => 'Warp (horizon)',
                            'warp-illustrated' => 'Warp (illustrated)',
                            'warp-intense' => 'Warp (intense)',
                            'waves' => 'Waves',
                        ],
                        'custom' => 'Custom image',
                    ])
                    ->live(),
                ColorPicker::make('backgroundColor')
                    ->visible(fn (Get $get) => $get('backgroundType') === 'color'),
                FileUpload::make('backgroundImage')
                    ->visible(fn (Get $get) => $get('backgroundType') === 'custom'),
                Select::make('backgroundImageIntensity')
                    ->options([
                        'none' => 'No overlay',
                        'intense' => 'Intense',
                        'vivid' => 'Vivid',
                        'neutral' => 'Neutral',
                        'muted' => 'Muted',
                        'subtle' => 'Subtle',
                    ])
                    ->hidden(fn (Get $get) => in_array($get('backgroundType'), ['color', 'custom', 'transparent'])),
            ]),
        ];
    }

    public static function backgroundColor(): array
    {
        return [
            Section::make('Background')->schema([
                Select::make('backgroundType')
                    ->options([
                        'transparent' => 'Transparent',
                        'color' => 'Pick a color',
                    ])
                    ->default('transparent')
                    ->live(),
                ColorPicker::make('backgroundColor')
                    ->visible(fn (Get $get) => $get('backgroundType') === 'color'),
                ...static::dark(),
            ]),
        ];
    }

    public static function dark(): array
    {
        return [
            Toggle::make('dark')->label('Invert text colors for dark backgrounds'),
        ];
    }

    public static function intro(): array
    {
        return [
            Section::make('Intro')->schema([
                TextInput::make('heading'),
                Textarea::make('description'),
                Radio::make('orientation')
                    ->options([
                        'center' => 'Center',
                        'left' => 'Left',
                        'right' => 'Right',
                    ])
                    ->default('center'),
            ]),
        ];
    }

    public static function mediaLeftRight(): array
    {
        return [
            Section::make('Media')->schema([
                Radio::make('mediaType')
                    ->options([
                        'none' => 'No media',
                        'image' => 'Image',
                        'video' => 'Video',
                    ])
                    ->live(),
                Radio::make('orientation')
                    ->options([
                        'right' => 'Right',
                        'left' => 'Left',
                    ])
                    ->default('right')
                    ->hidden(fn (Get $get) => $get('mediaType') === 'none'),
                FileUpload::make('image')
                    ->disk('media')
                    ->directory('pages')
                    ->visible(fn (Get $get) => $get('mediaType') === 'image'),
                TextInput::make('video')
                    ->label('Video URL')
                    ->url()
                    ->visible(fn (Get $get) => $get('mediaType') === 'video'),
            ]),
        ];
    }

    public static function mediaTopBottom(): array
    {
        return [
            Section::make('Media')->schema([
                Radio::make('mediaType')
                    ->options([
                        'none' => 'No media',
                        'image' => 'Image',
                        'video' => 'Video',
                    ])
                    ->live(),
                Radio::make('orientation')
                    ->options([
                        'top' => 'Top',
                        'bottom' => 'Bottom',
                    ])
                    ->default('bottom')
                    ->hidden(fn (Get $get) => $get('mediaType') === 'none'),
                FileUpload::make('image')
                    ->disk('media')
                    ->directory('pages')
                    ->visible(fn (Get $get) => $get('mediaType') === 'image'),
                TextInput::make('video')
                    ->label('Video URL')
                    ->url()
                    ->visible(fn (Get $get) => $get('mediaType') === 'video'),
            ]),
        ];
    }
}
