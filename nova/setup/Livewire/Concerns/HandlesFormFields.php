<?php

declare(strict_types=1);

namespace Nova\Setup\Livewire\Concerns;

use Illuminate\Support\Str;

trait HandlesFormFields
{
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
