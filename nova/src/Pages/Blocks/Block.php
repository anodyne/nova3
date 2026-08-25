<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks;

use Anodyne\TablerIcons\Tabler;
use Filament\Forms\Components\Builder\Block as BuilderBlock;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Illuminate\Support\Facades\Cache;
use Nova\Foundation\Enums\CacheKeys;
use Nova\Pages\Enums\BackgroundImageIntensity;
use Nova\Pages\Enums\Blur;
use Nova\Pages\Enums\BoxShadow;
use Nova\Pages\Enums\CalloutType;
use Nova\Pages\Enums\MaxWidth;
use Nova\Pages\Enums\Radius;
use Nova\Pages\Enums\Spacing;
use Nova\Pages\Enums\TextShadow;

/** @property string $preview */
abstract class Block extends BuilderBlock
{
    protected ?string $component = null;

    protected ?string $blockLabel = null;

    protected function setUp(): void
    {
        parent::setUp();

        $this->label($this->blockLabel)
            ->schema([
                Tabs::make()
                    ->tabs([
                        Tab::make('container')
                            ->label('Container')
                            ->icon(Tabler::BoxPadding)
                            ->schema($this->containerSchema()),
                        Tab::make('content')
                            ->label('Content')
                            ->icon(Tabler::BoxMargin)
                            ->schema($this->contentSchema()),
                        Tab::make('block')
                            ->label('Block settings')
                            ->icon(Tabler::Settings)
                            ->schema($this->blockSchema())
                            ->visible(fn (): bool => count($this->blockSchema()) > 0),
                    ])
                    ->contained(false),
            ])
            ->preview('components.pages.blocks.'.$this->preview);
    }

    /**
     * @return array<int, Component>
     */
    abstract public function blockSchema(): array;

    /**
     * @return array<int, Component>
     */
    public function containerSchema(): array
    {
        return [
            Section::make()
                ->heading('Dimensions')
                ->description('Customize the width and spacing of the block container')
                ->icon(Tabler::Dimensions)
                ->schema([
                    Select::make('container.width')->options(MaxWidth::class),
                    Section::make('container.spacing')
                        ->heading('Spacing')
                        ->compact()
                        ->schema([
                            Select::make('container.spacing.horizontal')
                                ->label('Horizontal spacing')
                                ->options(Spacing::class)
                                ->default(Spacing::Medium->value),
                            Select::make('container.spacing.vertical')
                                ->label('Vertical spacing')
                                ->options(Spacing::class)
                                ->default(Spacing::Medium->value),
                        ])
                        ->columns(2),
                ]),
            Section::make()
                ->heading('Appearance')
                ->description('Customize the appearance of the block to match your theme / site')
                ->icon(Tabler::Palette)
                ->schema([
                    Section::make('container.bg')
                        ->heading('Background')
                        ->compact()
                        ->schema([
                            Select::make('container.bg.option')
                                ->label('Background option')
                                ->options($this->getBackgroundOptions())
                                ->live(),
                            ColorPicker::make('container.bg.color')
                                ->label('Background color')
                                ->rgba()
                                ->visible(fn (Get $get): bool => $get('container.bg.option') === 'color'),
                            FileUpload::make('container.bg.image')
                                ->label('Background image')
                                ->disk('media-pages')
                                ->directory((string) $this->getPageDesignerPage())
                                ->visible(fn (Get $get): bool => $get('container.bg.option') === 'custom'),
                            Select::make('container.bg.intensity')
                                ->label('Background image intensity')
                                ->options(BackgroundImageIntensity::class)
                                ->hidden(fn (Get $get): bool => blank($get('container.bg.option')) || in_array($get('container.bg.option'), ['color', 'transparent'])),
                        ]),
                ]),
        ];
    }

