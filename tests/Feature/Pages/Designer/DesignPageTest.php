<?php

declare(strict_types=1);

use Filament\Forms\Components\Builder;
use Illuminate\Support\Facades\Date;
use Nova\Pages\Livewire\PageDesigner;
use Nova\Pages\Models\Page;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

uses()->group('pages');

beforeEach(function () {
    $this->page = Page::factory()->basic()->create();
});

describe('authorized user', function () {
    beforeEach(fn () => signIn(permissions: 'page.update'));

    test('can view the design page page', function () {
        get(route('admin.pages.design', $this->page))
            ->assertSuccessful();
    });

    test('can save page design', function () {
        $undoBuilderFake = Builder::fake();

        $pageData = [
            [
                'type' => 'short-text',
                'data' => [
                    'details' => [
                        'label' => 'Label',
                        'description' => 'Cupidatat nulla ipsum est aliqua.',
                        'required' => false,
                        'hideWhenEmpty' => false,
                    ],
                    'attrs' => [
                        'name' => 'label',
                        'id' => 'pVrlCJv8bDDw',
                        'placeholder' => 'Placeholder',
                        'other' => [],
                    ],
                ],
            ],
        ];

        livewire(PageDesigner::class, ['page' => $this->page])
            ->set('data.blocks', $pageData)
            ->assertSet('data.blocks', $pageData)
            ->call('save')
            ->assertNotified();

        assertDatabaseHas(Page::class, [
            'id' => $this->page->id,
            'blocks' => json_encode($pageData),
            'published_blocks' => null,
            'published_at' => null,
        ]);

        $undoBuilderFake();
    });

    test('can publish page design', function () {
        $undoBuilderFake = Builder::fake();

        $pageData = [
            [
                'type' => 'short-text',
                'data' => [
                    'details' => [
                        'label' => 'Label',
                        'description' => 'Cupidatat nulla ipsum est aliqua.',
                        'required' => false,
                        'hideWhenEmpty' => false,
                    ],
                    'attrs' => [
                        'name' => 'label',
                        'id' => 'pVrlCJv8bDDw',
                        'placeholder' => 'Placeholder',
                        'other' => [],
                    ],
                ],
            ],
        ];

        livewire(PageDesigner::class, ['page' => $this->page])
            ->set('data.blocks', $pageData)
            ->assertSet('data.blocks', $pageData)
            ->call('save')
            ->call('publish')
            ->assertNotified();

        assertDatabaseHas(Page::class, [
            'id' => $this->page->id,
            'blocks' => json_encode($pageData),
            'published_blocks' => json_encode($pageData),
            'published_at' => Date::now(),
        ]);

        $undoBuilderFake();
    });
});

describe('unauthorized user', function () {
    beforeEach(fn () => signIn());

    test('cannot view the design page page', function () {
        get(route('admin.pages.design', $this->page))
            ->assertNotFound();
    });

    test('cannot save page design', function () {
        livewire(PageDesigner::class, ['page' => $this->page])
            ->call('save')
            ->assertStatus(404)
            ->assertNotNotified();
    });

    test('cannot publish page design', function () {
        livewire(PageDesigner::class, ['page' => $this->page])
            ->call('publish')
            ->assertStatus(404)
            ->assertNotNotified();
    });

    test('can preview page', function () {
        get(route('preview-basic-page', $this->page->key))
            ->assertSuccessful();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the design page page', function () {
        get(route('admin.pages.design', $this->page))
            ->assertRedirectToRoute('login');
    });

    test('can preview page', function () {
        get(route('preview-basic-page', $this->page->key))
            ->assertSuccessful();
    });
});
