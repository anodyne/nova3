<?php

declare(strict_types=1);

use Nova\Characters\Models\Character;
use Nova\Departments\Models\Department;
use Nova\Departments\Models\Position;
use Nova\Pages\Blocks\Manifest\ManifestBlock;
use Nova\Pages\Blocks\PageBlockRegistry;
use Nova\Pages\Models\Page;

uses()->group('pages', 'page-blocks');

beforeEach(function () {
    $department = Department::factory()->active()->create();
    $position = Position::factory()->active()->create(['department_id' => $department->id]);

    $character = Character::factory()->active()->create();
    $character->positions()->attach($position);
});

describe('rendered output', function () {
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
    //
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
