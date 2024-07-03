<?php

declare(strict_types=1);

namespace Nova\Setup\Actions\Database\Schema;

use Awcodes\Scribble\Utils\Converter;
use Illuminate\Support\Str;

class DynamicFormSchema
{
    use TipTapContent;

    public static function heading(int $level = 1, string $value = '')
    {
        $output = '<h'.$level.'>'.$value.'</h'.$level.'>';

        return Converter::from($output)->toJson();
    }

    public static function paragraph(string $value = '')
    {
        $output = '<p>'.$value.'</p>';

        return Converter::from($output)->toJson();
    }

    public static function shortText(
        string $label = '',
        string $description = '',
        string $name = '',
        bool $required = false,
        bool $hideWhenEmpty = true
    ) {
        return [
            'type' => 'scribbleBlock',
            'attrs' => [
                'id' => Str::uuid()->toString(),
                'type' => 'block',
                'identifier' => 'field-short-text',
                'values' => [
                    'label' => $label,
                    'description' => $description,
                    'name' => $name,
                    'uid' => Str::random(12),
                    'attributes' => [
                        'placeholder' => null,
                    ],
                    'required' => $required,
                    'hideWhenEmpty' => $hideWhenEmpty,
                ],
            ],
        ];
    }

    public static function longText(
        string $label = '',
        string $description = '',
        string $name = '',
        int $rows = 5,
        bool $required = false,
        bool $hideWhenEmpty = true
    ): array {
        return [
            'type' => 'scribbleBlock',
            'attrs' => [
                'id' => Str::uuid()->toString(),
                'type' => 'block',
                'identifier' => 'field-long-text',
                'values' => [
                    'label' => $label,
                    'description' => $description,
                    'name' => $name,
                    'uid' => Str::random(12),
                    'rows' => $rows,
                    'attributes' => [
                        'placeholder' => null,
                    ],
                    'required' => $required,
                    'hideWhenEmpty' => $hideWhenEmpty,
                ],
            ],
        ];
    }

    public static function number(
        string $label = '',
        string $description = '',
        string $name = '',
        bool $required = false,
        bool $hideWhenEmpty = true
    ) {
        return [
            'type' => 'scribbleBlock',
            'attrs' => [
                'id' => Str::uuid()->toString(),
                'type' => 'block',
                'identifier' => 'field-number',
                'values' => [
                    'label' => $label,
                    'description' => $description,
                    'name' => $name,
                    'uid' => Str::random(12),
                    'attributes' => [
                        'placeholder' => null,
                        'step' => 1,
                        'min' => 0,
                    ],
                    'required' => $required,
                    'hideWhenEmpty' => $hideWhenEmpty,
                ],
            ],
        ];
    }

    public static function email(
        string $label = '',
        string $description = '',
        string $name = '',
        bool $required = false,
        bool $hideWhenEmpty = true
    ) {
        return [
            'type' => 'scribbleBlock',
            'attrs' => [
                'id' => Str::uuid()->toString(),
                'type' => 'block',
                'identifier' => 'field-email',
                'values' => [
                    'label' => $label,
                    'description' => $description,
                    'name' => $name,
                    'uid' => Str::random(12),
                    'attributes' => [
                        'placeholder' => null,
                    ],
                    'required' => $required,
                    'hideWhenEmpty' => $hideWhenEmpty,
                ],
            ],
        ];
    }

    public static function dropdown(
        string $label = '',
        string $description = '',
        string $name = '',
        array $options = [],
        bool $required = false,
        bool $hideWhenEmpty = true
    ) {
        return [
            'type' => 'scribbleBlock',
            'attrs' => [
                'id' => Str::uuid()->toString(),
                'type' => 'block',
                'identifier' => 'field-dropdown',
                'values' => [
                    'label' => $label,
                    'description' => $description,
                    'name' => $name,
                    'uid' => Str::random(12),
                    'options' => $options,
                    'attributes' => [
                        'placeholder' => null,
                    ],
                    'required' => $required,
                    'hideWhenEmpty' => $hideWhenEmpty,
                ],
            ],
        ];
    }

    public static function selectOne(
        string $label = '',
        string $description = '',
        string $name = '',
        array $options = [],
        bool $required = false,
        bool $hideWhenEmpty = true
    ) {
        return [
            'type' => 'scribbleBlock',
            'attrs' => [
                'id' => Str::uuid()->toString(),
                'type' => 'block',
                'identifier' => 'field-dropdown',
                'values' => [
                    'label' => $label,
                    'description' => $description,
                    'name' => $name,
                    'uid' => Str::random(12),
                    'options' => $options,
                    'attributes' => [
                        'placeholder' => null,
                    ],
                    'required' => $required,
                    'hideWhenEmpty' => $hideWhenEmpty,
                ],
            ],
        ];
    }
}
