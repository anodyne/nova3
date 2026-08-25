<?php

declare(strict_types=1);

namespace Nova\Setup\Livewire\Concerns;

use Illuminate\Support\Str;

/**
 * @phpstan-type FormFieldJson array{
 *     type: 'dropdown'|'date'|'long-text'|'short-text',
 *     data: array{
 *         details: array<string, mixed>,
 *         attrs: array<string, mixed>
 *     }
 * }
 * @phpstan-type LegacyFormField object{
 *     field_label_page: string,
 *     field_help: string|null,
 *     field_name: string,
 *     field_rows: int|string|null
 * }
 */
trait HandlesFormFields
{
    /**
     * @param  LegacyFormField  $model
     * @param  array<array-key, mixed>  $options
     * @return FormFieldJson
     */
    protected function buildDropdownFieldJson(object $model, string $uid, array $options): array
    {
        return [
            'type' => 'dropdown',
            'data' => [
                'details' => [
                    'label' => str_replace(['&amp;'], ['&'], $model->field_label_page),
                    'description' => $model->field_help,
                    'required' => false,
                    'hideWhenEmpty' => true,
                ],
                'attrs' => [
                    'name' => $model->field_name,
                    'id' => $uid,
                    'placeholder' => null,
                    'options' => $options,
                ],
            ],
        ];
    }

    /**
     * @param  array<array-key, mixed>  $options
     * @return FormFieldJson
     */
    protected function createDropdownFieldJson(string $label, string $name, array $options): array
    {
        return [
            'type' => 'dropdown',
            'data' => [
                'details' => [
                    'label' => $label,
                    'description' => null,
                    'required' => false,
                    'hideWhenEmpty' => true,
                ],
                'attrs' => [
                    'name' => $name,
                    'id' => Str::random(12),
                    'placeholder' => null,
                    'options' => $options,
                ],
            ],
        ];
    }

    /** @return FormFieldJson */
    protected function createDateFieldJson(string $label, string $name): array
    {
        return [
            'type' => 'date',
            'data' => [
                'details' => [
                    'label' => $label,
                    'description' => null,
                    'required' => false,
                    'hideWhenEmpty' => true,
                ],
                'attrs' => [
                    'name' => $name,
                    'id' => Str::random(12),
                    'placeholder' => null,
                ],
            ],
        ];
    }

    /**
     * @param  LegacyFormField  $model
     * @return FormFieldJson
     */
    protected function buildLongTextFieldJson(object $model, string $uid): array
    {
        return [
            'type' => 'long-text',
            'data' => [
                'details' => [
                    'label' => str_replace(['&amp;'], ['&'], $model->field_label_page),
                    'description' => $model->field_help,
                    'required' => false,
                    'hideWhenEmpty' => true,
                ],
                'attrs' => [
                    'name' => $model->field_name,
                    'id' => $uid,
                    'placeholder' => null,
                    'rows' => $model->field_rows,
                ],
            ],
        ];
    }

    /** @return FormFieldJson */
    protected function createLongTextFieldJson(string $label, string $name): array
    {
        return [
            'type' => 'long-text',
            'data' => [
                'details' => [
                    'label' => $label,
                    'description' => null,
                    'required' => false,
                    'hideWhenEmpty' => true,
                ],
                'attrs' => [
                    'name' => $name,
                    'id' => Str::random(12),
                    'placeholder' => null,
                    'rows' => 3,
                ],
            ],
        ];
    }

    /**
     * @param  LegacyFormField  $model
     * @return FormFieldJson
     */
    protected function buildShortTextFieldJson(object $model, string $uid): array
    {
        return [
            'type' => 'short-text',
            'data' => [
                'details' => [
                    'label' => str_replace(['&amp;'], ['&'], $model->field_label_page),
                    'description' => $model->field_help,
                    'required' => false,
                    'hideWhenEmpty' => true,
                ],
                'attrs' => [
                    'name' => $model->field_name,
                    'id' => $uid,
                    'placeholder' => null,
                ],
            ],
        ];
    }

    /** @return FormFieldJson */
    protected function createShortTextFieldJson(string $label, string $name): array
    {
        return [
            'type' => 'short-text',
            'data' => [
                'details' => [
                    'label' => $label,
                    'description' => null,
                    'required' => false,
                    'hideWhenEmpty' => true,
                ],
                'attrs' => [
                    'name' => $name,
                    'id' => Str::random(12),
                    'placeholder' => null,
                ],
            ],
        ];
    }
}
