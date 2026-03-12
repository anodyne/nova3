<?php

declare(strict_types=1);

use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Date;
use Nova\Forms\Actions\SyncDatabaseFormFields;
use Nova\Forms\Fields\FormFieldRegistry;
use Nova\Forms\Fields\LongTextField;
use Nova\Forms\Models\Form;

uses()->group('forms');

describe('rendered output', function () {
    test('displays the label', function () {
        $form = Form::factory()->create([
            'key' => 'test-form',
            'published_fields' => [
                [
                    'type' => 'long-text',
                    'data' => [
                        'details' => [
                            'label' => 'Field label',
                            'description' => 'Cupidatat nulla ipsum est aliqua.',
                            'required' => false,
                            'hideWhenEmpty' => false,
                        ],
                        'attrs' => [
                            'name' => 'label',
                            'id' => 'pVrlCJv8bDDw',
                            'placeholder' => 'Placeholder',
                            'rows' => 5,
                            'other' => [],
                        ],
                    ],
                ],
            ],
            'published_at' => Date::now(),
        ]);
        SyncDatabaseFormFields::run($form);

        $view = view('test-form-render', ['form' => $form]);
        $html = $view->render();

        expect($html)
            ->toContain('data-slot="label"')
            ->toContain('Field label');
    });

    test('does not display the label if empty', function () {
        $form = Form::factory()->create([
            'key' => 'test-form',
            'published_fields' => [
                [
                    'type' => 'long-text',
                    'data' => [
                        'details' => [
                            'label' => '',
                            'description' => 'Cupidatat nulla ipsum est aliqua.',
                            'required' => false,
                            'hideWhenEmpty' => false,
                        ],
                        'attrs' => [
                            'name' => 'label',
                            'id' => 'pVrlCJv8bDDw',
                            'placeholder' => 'Placeholder',
                            'rows' => 5,
                            'other' => [],
                        ],
                    ],
                ],
            ],
            'published_at' => Date::now(),
        ]);
        SyncDatabaseFormFields::run($form);

        $view = view('test-form-render', ['form' => $form]);
        $html = $view->render();

        expect($html)
            ->not->toContain('data-slot="label"');
    });

    test('displays the description', function () {
        $form = Form::factory()->create([
            'key' => 'test-form',
            'published_fields' => [
                [
                    'type' => 'long-text',
                    'data' => [
                        'details' => [
                            'label' => 'Field label',
                            'description' => 'Cupidatat nulla ipsum est aliqua.',
                            'required' => false,
                            'hideWhenEmpty' => false,
                        ],
                        'attrs' => [
                            'name' => 'label',
                            'id' => 'pVrlCJv8bDDw',
                            'placeholder' => 'Placeholder',
                            'rows' => 5,
                            'other' => [],
                        ],
                    ],
                ],
            ],
            'published_at' => Date::now(),
        ]);
        SyncDatabaseFormFields::run($form);

        $view = view('test-form-render', ['form' => $form]);
        $html = $view->render();

        expect($html)
            ->toContain('data-slot="description"')
            ->toContain('Cupidatat nulla ipsum est aliqua.');
    });

    test('does not display the description if empty', function () {
        $form = Form::factory()->create([
            'key' => 'test-form',
            'published_fields' => [
                [
                    'type' => 'long-text',
                    'data' => [
                        'details' => [
                            'label' => 'Field label',
                            'description' => '',
                            'required' => false,
                            'hideWhenEmpty' => false,
                        ],
                        'attrs' => [
                            'name' => 'label',
                            'id' => 'pVrlCJv8bDDw',
                            'placeholder' => 'Placeholder',
                            'rows' => 5,
                            'other' => [],
                        ],
                    ],
                ],
            ],
            'published_at' => Date::now(),
        ]);
        SyncDatabaseFormFields::run($form);

        $view = view('test-form-render', ['form' => $form]);
        $html = $view->render();

        expect($html)
            ->not->toContain('data-slot="description"');
    });

    test('displays the field placeholder', function () {
        $form = Form::factory()->create([
            'key' => 'test-form',
            'published_fields' => [
                [
                    'type' => 'long-text',
                    'data' => [
                        'details' => [
                            'label' => 'Field label',
                            'description' => 'Cupidatat nulla ipsum est aliqua.',
                            'required' => false,
                            'hideWhenEmpty' => false,
                        ],
                        'attrs' => [
                            'name' => 'label',
                            'id' => 'pVrlCJv8bDDw',
                            'placeholder' => 'Placeholder',
                            'rows' => 5,
                            'other' => [],
                        ],
                    ],
                ],
            ],
            'published_at' => Date::now(),
        ]);
        SyncDatabaseFormFields::run($form);

        $view = view('test-form-render', ['form' => $form]);
        $html = $view->render();

        expect($html)
            ->toContain('placeholder="Placeholder"');
    });

    test('does not display the field placeholder if empty', function () {
        $form = Form::factory()->create([
            'key' => 'test-form',
            'published_fields' => [
                [
                    'type' => 'long-text',
                    'data' => [
                        'details' => [
                            'label' => 'Field label',
                            'description' => '',
                            'required' => false,
                            'hideWhenEmpty' => false,
                        ],
                        'attrs' => [
                            'name' => 'label',
                            'id' => 'pVrlCJv8bDDw',
                            'placeholder' => '',
                            'rows' => 5,
                            'other' => [],
                        ],
                    ],
                ],
            ],
            'published_at' => Date::now(),
        ]);
        SyncDatabaseFormFields::run($form);

        $view = view('test-form-render', ['form' => $form]);
        $html = $view->render();

        expect($html)
            ->not->toContain('placeholder="Placeholder"');
    });

    test('displays the field ID', function () {
        $form = Form::factory()->create([
            'key' => 'test-form',
            'published_fields' => [
                [
                    'type' => 'long-text',
                    'data' => [
                        'details' => [
                            'label' => 'Field label',
                            'description' => 'Cupidatat nulla ipsum est aliqua.',
                            'required' => false,
                            'hideWhenEmpty' => false,
                        ],
                        'attrs' => [
                            'name' => 'label',
                            'id' => 'pVrlCJv8bDDw',
                            'placeholder' => 'Placeholder',
                            'rows' => 5,
                            'other' => [],
                        ],
                    ],
                ],
            ],
            'published_at' => Date::now(),
        ]);
        SyncDatabaseFormFields::run($form);

        $view = view('test-form-render', ['form' => $form]);
        $html = $view->render();

        expect($html)
            ->toContain('id="pVrlCJv8bDDw"');
    });

    test('updates the rows', function () {
        $form = Form::factory()->create([
            'key' => 'test-form',
            'published_fields' => [
                [
                    'type' => 'long-text',
                    'data' => [
                        'details' => [
                            'label' => 'Field label',
                            'description' => 'Cupidatat nulla ipsum est aliqua.',
                            'required' => false,
                            'hideWhenEmpty' => false,
                        ],
                        'attrs' => [
                            'name' => 'label',
                            'id' => 'pVrlCJv8bDDw',
                            'placeholder' => 'Placeholder',
                            'rows' => 7,
                            'other' => [],
                        ],
                    ],
                ],
            ],
            'published_at' => Date::now(),
        ]);
        SyncDatabaseFormFields::run($form);

        $view = view('test-form-render', ['form' => $form]);
        $html = $view->render();

        expect($html)
            ->toContain('rows="7"');
    });
});

