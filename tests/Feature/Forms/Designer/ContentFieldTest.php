<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Date;
use Nova\Forms\Actions\SyncDatabaseFormFields;
use Nova\Forms\Fields\ContentField;
use Nova\Forms\Fields\FormFieldRegistry;
use Nova\Forms\Models\Form;

uses()->group('forms');

describe('rendered output', function () {
    test('displays the content', function () {
        $form = Form::factory()->create([
            'key' => 'test-form',
            'published_fields' => [
                [
                    'type' => 'content',
                    'data' => [
                        'details' => [
                            'content' => "<p>Sunt adipisicing deserunt irure. Minim est exercitation magna exercitation eu nisi eiusmod aliquip ullamco ex aliquip pariatur do qui consectetur. Veniam ex velit deserunt aliqua ut ut laboris Lorem ipsum sit officia dolor veniam duis. Est eiusmod in officia do incididunt officia officia fugiat exercitation qui.<\/p>",
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
            ->toContain('Sunt adipisicing deserunt irure');
    });
});

describe('schema structure', function () {
    test('content field is a RichEditor component', function () {
        $field = ContentField::make('content');
        $detailsSchema = $field->detailsSchema();

        expect($detailsSchema[0])->toBeInstanceOf(\Filament\Forms\Components\RichEditor::class)
            ->and($detailsSchema[0]->getName())->toBe('details.content')
            ->and($detailsSchema[0]->getLabel())->toBe('Content');
    });

    test('attributes schema is empty (uses base schema only)', function () {
        $field = ContentField::make('content');
        $attributesSchema = $field->attributesSchema();

        expect($attributesSchema)->toBeArray()
            ->and($attributesSchema)->toBeEmpty();
    });
});

test('is registered in FormFieldRegistry', function () {
    $fields = FormFieldRegistry::fields();

    $contentField = collect($fields)->first(
        fn ($field) => $field instanceof ContentField
    );

    expect($contentField)->not->toBeNull()
        ->and($contentField)->toBeInstanceOf(ContentField::class);
});
