<?php

declare(strict_types=1);

use Filament\Forms\Components\Builder;
use Illuminate\Support\Facades\Date;
use Nova\Forms\Livewire\FormDesigner;
use Nova\Forms\Models\Form;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

uses()->group('forms');

beforeEach(function () {
    $this->form = Form::factory()->basic()->create();
});

describe('authorized user', function () {
    beforeEach(fn () => signIn(permissions: 'form.update'));

    test('can view the design form page', function () {
        get(route('admin.forms.design', $this->form))
            ->assertSuccessful();
    });

    test('can save form design', function () {
        $undoBuilderFake = Builder::fake();

        $fieldData = [
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

        livewire(FormDesigner::class, ['novaForm' => $this->form])
            ->set('data.fields', $fieldData)
            ->assertSet('data.fields', $fieldData)
            ->call('save')
            ->assertNotified();

        assertDatabaseHas(Form::class, [
            'id' => $this->form->id,
            'fields' => json_encode($fieldData),
            'published_fields' => null,
            'published_at' => null,
        ]);

        $undoBuilderFake();
    });

    test('can publish form design', function () {
        $undoBuilderFake = Builder::fake();

        $fieldData = [
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

        livewire(FormDesigner::class, ['novaForm' => $this->form])
            ->set('data.fields', $fieldData)
            ->assertSet('data.fields', $fieldData)
            ->call('save')
            ->call('publish')
            ->assertNotified();

        assertDatabaseHas(Form::class, [
            'id' => $this->form->id,
            'fields' => json_encode($fieldData),
            'published_fields' => json_encode($fieldData),
            'published_at' => Date::now(),
        ]);

        $undoBuilderFake();
    });
});

describe('unauthorized user', function () {
    beforeEach(fn () => signIn());

    test('cannot view the design form page', function () {
        get(route('admin.forms.design', $this->form))
            ->assertNotFound();
    });

    test('cannot save form design', function () {
        livewire(FormDesigner::class, ['novaForm' => $this->form])
            ->call('save')
            ->assertStatus(404)
            ->assertNotNotified();
    });

    test('can publish form design', function () {
        livewire(FormDesigner::class, ['novaForm' => $this->form])
            ->call('publish')
            ->assertStatus(404)
            ->assertNotNotified();
    });

    test('can preview form', function () {
        get(route('admin.forms.preview', $this->form))
            ->assertSuccessful();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the design form page', function () {
        get(route('admin.forms.design', $this->form))
            ->assertRedirectToRoute('login');
    });

    test('cannot preview form', function () {
        get(route('admin.forms.preview', $this->form))
            ->assertRedirectToRoute('login');
    });
});