describe('schema structure', function () {
    test('includes placeholder field in attributes schema', function () {
        $field = LongTextField::make('long-text');
        $attributesSchema = $field->attributesSchema();

        expect($attributesSchema)->toBeArray()
            ->and($attributesSchema)->toHaveCount(2);
    });

    test('placeholder field is a TextInput component', function () {
        $field = LongTextField::make('long-text');
        $attributesSchema = $field->attributesSchema();

        expect($attributesSchema[0])->toBeInstanceOf(TextInput::class)
            ->and($attributesSchema[0]->getName())->toBe('attrs.placeholder')
            ->and($attributesSchema[0]->getLabel())->toBe('Placeholder');
    });

    test('rows field is a TextInput component', function () {
        $field = LongTextField::make('long-text');
        $attributesSchema = $field->attributesSchema();

        expect($attributesSchema[1])->toBeInstanceOf(TextInput::class)
            ->and($attributesSchema[1]->getName())->toBe('attrs.rows')
            ->and($attributesSchema[1]->getLabel())->toBe('Rows');
    });

    test('details schema is empty (uses base schema only)', function () {
        $field = LongTextField::make('long-text');
        $detailsSchema = $field->detailsSchema();

        expect($detailsSchema)->toBeArray()
            ->and($detailsSchema)->toBeEmpty();
    });
});

test('is registered in FormFieldRegistry', function () {
    $fields = FormFieldRegistry::fields();

    $longTextField = collect($fields)->first(
        fn ($field) => $field instanceof LongTextField
    );

    expect($longTextField)->not->toBeNull()
        ->and($longTextField)->toBeInstanceOf(LongTextField::class);
});
