<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Get;
use Illuminate\Support\Facades\Cache;

class FormSchema
{
    public static function backgroundOption(bool $withImageOption = true): Field
    {
        $options = [
            'transparent' => 'Transparent',
            'tailwind' => 'Pick a pre-defined color',
            'color' => 'Pick a custom color',
        ];

        if ($withImageOption) {
            $options['image'] = 'Background image';
        }

        return Select::make('bgOption')
            ->label('Background option')
            ->options($options);
    }

    public static function backgroundSection(): array
    {
        $page = Cache::get('page-designer-page');

        return [
            Section::make('Background')->schema([
                Select::make('bgOption')
                    ->label('Background option')
                    ->options([
                        'Solid color' => [
                            'transparent' => 'Transparent',
                            'color' => 'Pick a custom color',
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
                ColorPicker::make('bgColor')
                    ->label('Background color')
                    ->visible(fn (Get $get) => $get('bgOption') === 'color'),
                FileUpload::make('bgImage')
                    ->label('Background image')
                    ->disk('media')
                    ->directory('pages/'.$page)
                    ->visible(fn (Get $get) => $get('bgOption') === 'custom'),
                Select::make('bgImageIntensity')
                    ->label('Background image intensity')
                    ->options([
                        'none' => 'No overlay',
                        'intense' => 'Intense',
                        'vivid' => 'Vivid',
                        'neutral' => 'Neutral',
                        'muted' => 'Muted',
                        'subtle' => 'Subtle',
                    ])
                    ->hidden(fn (Get $get) => blank($get('bgOption')) || in_array($get('bgOption'), ['color', 'custom', 'transparent'])),
                ...static::dark(),
                ...static::spacing(),
            ]),
        ];
    }

    public static function backgroundColor(): array
    {
        return [
            Section::make('Background')->schema([
                Select::make('bgOption')
                    ->label('Background option')
                    ->options([
                        'transparent' => 'Transparent',
                        'color' => 'Pick a color',
                    ])
                    ->default('transparent')
                    ->live(),
                ColorPicker::make('bgColor')
                    ->label('Background color')
                    ->visible(fn (Get $get) => $get('bgOption') === 'color'),
                ...static::dark(),
                ...static::spacing(),
            ]),
        ];
    }

    public static function dark(?string $label = null): array
    {

        return [
            Toggle::make('dark')->label($label ?? 'Invert text colors for dark backgrounds'),
        ];
    }

    public static function heading(array $fields = [], bool $withOrientation = false): array
    {
        return [
            Section::make('Heading')->schema(array_merge(
                [
                    TextInput::make('heading'),
                    Textarea::make('description')
                        ->helperText('You are free to use Markdown in your description for basic styling')
                        ->rows(5),
                    Select::make('headerOrientation')
                        ->label('Orientation')
                        ->options([
                            'center' => 'Center',
                            'left' => 'Left',
                            'right' => 'Right',
                        ])
                        ->default('center')
                        ->visible($withOrientation),
                ],
                $fields,
            )),
        ];
    }

    public static function mediaLeftRight(): array
    {
        $page = Cache::get('page-designer-page');

        return [
            Section::make('Media')->schema([
                Radio::make('mediaType')
                    ->options([
                        'none' => 'No media',
                        'image' => 'Image',
                        'video' => 'Video',
                    ])
                    ->default('none')
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
                    ->directory('pages/'.$page)
                    ->maxFiles(1)
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
        $page = Cache::get('page-designer-page');

        return [
            Section::make('Media')->schema([
                Radio::make('mediaType')
                    ->options([
                        'none' => 'No media',
                        'image' => 'Image',
                        'video' => 'Video',
                    ])
                    ->default('none')
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
                    ->directory('pages/'.$page)
                    ->visible(fn (Get $get) => $get('mediaType') === 'image'),
                TextInput::make('video')
                    ->label('Video URL')
                    ->url()
                    ->visible(fn (Get $get) => $get('mediaType') === 'video'),
            ]),
        ];
    }

    public static function primaryButtonSection(): array
    {
        return [
            Section::make('Primary button')
                ->description('The primary button will appear if both the label and URL are filled')
                ->schema([
                    TextInput::make('primaryButtonLabel')
                        ->label('Label')
                        ->live(),
                    TextInput::make('primaryButtonUrl')
                        ->label('URL')
                        ->url(),
                    Grid::make(2)->schema([
                        ColorPicker::make('primaryButtonBgColor')->label('Background color'),
                        ColorPicker::make('primaryButtonTextColor')
                            ->label('Text color')
                            ->default('#ffffff'),
                    ]),
                ]),
        ];
    }

    public static function secondaryButtonSection(): array
    {
        return [
            Section::make('Secondary button')
                ->description('The secondary button will appear if both the label and URL are filled')
                ->schema([
                    TextInput::make('secondaryButtonLabel')
                        ->label('Label'),
                    TextInput::make('secondaryButtonUrl')
                        ->label('URL')
                        ->url(),
                ]),
        ];
    }

    public static function spacing(bool $withHorizontal = true, bool $withVertical = true): array
    {
        return [
            Select::make('spacingHorizontal')
                ->label('Horizontal spacing')
                ->options([
                    'small' => 'Small',
                    'medium' => 'Medium',
                    'large' => 'Large',
                    'extra-large' => 'Extra large',
                    'none' => 'None',
                ])
                ->default('medium')
                ->visible($withHorizontal),
            Select::make('spacingVertical')
                ->label('Vertical spacing')
                ->options([
                    'small' => 'Small',
                    'medium' => 'Medium',
                    'large' => 'Large',
                    'extra-large' => 'Extra large',
                    'none' => 'None',
                ])
                ->default('large')
                ->visible($withVertical),
        ];
    }

    public static function tailwindColor(string $name): Field
    {
        return Select::make($name)
            ->options([
                'Slate' => 'Slate',
                'Gray' => 'Gray',
                'Zinc' => 'Zinc',
                'Neutral' => 'Neutral',
                'Stone' => 'Stone',
                'Red' => 'Red',
                'RadicalRed' => 'Radical Red',
                'ImperialRed' => 'Imperial Red',
                'Orange' => 'Orange',
                'Amber' => 'Amber',
                'Yellow' => 'Yellow',
                'Lime' => 'Lime',
                'Green' => 'Green',
                'SeaGreen' => 'Sea Green',
                'Emerald' => 'Emerald',
                'Teal' => 'Teal',
                'Cyan' => 'Cyan',
                'Sky' => 'Sky',
                'Blue' => 'Blue',
                'Indigo' => 'Indigo',
                'Violet' => 'Violet',
                'Purple' => 'Purple',
                'Orchid' => 'Orchid',
                'Fuchsia' => 'Fuchsia',
                'Pink' => 'Pink',
                'Rose' => 'Rose',
            ]);
    }
}