    /**
     * @return array<int, Component>
     */
    public function contentSchema(): array
    {
        return [
            Section::make()
                ->heading('Dimensions')
                ->description('Customize the width and spacing of the content container')
                ->icon(Tabler::Dimensions)
                ->schema([
                    Select::make('content.width')->options(MaxWidth::class),
                    Section::make('content.spacing')
                        ->heading('Spacing')
                        ->compact()
                        ->schema([
                            Select::make('content.spacing.horizontal')
                                ->label('Horizontal spacing')
                                ->options(Spacing::class)
                                ->default(Spacing::Medium->value),
                            Select::make('content.spacing.vertical')
                                ->label('Vertical spacing')
                                ->options(Spacing::class)
                                ->default(Spacing::Medium->value),
                        ])
                        ->columns(2),
                ]),
            Section::make()
                ->heading('Appearance')
                ->description('Customize the appearance of the block to match your theme / site')
                ->icon(Tabler::Palette)
                ->schema([
                    Section::make('content.bg')
                        ->heading('Background')
                        ->compact()
                        ->schema([
                            Select::make('content.bg.option')
                                ->label('Background option')
                                ->options($this->getBackgroundOptions())
                                ->live(),
                            Grid::make(2)
                                ->schema([
                                    ColorPicker::make('content.bg.color')
                                        ->label('Background color')
                                        ->rgba(),
                                    Select::make('content.bg.blur')
                                        ->label('Background blur')
                                        ->options(Blur::class),
                                ])
                                ->visible(fn (Get $get): bool => $get('content.bg.option') === 'color'),
                            FileUpload::make('content.bg.image')
                                ->label('Background image')
                                ->disk('media-pages')
                                ->directory((string) $this->getPageDesignerPage())
                                ->visible(fn (Get $get): bool => $get('content.bg.option') === 'custom'),
                            Select::make('content.bg.intensity')
                                ->label('Background image intensity')
                                ->options(BackgroundImageIntensity::class)
                                ->hidden(fn (Get $get): bool => blank($get('content.bg.option')) || in_array($get('content.bg.option'), ['color', 'custom', 'transparent'])),
                        ]),
                    Section::make()
                        ->heading('Border')
                        ->compact()
                        ->schema([
                            Grid::make(2)
                                ->schema([
                                    ToggleButtons::make('content.border.enabled')
                                        ->label('Use border around content area')
                                        ->options([
                                            'yes' => 'Yes',
                                            'no' => 'No',
                                        ])
                                        ->inline()
                                        ->live(),
                                    ColorPicker::make('content.border.color')
                                        ->label('Border color')
                                        ->rgba()
                                        ->visible(fn (Get $get): bool => $get('content.border.enabled') == 'yes'),
                                ]),
                        ]),
                    Grid::make(2)->schema([
                        Select::make('content.shadow')
                            ->label('Shadow')
                            ->options(BoxShadow::class)
                            ->default(BoxShadow::None->value),
                        Select::make('content.radius')
                            ->label('Corner radius')
                            ->options(Radius::class)
                            ->default(Radius::None->value),
                    ]),
                ]),
            Section::make()
                ->heading('Content')
                ->description('Add a heading, message, and callout to the block')
                ->icon(Tabler::Blockquote)
                ->schema([
                    ToggleButtons::make('content.orientation')
                        ->label('Orientation')
                        ->inline()
                        ->options([
                            'left' => 'Left',
                            'center' => 'Center',
                            'right' => 'Right',
                        ])
                        ->icons([
                            'left' => Tabler::AlignLeft,
                            'center' => Tabler::AlignCenter,
                            'right' => Tabler::AlignRight,
                        ]),
                    Section::make('content.heading')
                        ->heading('Heading')
                        ->collapsed(fn ($state): bool => data_get($state, 'content.heading.text') === null)
                        ->compact()
                        ->schema([
                            TextInput::make('content.heading.text')->label('Text'),
                            Grid::make(2)->schema([
                                ColorPicker::make('content.heading.color')
                                    ->label('Color')
                                    ->rgba(),
                                Select::make('content.heading.shadow')
                                    ->label('Text shadow')
                                    ->options(TextShadow::class)
                                    ->default(TextShadow::None->value),
                            ]),
                        ]),
                    Section::make('content.message')
                        ->heading('Message')
                        ->collapsed(fn ($state): bool => data_get($state, 'content.message.text') === null)
                        ->compact()
                        ->schema([
                            MarkdownEditor::make('content.message.text')
                                ->label('Text')
                                ->toolbarButtons([
                                    'blockquote',
                                    'bold',
                                    'bulletList',
                                    'italic',
                                    'link',
                                    'orderedList',
                                ]),
                            Grid::make(2)->schema([
                                ColorPicker::make('content.message.color')
                                    ->label('Color')
                                    ->rgba(),
                                Select::make('content.message.shadow')
                                    ->label('Text shadow')
                                    ->options(TextShadow::class)
                                    ->default(TextShadow::None->value),
                            ]),
                        ]),
                    Section::make('content.callout')
                        ->heading('Callout')
                        ->collapsed(fn ($state): bool => data_get($state, 'content.callout.text') === null)
                        ->compact()
                        ->schema([
                            Grid::make(2)->schema([
                                TextInput::make('content.callout.text')
                                    ->label('Text')
                                    ->live(onBlur: true),
                                Select::make('content.callout.decoration')
                                    ->options([
                                        'none' => 'None',
                                        'arrow' => 'Arrow',
                                        'single-chevron' => 'Single chevron',
                                        'double-chevron' => 'Double chevron',
                                    ])
                                    ->default('none'),
                                TextInput::make('content.callout.url')
                                    ->label('URL')
                                    ->url()
                                    ->columnSpanFull(),
                                ToggleButtons::make('content.callout.type')
                                    ->label('Display as')
                                    ->inline()
                                    ->options(CalloutType::class)
                                    ->default(CalloutType::Text->value)
                                    ->live(),
                                ColorPicker::make('content.callout.color')
                                    ->label('Text color')
                                    ->rgba(),
                                Grid::make(2)->schema([
                                    ColorPicker::make('content.callout.bg.color')
                                        ->label('Background color')
                                        ->rgba(),
                                    ColorPicker::make('content.callout.border.color')
                                        ->label('Border color')
                                        ->rgba(),
                                    Select::make('content.callout.shadow')
                                        ->label('Shadow')
                                        ->options(BoxShadow::class)
                                        ->default(BoxShadow::None->value),
                                    Select::make('content.callout.radius')
                                        ->label('Corner radius')
                                        ->options(Radius::class)
                                        ->default(Radius::None->value),
                                ])
                                    ->visible(fn (Get $get): bool => $get('content.callout.type') === CalloutType::Badge->value),
                            ]),
                        ]),
                ]),
        ];
    }

