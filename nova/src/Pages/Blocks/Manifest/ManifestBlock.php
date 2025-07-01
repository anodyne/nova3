<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Manifest;

use Closure;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Get;
use Nova\Departments\Models\Department;
use Nova\Departments\Models\Position;
use Nova\Pages\Blocks\Block as PageBuilderBlock;

class ManifestBlock extends PageBuilderBlock
{
    const component = 'manifest.index';

    protected ?string $blockLabel = 'Manifest - Character manifest block';

    protected string|Closure|null $preview = 'manifest.index';

    protected string|Closure $section = 'Manifest';

    public function blockSchema(): array
    {
        return [
            Section::make()
                ->heading('Layout')
                ->icon(iconName('layout'))
                ->schema([
                    Select::make('block.layout')
                        ->options([
                            'table' => 'Table',
                            'grid' => 'Grid',
                            'cards' => 'Cards',
                        ])
                        ->default('table')
                        ->live(),
                    Repeater::make('block.columns')
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
                        ->visible(fn (Get $get): bool => $get('block.layout') === 'table'),
                    CheckboxList::make('block.characterOptions')
                        ->label('Character display options')
                        ->options([
                            'avatar' => 'Show avatar',
                            'position' => 'Show position name',
                            'rank-name' => 'Show rank name',
                            'rank-image' => 'Show rank image',
                            'type' => 'Show type',
                            'status' => 'Show status',
                        ])
                        ->visible(fn (Get $get): bool => $get('block.layout') === 'grid' || $get('block.layout') === 'cards'),
                    Select::make('block.cardOrientation')
                        ->options([
                            'left' => 'Left',
                            'center' => 'Centered',
                        ])
                        ->visible(fn (Get $get): bool => $get('block.layout') === 'cards'),
                ]),

            Section::make()
                ->heading('Departments')
                ->icon(iconName('list-details'))
                ->schema([
                    Toggle::make('block.showDepartments')
                        ->label('Show departments on the manifest')
                        ->live(),

                    Section::make()
                        ->heading('Department criteria')
                        ->description('Set the criteria that will be used for displaying departments')
                        ->compact()
                        ->schema([
                            Select::make('block.departmentStatus')
                                ->label('Departments to display')
                                ->options([
                                    'all' => 'All departments',
                                    'active' => 'Only active departments',
                                    'inactive' => 'Only inactive departments',
                                    'choose' => 'Choose departments to display',
                                    'tags' => 'Departments with specific tag(s)',
                                ])
                                ->helperText('Departments without assigned characters will not be displayed unless you choose to show available positions')
                                ->live(),
                            Select::make('block.selectedDepartments')
                                ->preload()
                                ->multiple()
                                ->visible(fn (Get $get): bool => $get('block.departmentStatus') === 'choose')
                                ->options(fn () => Department::get()->pluck('name', 'id')),
                            Select::make('block.taggedDepartments')
                                ->preload()
                                ->multiple()
                                ->visible(fn (Get $get): bool => $get('block.departmentStatus') === 'tags')
                                ->options(fn () => Department::query()->uniqueTags()),
                        ])
                        ->visible(fn (Get $get): bool => $get('block.showDepartments') === true),

                    Section::make()
                        ->heading('Position criteria')
                        ->description('Set the criteria that will be used for displaying positions')
                        ->compact()
                        ->schema([
                            Select::make('block.positionStatus')
                                ->label('Positions to display for the department')
                                ->options([
                                    'all' => 'All positions',
                                    'active' => 'Only active positions',
                                    'inactive' => 'Only inactive positions',
                                    'choose' => 'Choose positions to display',
                                    'tags' => 'Positions with specific tag(s)',
                                ])
                                ->live(),
                            Select::make('block.selectedPositions')
                                ->preload()
                                ->multiple()
                                ->visible(fn (Get $get): bool => $get('block.positionStatus') === 'choose')
                                ->options(fn () => Position::get()->pluck('name', 'id')),
                            Select::make('block.taggedPositions')
                                ->preload()
                                ->multiple()
                                ->visible(fn (Get $get): bool => $get('block.positionStatus') === 'tags')
                                ->options(fn () => Position::query()->uniqueTags()),
                        ])
                        ->visible(fn (Get $get): bool => $get('block.showDepartments') === true),
                ]),

            Section::make()
                ->heading('Available positions')
                ->icon(iconName('enter'))
                ->schema([
                    Toggle::make('block.showAvailablePositions')
                        ->label('Show available positions on the manifest')
                        ->live(),

                    Section::make('Available position criteria')
                        ->description('Set the criteria that will be used for displaying available positions')
                        ->compact()
                        ->schema([
                            Select::make('block.availablePositionsStatus')
                                ->label('Positions to display for the department')
                                ->options([
                                    'all' => 'All available positions',
                                    'choose' => 'Choose available positions to display',
                                    'tags' => 'Available positions with specific tag(s)',
                                ])
                                ->helperText('Only active positions will be displayed')
                                ->live(),
                            Select::make('block.selectedAvailablePositions')
                                ->preload()
                                ->multiple()
                                ->visible(fn (Get $get): bool => $get('block.availablePositionsStatus') === 'choose')
                                ->options(fn () => Position::active()->available()->get()->pluck('name', 'id')),
                            Select::make('block.taggedAvailablePositions')
                                ->preload()
                                ->multiple()
                                ->visible(fn (Get $get): bool => $get('block.availablePositionsStatus') === 'tags')
                                ->options(fn () => Position::query()->uniqueTags()),
                        ])
                        ->visible(fn (Get $get): bool => $get('block.showAvailablePositions') === true),
                ]),

            Section::make()
                ->heading('Characters')
                ->icon(iconName('characters'))
                ->schema([
                    Toggle::make('block.showCharacters')
                        ->label('Show characters on the manifest')
                        ->helperText('Disable this if you want to show a list of available positions')
                        ->live(),

                    Section::make('Character criteria')
                        ->description('Set the criteria that will be used for displaying characters')
                        ->compact()
                        ->schema([
                            Select::make('block.characterStatus')
                                ->options([
                                    'all' => 'All characters',
                                    'active' => 'Only active characters',
                                    'inactive' => 'Only inactive characters',
                                ]),
                            Select::make('block.characterType')
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
                        ->visible(fn (Get $get): bool => $get('block.showCharacters') === true),
                ]),

        ];
    }
}
