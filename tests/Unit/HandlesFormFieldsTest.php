<?php

declare(strict_types=1);

use Nova\Setup\Livewire\Concerns\HandlesFormFields;

function formFieldsTestHarness(): object
{
    return new class
    {
        use HandlesFormFields;

        /** @param array<array-key, mixed> $options */
        public function buildDropdown(object $model, string $uid, array $options): array
        {
            return $this->buildDropdownFieldJson($model, $uid, $options);
        }

        public function buildLongText(object $model, string $uid): array
        {
            return $this->buildLongTextFieldJson($model, $uid);
        }

        public function buildShortText(object $model, string $uid): array
        {
            return $this->buildShortTextFieldJson($model, $uid);
        }
    };
}

function legacyFormField(): object
{
    return (object) [
        'field_label_page' => 'Biography &amp; history',
        'field_help' => 'Share the important details.',
        'field_name' => 'biography',
        'field_rows' => 6,
    ];
}

it('builds a dropdown field from legacy form data', function () {
    $field = formFieldsTestHarness()->buildDropdown(
        legacyFormField(),
        'field-uid',
        ['Command' => 'Command', 'Science' => 'Science'],
    );

    expect($field)->toMatchArray([
        'type' => 'dropdown',
        'data' => [
            'details' => [
                'label' => 'Biography & history',
                'description' => 'Share the important details.',
                'required' => false,
                'hideWhenEmpty' => true,
            ],
            'attrs' => [
                'name' => 'biography',
                'id' => 'field-uid',
                'placeholder' => null,
                'options' => ['Command' => 'Command', 'Science' => 'Science'],
            ],
        ],
    ]);
});

it('builds a long text field from legacy form data', function () {
    $field = formFieldsTestHarness()->buildLongText(legacyFormField(), 'field-uid');

    expect($field)->toMatchArray([
        'type' => 'long-text',
        'data' => [
            'details' => [
                'label' => 'Biography & history',
                'description' => 'Share the important details.',
                'required' => false,
                'hideWhenEmpty' => true,
            ],
            'attrs' => [
                'name' => 'biography',
                'id' => 'field-uid',
                'placeholder' => null,
                'rows' => 6,
            ],
        ],
    ]);
});

it('builds a short text field from legacy form data', function () {
    $field = formFieldsTestHarness()->buildShortText(legacyFormField(), 'field-uid');

    expect($field)->toMatchArray([
        'type' => 'short-text',
        'data' => [
            'details' => [
                'label' => 'Biography & history',
                'description' => 'Share the important details.',
                'required' => false,
                'hideWhenEmpty' => true,
            ],
            'attrs' => [
                'name' => 'biography',
                'id' => 'field-uid',
                'placeholder' => null,
            ],
        ],
    ]);
});