    protected function getPageDesignerPage(): int
    {
        return (int) Cache::get(CacheKeys::PageDesignerPage->value);
    }

    /** @return array<string, string|array<string, string>> */
    protected function getBackgroundOptions(): array
    {
        return [
            'Solid color' => [
                'transparent' => 'Transparent',
                'color' => 'Pick a custom color',
            ],
            'custom' => 'Custom image',
            'Light mesh gradient' => [
                'mesh-light-000' => '#000',
                'mesh-light-001' => '#001',
                'mesh-light-002' => '#002',
                'mesh-light-003' => '#003',
                'mesh-light-004' => '#004',
                'mesh-light-005' => '#005',
                'mesh-light-006' => '#006',
                'mesh-light-007' => '#007',
                'mesh-light-008' => '#008',
                'mesh-light-009' => '#009',
                'mesh-light-010' => '#010',
                'mesh-light-011' => '#011',
                'mesh-light-012' => '#012',
                'mesh-light-013' => '#013',
                'mesh-light-014' => '#014',
                'mesh-light-015' => '#015',
                'mesh-light-016' => '#016',
                'mesh-light-017' => '#017',
                'mesh-light-018' => '#018',
                'mesh-light-019' => '#019',
            ],
            'Light image' => [
                'peak' => 'Peak',
                'ribbon' => 'Ribbon',
                'ribbon-full' => 'Ribbon (full)',
                'waves-flat' => 'Waves (flat)',
                'waves-narrow' => 'Waves (narrow)',
                'waves-tall' => 'Waves (tall)',
            ],
            'Dark mesh gradient' => [
                'mesh-dark-000' => '#000',
                'mesh-dark-001' => '#001',
                'mesh-dark-002' => '#002',
                'mesh-dark-003' => '#003',
                'mesh-dark-004' => '#004',
                'mesh-dark-005' => '#005',
                'mesh-dark-006' => '#006',
                'mesh-dark-007' => '#007',
                'mesh-dark-008' => '#008',
                'mesh-dark-009' => '#009',
                'mesh-dark-010' => '#010',
                'mesh-dark-011' => '#011',
                'mesh-dark-012' => '#012',
                'mesh-dark-013' => '#013',
                'mesh-dark-014' => '#014',
                'mesh-dark-015' => '#015',
                'mesh-dark-016' => '#016',
                'mesh-dark-017' => '#017',
                'mesh-dark-018' => '#018',
                'mesh-dark-019' => '#019',
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
        ];
    }
}
