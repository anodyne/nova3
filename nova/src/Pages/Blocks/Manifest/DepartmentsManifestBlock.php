<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Manifest;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Get;
use Nova\Departments\Models\Department;
use Nova\Departments\Models\Position;

class DepartmentsManifestBlock extends ManifestBlock
{
    public ?string $label = 'Manifest - By departments';

    public string $rendered = 'pages.pages.blocks.manifest.departments';

    public string $preview = 'pages.pages.blocks.manifest.departments-preview';

    public function getFormSchema(): array
    {
        return [
            ...parent::getFormSchema(),
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
                ]),
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
                    Toggle::make('showAvailablePositions')
                        ->label('Show positions with open slots')
                        ->hidden(fn (Get $get): bool => $get('positionStatus') === 'choose'),
                    Select::make('selectedPositions')
                        ->preload()
                        ->multiple()
                        ->visible(fn (Get $get): bool => $get('positionStatus') === 'choose')
                        ->options(fn () => Position::get()->pluck('name', 'id')),
                ]),
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
                ]),
            Section::make('Layout')
                ->schema([
                    Select::make('layout')
                        ->options([
                            'table' => 'Table',
                            'grid' => 'Grid',
                            'cards' => 'Cards',
                        ])
                        ->live(),
                    Repeater::make('columns')
                        ->schema([
                            Select::make('column')
                                ->options([
                                    'character-name' => 'Character name',
                                    'charcter-type' => 'Character type',
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
                        ])
                        ->visible(fn (Get $get): bool => $get('layout') === 'table'),
                    Select::make('cardOrientation')
                        ->options([
                            'left' => 'Left',
                            'center' => 'Centered',
                        ])
                        ->visible(fn (Get $get): bool => $get('layout') === 'cards'),
                ]),
        ];
    }
}
