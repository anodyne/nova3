<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Date;
use Nova\Forms\Actions\SyncDatabaseFormFields;
use Nova\Forms\Fields\DropdownField;
use Nova\Forms\Fields\FormFieldRegistry;
use Nova\Forms\Models\Form;

uses()->group('forms');

describe('rendered output', function () {
    test('displays the label', function () {
        $form = Form::factory()->create([
            'key' => 'test-form',
            'published_fields' => [
                [
                    'type' => 'dropdown',
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
                            'options' => [],
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
                    'type' => 'dropdown',
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
                            'options' => [],
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
                    'type' => 'dropdown',
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
                            'options' => [],
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
                    'type' => 'dropdown',
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
                            'options' => [],
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
                    'type' => 'dropdown',
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
                            'options' => [],
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
            ->toContain('placeholder="Placeholder"')
            ->toContain('<option value="">Placeholder</option>');
    });

    test('does not display the field placeholder if empty', function () {
        $form = Form::factory()->create([
            'key' => 'test-form',
            'published_fields' => [
                [
                    'type' => 'dropdown',
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
                            'options' => [],
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
            ->not->toContain('placeholder="Placeholder"')
            ->not->toContain('<option value="">Placeholder</option>');
    });

    test('displays the field ID', function () {
        $form = Form::factory()->create([
            'key' => 'test-form',
            'published_fields' => [
                [
                    'type' => 'dropdown',
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
                            'options' => [],
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

    test('can add options', function () {
        $form = Form::factory()->create([
            'key' => 'test-form',
            'published_fields' => [
                [
                    'type' => 'dropdown',
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
                            'options' => [
                                'One' => 'One',
                                'Two' => 'Two',
                            ],
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
            ->toContain('<select')
            ->toContain('<option value="One">')
            ->toContain('<option value="Two">');
    });
});

describe('schema structure', function () {
    test('includes placeholder and options fields in attributes schema', function () {
        $field = DropdownField::make('dropdown');
        $attributesSchema = $field->attributesSchema();

        expect($attributesSchema)->toBeArray()
            ->and($attributesSchema)->toHaveCount(2);
    });

    test('placeholder field is a TextInput component', function () {
        $field = DropdownField::make('dropdown');
        $attributesSchema = $field->attributesSchema();

        expect($attributesSchema[0])->toBeInstanceOf(\Filament\Forms\Components\TextInput::class)
            ->and($attributesSchema[0]->getName())->toBe('attrs.placeholder')
            ->and($attributesSchema[0]->getLabel())->toBe('Placeholder');
    });

    test('options field is a KeyValue component', function () {
        $field = DropdownField::make('dropdown');
        $attributesSchema = $field->attributesSchema();

        expect($attributesSchema[1])->toBeInstanceOf(\Filament\Forms\Components\KeyValue::class)
            ->and($attributesSchema[1]->getName())->toBe('attrs.options')
            ->and($attributesSchema[1]->getLabel())->toBe('Options');
    });

    test('details schema is empty (uses base schema only)', function () {
        $field = DropdownField::make('dropdown');
        $detailsSchema = $field->detailsSchema();

        expect($detailsSchema)->toBeArray()
            ->and($detailsSchema)->toBeEmpty();
    });
});

test('is registered in FormFieldRegistry', function () {
    $fields = FormFieldRegistry::fields();

    $dropdownField = collect($fields)->first(
        fn ($field) => $field instanceof DropdownField
    );

    expect($dropdownField)->not->toBeNull()
        ->and($dropdownField)->toBeInstanceOf(DropdownField::class);
});
