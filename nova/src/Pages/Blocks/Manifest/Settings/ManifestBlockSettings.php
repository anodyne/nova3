<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Manifest\Settings;

use Awcodes\Scribble\Enums\SlideDirection;
use Awcodes\Scribble\Livewire\ScribbleModal;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Get;
use Filament\Support\Enums\MaxWidth;
use Nova\Departments\Models\Department;
use Nova\Departments\Models\Position;
use Nova\Pages\Blocks\FormSchema;

class ManifestBlockSettings extends ScribbleModal
{
    public ?string $header = 'Character Manifest block';

    public ?string $identifier = 'manifest';

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
            ...FormSchema::heading(withOrientation: true),
            ...FormSchema::backgroundColor(),

            Section::make('Layout')
                ->schema([
                    Select::make('layout')
                        ->options([
                            'table' => 'Table',
                            'grid' => 'Grid',
                            'cards' => 'Cards',
                        ])
                        ->default('table')
                        ->live(),
                    Repeater::make('columns')
                        ->schema([
                            Select::make('column')
                                ->options([
                                    'character-name' => 'Character name',
                                    'character-type' => 'Character type',
                                    'character-status' => 'Character status',
                                    'position-name' => 'Position name',
                                    'rank-name' => 'Rank name',
                                    'rank-image' => 'Rank image',
                                ])
                                ->live(),
                            CheckboxList::make('characterOptions')
                                ->options([
                                    'avatar' => 'Show avatar',
                                    'position' => 'Show position name',
                                    'rank' => 'Show rank name',
                                ])
                                ->visible(fn (Get $get): bool => $get('column') === 'character-name'),
                            Select::make('width')
                                ->options([
                                    '100%' => '100%',
                                    '95%' => '95%',
                                    '90%' => '90%',
                                    '85%' => '85%',
                                    '80%' => '80%',
                                    '75%' => '75%',
                                    '70%' => '70%',
                                    '65%' => '65%',
                                    '60%' => '60%',
                                    '55%' => '55%',
                                    '50%' => '50%',
                                    '45%' => '45%',
                                    '40%' => '40%',
                                    '35%' => '35%',
                                    '30%' => '30%',
                                    '25%' => '25%',
                                    '20%' => '20%',
                                    '15%' => '15%',
                                    '10%' => '10%',
                                    '5%' => '5%',
                                    'fit' => 'Fit to content',
                                    'fill' => 'Fill remaining space',
                                ])
                                ->default('fit')
                                ->helperText('Keep in mind that percetage widths will vary for each theme. If you change your theme, be sure to readjust your column widths.'),
                        ])
                        ->visible(fn (Get $get): bool => $get('layout') === 'table'),
                    CheckboxList::make('characterOptions')
                        ->label('Character display options')
                        ->options([
                            'avatar' => 'Show avatar',
                            'position' => 'Show position name',
                            'rank-name' => 'Show rank name',
                            'rank-image' => 'Show rank image',
                            'type' => 'Show type',
                            'status' => 'Show status',
                        ])
                        ->visible(fn (Get $get): bool => $get('layout') === 'grid' || $get('layout') === 'cards'),
                    Select::make('cardOrientation')
                        ->options([
                            'left' => 'Left',
                            'center' => 'Centered',
                        ])
                        ->visible(fn (Get $get): bool => $get('layout') === 'cards'),
                ]),

            Toggle::make('showDepartments')
                ->label('Show departments on the manifest')
                ->live(),

            Section::make('Department criteria')
                ->description('Set the criteria that will be used for displaying departments')
                ->schema([
                    Select::make('departmentStatus')
                        ->label('Departments to display')
                        ->options([
                            'all' => 'All departments',
                            'active' => 'Only active departments',
                            'inactive' => 'Only inactive departments',
                            'choose' => 'Choose departments to display',
                            // 'tags' => 'Departments with specific tag(s)',
                        ])
                        ->helperText('Departments without assigned characters will not be displayed unless you choose to show available positions')
                        ->live(),
                    Select::make('selectedDepartments')
                        ->preload()
                        ->multiple()
                        ->visible(fn (Get $get): bool => $get('departmentStatus') === 'choose')
                        ->options(fn () => Department::get()->pluck('name', 'id')),
                    Select::make('departmentTags')
                        ->preload()
                        ->multiple()
                        ->visible(fn (Get $get): bool => $get('departmentStatus') === 'tags')
                        ->options(fn () => Department::get()->pluck('name', 'id')),
                ])
                ->visible(fn (Get $get): bool => $get('showDepartments') === true),

