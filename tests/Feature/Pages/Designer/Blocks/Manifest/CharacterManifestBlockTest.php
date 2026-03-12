<?php

declare(strict_types=1);

use Nova\Characters\Models\Character;
use Nova\Departments\Models\Department;
use Nova\Departments\Models\Position;
use Nova\Pages\Blocks\Manifest\ManifestBlock;
use Nova\Pages\Blocks\PageBlockRegistry;
use Nova\Pages\Livewire\CharactersManifest;
use Nova\Pages\Models\Page;

uses()->group('pages', 'page-blocks');

use function Pest\Livewire\livewire;

describe('rendered output', function () {
    beforeEach(function () {
        $department = Department::factory()->active()->create();
        $position = Position::factory()->active()->create(['department_id' => $department->id]);

        $character = Character::factory()->active()->create();
        $character->positions()->attach($position);
    });

    test('renders the manifest as a table', function () {
        $page = Page::factory()->basic()->published([
            [
                'type' => 'manifest.index',
                'data' => [
                    'block' => [
                        'layout' => 'table',
                        'columns' => [],
                        'characterOptions' => [],
                        'showDepartments' => true,
                        'departmentStatus' => 'active',
                        'positionStatus' => 'active',
                        'showAvailablePositions' => false,
                        'showCharacters' => true,
                        'characterStatus' => 'active',
                        'characterType' => 'all',
                    ],
                ],
            ],
        ])->create();

        $view = view('test-page-render', ['page' => $page]);
        $html = $view->render();

        expect($html)
            ->toContain('nv-manifest')
            ->toContain('nv-manifest-table');
    });

    test('renders the manifest as a grid', function () {
        $page = Page::factory()->basic()->published([
            [
                'type' => 'manifest.index',
                'data' => [
                    'block' => [
                        'layout' => 'grid',
                        'characterOptions' => [],
                        'showDepartments' => true,
                        'departmentStatus' => 'active',
                        'positionStatus' => 'active',
                        'showAvailablePositions' => false,
                        'showCharacters' => true,
                        'characterStatus' => 'active',
                        'characterType' => 'all',
                    ],
                ],
            ],
        ])->create();

        $view = view('test-page-render', ['page' => $page]);
        $html = $view->render();

        expect($html)
            ->toContain('nv-manifest')
            ->toContain('nv-manifest-grid');
    });

    test('renders the manifest as cards', function () {
        $page = Page::factory()->basic()->published([
            [
                'type' => 'manifest.index',
                'data' => [
                    'block' => [
                        'layout' => 'cards',
                        'characterOptions' => [],
                        'showDepartments' => true,
                        'departmentStatus' => 'active',
                        'positionStatus' => 'active',
                        'showAvailablePositions' => false,
                        'showCharacters' => true,
                        'characterStatus' => 'active',
                        'characterType' => 'all',
                    ],
                ],
            ],
        ])->create();

        $view = view('test-page-render', ['page' => $page]);
        $html = $view->render();

        expect($html)
            ->toContain('nv-manifest')
            ->toContain('nv-manifest-cards');
    });
});

