<?php

declare(strict_types=1);

namespace Nova\Setup\Livewire\Concerns;

use Illuminate\Support\Str;

trait HandlesFormFields
{
    protected function buildDropdownFieldJson(object $model, string $uid, array $options): array
    {
        return [
            'type' => 'scribbleBlock',
            'attrs' => [
                'id' => Str::uuid()->toString(),
                'type' => 'block',
                'identifier' => 'field-dropdown',
                'values' => [
                    'label' => str_replace(['&amp;'], ['&'], $model->field_label_page),
                    'description' => $model->field_help,
                    'name' => $model->field_name,
                    'uid' => $uid,
                    'attributes' => [
                        'placeholder' => null,
                        'id' => $model->field_fid,
                    ],
                    'options' => $options,
                    'required' => false,
                    'hideWhenEmpty' => true,
                ],
            ],
        ];
    }

    protected function createDropdownFieldJson(string $label, string $name, array $options): array
    {
        return [
            'type' => 'scribbleBlock',
            'attrs' => [
                'id' => Str::uuid()->toString(),
                'type' => 'block',
                'identifier' => 'field-dropdown',
                'values' => [
                    'label' => $label,
                    'description' => null,
                    'name' => $name,
                    'uid' => Str::random(12),
                    'attributes' => [
                        'placeholder' => null,
                    ],
                    'options' => $options,
                    'required' => false,
                    'hideWhenEmpty' => true,
                ],
            ],
        ];
    }

    protected function buildLongTextFieldJson(object $model, string $uid): array
    {
        return [
            'type' => 'scribbleBlock',
            'attrs' => [
                'id' => Str::uuid()->toString(),
                'type' => 'block',
                'identifier' => 'field-long-text',
                'values' => [
                    'label' => str_replace(['&amp;'], ['&'], $model->field_label_page),
                    'description' => $model->field_help,
                    'name' => $model->field_name,
                    'uid' => $uid,
                    'rows' => $model->field_rows,
                    'attributes' => [
                        'placeholder' => null,
                        'id' => $model->field_fid,
                    ],
                    'required' => false,
                    'hideWhenEmpty' => true,
                ],
            ],
        ];
    }

    protected function createLongTextFieldJson(string $label, string $name): array
    {
        return [
            'type' => 'scribbleBlock',
            'attrs' => [
                'id' => Str::uuid()->toString(),
                'type' => 'block',
                'identifier' => 'field-long-text',
                'values' => [
                    'label' => $label,
                    'description' => null,
                    'name' => $name,
                    'uid' => Str::random(12),
                    'rows' => 3,
                    'attributes' => [
                        'placeholder' => null,
                    ],
                    'required' => false,
                    'hideWhenEmpty' => true,
                ],
            ],
        ];
    }

    protected function buildShortTextFieldJson(object $model, string $uid): array
    {
        return [
            'type' => 'scribbleBlock',
            'attrs' => [
                'id' => Str::uuid()->toString(),
                'type' => 'block',
                'identifier' => 'field-short-text',
                'values' => [
                    'label' => str_replace(['&amp;'], ['&'], $model->field_label_page),
                    'description' => $model->field_help,
                    'name' => $model->field_name,
                    'uid' => $uid,
                    'attributes' => [
                        'placeholder' => null,
                        'id' => $model->field_fid,
                    ],
                    'required' => false,
                    'hideWhenEmpty' => true,
                ],
            ],
        ];
    }

    protected function createShortTextFieldJson(string $label, string $name): array
    {
        return [
            'type' => 'scribbleBlock',
            'attrs' => [
                'id' => Str::uuid()->toString(),
                'type' => 'block',
                'identifier' => 'field-short-text',
                'values' => [
                    'label' => $label,
                    'description' => null,
                    'name' => $name,
                    'uid' => Str::random(12),
                    'attributes' => [
                        'placeholder' => null,
                    ],
                    'required' => false,
                    'hideWhenEmpty' => true,
                ],
            ],
        ];
    }
}