            Section::make('Position criteria')
                ->description('Set the criteria that will be used for displaying positions')
                ->schema([
                    Select::make('positionStatus')
                        ->label('Positions to display for the department')
                        ->options([
                            'all' => 'All positions',
                            'active' => 'Only active positions',
                            'inactive' => 'Only inactive positions',
                            'choose' => 'Choose positions to display',
                            // 'tags' => 'Positions with specific tag(s)',
                        ])
                        ->live(),
                    Select::make('selectedPositions')
                        ->preload()
                        ->multiple()
                        ->visible(fn (Get $get): bool => $get('positionStatus') === 'choose')
                        ->options(fn () => Position::get()->pluck('name', 'id')),
                ])
                ->visible(fn (Get $get): bool => $get('showDepartments') === true),

            Toggle::make('showAvailablePositions')
                ->label('Show available positions on the manifest')
                ->live(),

            Section::make('Available position criteria')
                ->description('Set the criteria that will be used for displaying available positions')
                ->schema([
                    Select::make('availablePositionsStatus')
                        ->label('Positions to display for the department')
                        ->options([
                            'all' => 'All available positions',
                            'choose' => 'Choose available positions to display',
                            'tags' => 'Available positions with specific tag(s)',
                        ])
                        ->helperText('Only active positions will be displayed')
                        ->live(),
                    Select::make('selectedAvailablePositions')
                        ->preload()
                        ->multiple()
                        ->visible(fn (Get $get): bool => $get('availablePositionsStatus') === 'choose')
                        ->options(fn () => Position::active()->available()->get()->pluck('name', 'id')),
                ])
                ->visible(fn (Get $get): bool => $get('showAvailablePositions') === true),

            Toggle::make('showCharacters')
                ->label('Show characters on the manifest')
                ->helperText('Disable this if you want to show a list of available positions')
                ->live(),

            Section::make('Character criteria')
                ->description('Set the criteria that will be used for displaying characters')
                ->schema([
                    Select::make('characterStatus')
                        ->options([
                            'all' => 'All characters',
                            'active' => 'Only active characters',
                            'inactive' => 'Only inactive characters',
                        ]),
                    Select::make('characterType')
                        ->options([
                            'all' => 'All character types',
                            'primary' => 'Only primary characters',
                            'secondary' => 'Only secondary characters',
                            'support' => 'Only support characters',
                            'primary-secondary' => 'Primary and secondary characters',
                            'primary-support' => 'Primary and support characters',
                            'secondary-support' => 'Secondary and support characters',
                        ]),
                ])
                ->visible(fn (Get $get): bool => $get('showCharacters') === true),
        ];
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

            'layout' => $this->data['layout'] ?? null,

            'columns' => $this->data['columns'] ?? [],
            'cardOrientation' => $this->data['cardOrientation'] ?? null,

            'characterOptions' => $this->data['characterOptions'] ?? [],

            'showDepartments' => $this->data['showDepartments'] ?? null,
            'departmentStatus' => $this->data['departmentStatus'] ?? null,
            'selectedDepartments' => $this->data['selectedDepartments'] ?? [],
            'departmentTags' => $this->data['departmentTags'] ?? [],
            'positionStatus' => $this->data['positionStatus'] ?? null,
            'selectedPositions' => $this->data['selectedPositions'] ?? [],
            'positionTags' => $this->data['positionTags'] ?? [],

            'showAvailablePositions' => $this->data['showAvailablePositions'] ?? null,
            'availablePositionsStatus' => $this->data['availablePositionsStatus'] ?? null,
            'selectedAvailablePositions' => $this->data['selectedAvailablePositions'] ?? [],

            'showCharacters' => $this->data['showCharacters'] ?? null,
            'characterStatus' => $this->data['characterStatus'] ?? null,
            'characterType' => $this->data['characterType'] ?? null,
        ]);
    }
}