describe('livewire component', function () {
    test('characters returns null when disabled', function () {
        $component = livewire(CharactersManifest::class);

        expect($component->instance()->characters)->toBeNull();
    });

    test('filters characters by status', function (string $status, array $expected, array $unexpected) {
        Character::factory()->active()->create(['name' => 'Active Character']);
        Character::factory()->inactive()->create(['name' => 'Inactive Character']);
        Character::factory()->pending()->create(['name' => 'Pending Character']);

        $component = livewire(CharactersManifest::class, [
            'showCharacters' => true,
            'characterStatus' => $status,
        ]);
        $names = $component->instance()->characters->pluck('name')->toArray();

        expect($names)->toHaveCount(count($expected));

        foreach ($expected as $name) {
            expect($names)->toContain($name);
        }

        foreach ($unexpected as $name) {
            expect($names)->not->toContain($name);
        }
    })->with([
        'all' => ['all', ['Active Character', 'Inactive Character'], ['Pending Character']],
        'active' => ['active', ['Active Character'], ['Inactive Character', 'Pending Character']],
        'inactive' => ['inactive', ['Inactive Character'], ['Active Character', 'Pending Character']],
    ]);

    test('filters characters by type', function (?string $type, array $expected, array $unexpected) {
        Character::factory()->active()->primary()->create(['name' => 'Primary Character']);
        Character::factory()->active()->secondary()->create(['name' => 'Secondary Character']);
        Character::factory()->active()->support()->create(['name' => 'Support Character']);

        $component = livewire(CharactersManifest::class, [
            'showCharacters' => true,
            'characterStatus' => 'active',
            'characterType' => $type,
        ]);
        $names = $component->instance()->characters->pluck('name')->toArray();

        expect($names)->toHaveCount(count($expected));

        foreach ($expected as $name) {
            expect($names)->toContain($name);
        }

        foreach ($unexpected as $name) {
            expect($names)->not->toContain($name);
        }
    })->with([
        'all' => ['all', ['Primary Character', 'Secondary Character', 'Support Character'], []],
        'primary' => ['primary', ['Primary Character'], ['Secondary Character', 'Support Character']],
        'secondary' => ['secondary', ['Secondary Character'], ['Primary Character', 'Support Character']],
        'support' => ['support', ['Support Character'], ['Primary Character', 'Secondary Character']],
        'primary-secondary' => ['primary-secondary', ['Primary Character', 'Secondary Character'], ['Support Character']],
        'primary-support' => ['primary-support', ['Primary Character', 'Support Character'], ['Secondary Character']],
        'secondary-support' => ['secondary-support', ['Secondary Character', 'Support Character'], ['Primary Character']],
        'null' => [null, ['Primary Character', 'Secondary Character', 'Support Character'], []],
    ]);

    test('departments returns null when disabled', function () {
        $component = livewire(CharactersManifest::class);

        expect($component->instance()->departments)->toBeNull();
    });

    test('filters departments by status', function (string $status, array $selected, array $tags, array $expected, array $unexpected) {
        $activeDepartment = Department::factory()->active()->create(['name' => 'Active Department']);
        $inactiveDepartment = Department::factory()->inactive()->create(['name' => 'Inactive Department']);
        $taggedDepartment = Department::factory()->active()->create([
            'name' => 'Tagged Department',
            'tags' => ['alpha'],
        ]);

        Position::factory()->active()->create(['department_id' => $activeDepartment->id]);
        Position::factory()->active()->create(['department_id' => $inactiveDepartment->id]);
        Position::factory()->active()->create(['department_id' => $taggedDepartment->id]);

        $selectedDepartmentIds = array_map(
            fn (string $name) => match ($name) {
                'Active Department' => $activeDepartment->id,
                'Inactive Department' => $inactiveDepartment->id,
                'Tagged Department' => $taggedDepartment->id,
                default => null,
            },
            $selected
        );

        $component = livewire(CharactersManifest::class, [
            'showDepartments' => true,
            'departmentStatus' => $status,
            'selectedDepartments' => array_filter($selectedDepartmentIds),
            'taggedDepartments' => $tags,
            'positionStatus' => 'all',
        ]);
        $names = $component->instance()->departments->pluck('name')->toArray();

        expect($names)->toHaveCount(count($expected));

        foreach ($expected as $name) {
            expect($names)->toContain($name);
        }

        foreach ($unexpected as $name) {
            expect($names)->not->toContain($name);
        }
    })->with([
        'active' => ['active', [], [], ['Active Department', 'Tagged Department'], ['Inactive Department']],
        'inactive' => ['inactive', [], [], ['Inactive Department'], ['Active Department', 'Tagged Department']],
        'choose' => ['choose', ['Active Department'], [], ['Active Department'], ['Inactive Department', 'Tagged Department']],
        'tags' => ['tags', [], ['alpha'], ['Tagged Department'], ['Active Department', 'Inactive Department']],
    ]);

    test('filters department positions by status', function (string $status, array $selected, array $tags, array $expected, array $unexpected) {
        $department = Department::factory()->active()->create(['name' => 'Department']);

        $activePosition = Position::factory()->active()->create([
            'department_id' => $department->id,
            'name' => 'Active Position',
        ]);
        $inactivePosition = Position::factory()->inactive()->create([
            'department_id' => $department->id,
            'name' => 'Inactive Position',
        ]);
        $taggedPosition = Position::factory()->active()->create([
            'department_id' => $department->id,
            'name' => 'Tagged Position',
            'tags' => ['alpha'],
        ]);

        $selectedPositionIds = array_map(
            fn (string $name) => match ($name) {
                'Active Position' => $activePosition->id,
                'Inactive Position' => $inactivePosition->id,
                'Tagged Position' => $taggedPosition->id,
                default => null,
            },
            $selected
        );

        $component = livewire(CharactersManifest::class, [
            'showDepartments' => true,
            'departmentStatus' => 'all',
            'positionStatus' => $status,
            'selectedPositions' => array_filter($selectedPositionIds),
            'taggedPositions' => $tags,
        ]);

        $departmentPositions = $component->instance()->departments->first()->positions;
        $names = $departmentPositions->pluck('name')->toArray();

        expect($names)->toHaveCount(count($expected));

        foreach ($expected as $name) {
            expect($names)->toContain($name);
        }

        foreach ($unexpected as $name) {
            expect($names)->not->toContain($name);
        }
    })->with([
        'active' => ['active', [], [], ['Active Position', 'Tagged Position'], ['Inactive Position']],
        'inactive' => ['inactive', [], [], ['Inactive Position'], ['Active Position', 'Tagged Position']],
        'choose' => ['choose', ['Active Position'], [], ['Active Position'], ['Inactive Position', 'Tagged Position']],
        'tags' => ['tags', [], ['alpha'], ['Tagged Position'], ['Active Position', 'Inactive Position']],
    ]);

    test('filters department positions based on character filters', function () {
        $department = Department::factory()->active()->create();
        $activePosition = Position::factory()->active()->create(['department_id' => $department->id]);
        $inactivePosition = Position::factory()->active()->create(['department_id' => $department->id]);

        $activeCharacter = Character::factory()->active()->create();
        $inactiveCharacter = Character::factory()->inactive()->create();

        $activePosition->characters()->attach($activeCharacter);
        $inactivePosition->characters()->attach($inactiveCharacter);

        $component = livewire(CharactersManifest::class, [
            'showDepartments' => true,
            'showCharacters' => true,
            'showAvailablePositions' => false,
            'departmentStatus' => 'all',
            'positionStatus' => 'all',
            'characterStatus' => 'active',
        ]);

        $positions = $component->instance()->departments->first()->positions;
        $positionIds = $positions->pluck('id')->toArray();

        expect($positionIds)
            ->toContain($activePosition->id)
            ->not->toContain($inactivePosition->id);
    });

    test('positions returns null when disabled', function () {
        $component = livewire(CharactersManifest::class);

        expect($component->instance()->positions)->toBeNull();
    });

    test('filters available positions by selection', function (string $status, array $selected, array $tags, array $expected, array $unexpected) {
        $availablePosition = Position::factory()->active()->create(['name' => 'Available Position', 'available' => 1]);
        $secondaryAvailable = Position::factory()->active()->create(['name' => 'Secondary Position', 'available' => 2, 'tags' => ['alpha']]);
        Position::factory()->active()->unavailable()->create(['name' => 'Unavailable Position']);

        $selectedPositionIds = array_map(
            fn (string $name) => match ($name) {
                'Available Position' => $availablePosition->id,
                'Secondary Position' => $secondaryAvailable->id,
                default => null,
            },
            $selected
        );

        $component = livewire(CharactersManifest::class, [
            'layout' => 'grid',
            'showAvailablePositions' => true,
            'availablePositionsStatus' => $status,
            'selectedAvailablePositions' => array_filter($selectedPositionIds),
            'taggedAvailablePositions' => $tags,
        ]);

        $names = $component->instance()->positions->pluck('name')->toArray();

        expect($names)->toHaveCount(count($expected));

        foreach ($expected as $name) {
            expect($names)->toContain($name);
        }

        foreach ($unexpected as $name) {
            expect($names)->not->toContain($name);
        }
    })->with([
        'choose' => ['choose', ['Available Position'], [], ['Available Position'], ['Secondary Position', 'Unavailable Position']],
        'tags' => ['tags', [], ['alpha'], ['Secondary Position'], ['Available Position', 'Unavailable Position']],
    ]);

    test('shouldShowAvailablePosition respects availability and selection', function () {
        $availablePosition = Position::factory()->active()->create(['available' => 1]);
        $inactivePosition = Position::factory()->inactive()->create(['available' => 1]);
        $unavailablePosition = Position::factory()->active()->unavailable()->create();

        $component = livewire(CharactersManifest::class, [
            'layout' => 'grid',
            'showAvailablePositions' => true,
            'availablePositionsStatus' => 'all',
        ]);

        expect($component->instance()->shouldShowAvailablePosition($availablePosition))->toBeTrue()
            ->and($component->instance()->shouldShowAvailablePosition($inactivePosition))->toBeFalse()
            ->and($component->instance()->shouldShowAvailablePosition($unavailablePosition))->toBeFalse();
    });

    test('shouldShowAvailablePosition respects choose status', function () {
        $availablePosition = Position::factory()->active()->create(['available' => 1]);
        $otherPosition = Position::factory()->active()->create(['available' => 1]);

        $component = livewire(CharactersManifest::class, [
            'layout' => 'grid',
            'showAvailablePositions' => true,
            'availablePositionsStatus' => 'choose',
            'selectedAvailablePositions' => [$availablePosition->id],
        ]);

        expect($component->instance()->shouldShowAvailablePosition($availablePosition))->toBeTrue()
            ->and($component->instance()->shouldShowAvailablePosition($otherPosition))->toBeFalse();
    });

    test('shouldShowAvailablePosition returns false when using tag status', function () {
        $availablePosition = Position::factory()->active()->create(['available' => 1, 'tags' => ['alpha']]);

        $component = livewire(CharactersManifest::class, [
            'showAvailablePositions' => true,
            'availablePositionsStatus' => 'tags',
            'taggedAvailablePositions' => ['alpha'],
        ]);

        expect($component->instance()->shouldShowAvailablePosition($availablePosition))->toBeFalse();
    });

    test('shouldShowAvailablePosition returns false when available positions are hidden', function () {
        $availablePosition = Position::factory()->active()->create(['available' => 1]);

        $component = livewire(CharactersManifest::class, [
            'showAvailablePositions' => false,
            'availablePositionsStatus' => 'all',
        ]);

        expect($component->instance()->shouldShowAvailablePosition($availablePosition))->toBeFalse();
    });
});

describe('schema structure', function () {
    test('block schema is empty (uses base schema only)', function () {
        $block = ManifestBlock::make('content');
        $blockSchema = $block->blockSchema();

        expect($blockSchema)->toBeArray()
            ->and($blockSchema)->toHaveCount(4);
    });

    test('container schema is empty (uses base schema only)', function () {
        $block = ManifestBlock::make('content');
        $containerSchema = $block->containerSchema();

        expect($containerSchema)->toBeArray()
            ->and($containerSchema)->toHaveCount(2);
    });

    test('content schema is empty (uses base schema only)', function () {
        $block = ManifestBlock::make('content');
        $contentSchema = $block->contentSchema();

        expect($contentSchema)->toBeArray()
            ->and($contentSchema)->toHaveCount(3);
    });
});

test('is registered in FormFieldRegistry', function () {
    $block = collect(PageBlockRegistry::blocks())->first(
        fn ($block) => $block instanceof ManifestBlock
    );

    expect($block)->not->toBeNull()
        ->and($block)->toBeInstanceOf(ManifestBlock::class);
});
