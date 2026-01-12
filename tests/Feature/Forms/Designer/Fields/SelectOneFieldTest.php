<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Date;
use Nova\Forms\Actions\SyncDatabaseFormFields;
use Nova\Forms\Fields\FormFieldRegistry;
use Nova\Forms\Fields\SelectOneField;
use Nova\Forms\Models\Form;

uses()->group('forms');

describe('rendered output', function () {
    test('displays the label', function () {
        $form = Form::factory()->create([
            'key' => 'test-form',
            'published_fields' => [
                [
                    'type' => 'select-one',
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
                    'type' => 'select-one',
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
                    'type' => 'select-one',
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
                    'type' => 'select-one',
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

    test('can add options', function () {
        $form = Form::factory()->create([
            'key' => 'test-form',
            'published_fields' => [
                [
                    'type' => 'select-one',
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
                            'options' => [
                                [
                                    'label' => 'One',
                                    'description' => 'Description of the first',
                                    'value' => 'one',
                                    'attributes' => [],
                                ],
                                [
                                    'label' => 'Two',
                                    'description' => 'Description of the second',
                                    'value' => 'two',
                                    'attributes' => [],
                                ],
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
            ->toContain('value="one"')
            ->toContain('value="two"');
    });
});

describe('schema structure', function () {
    test('includes options repeater in attributes schema', function () {
        $field = SelectOneField::make('select-one');
        $attributesSchema = $field->attributesSchema();

        expect($attributesSchema)->toBeArray()
            ->and($attributesSchema)->toHaveCount(1);
    });

    test('options field is a Repeater component', function () {
        $field = SelectOneField::make('select-one');
        $attributesSchema = $field->attributesSchema();

        expect($attributesSchema[0])->toBeInstanceOf(\Filament\Forms\Components\Repeater::class)
            ->and($attributesSchema[0]->getName())->toBe('attrs.options')
            ->and($attributesSchema[0]->getLabel())->toBe('Options');
    });

    test('details schema is empty (uses base schema only)', function () {
        $field = SelectOneField::make('select-one');
        $detailsSchema = $field->detailsSchema();

        expect($detailsSchema)->toBeArray()
            ->and($detailsSchema)->toBeEmpty();
    });
});

test('is registered in FormFieldRegistry', function () {
    $fields = FormFieldRegistry::fields();

    $selectOneField = collect($fields)->first(
        fn ($field) => $field instanceof SelectOneField
    );

    expect($selectOneField)->not->toBeNull()
        ->and($selectOneField)->toBeInstanceOf(SelectOneField::class);
});
