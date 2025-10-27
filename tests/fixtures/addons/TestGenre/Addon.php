<?php

declare(strict_types=1);

namespace Addons\TestGenre;

use Nova\Addons\Genre;

class Addon extends Genre
{
    public string $location = 'TestGenre';

    public static bool $updateCalled = false;

    public function update(): void
    {
        static::$updateCalled = true;
    }

    public function departmentAndPositionsData(): array
    {
        return [
            [
                'name' => 'Command',
                'description' => 'Duis consectetur magna nulla ea sunt laborum cupidatat ut.',
                'status' => 'active',
                'tags' => 'one, two, three',
                'positions' => [
                    [
                        'name' => 'Commanding Officer',
                        'description' => 'Ullamco aliquip incididunt enim pariatur in commodo amet exercitation nulla.',
                        'available' => 1,
                        'status' => 'active',
                    ],
                ],
            ],
            [
                'name' => 'Engineering',
                'description' => 'Duis consectetur magna nulla ea sunt laborum cupidatat ut.',
                'status' => 'active',
                'tags' => 'one, two, three',
                'positions' => [
                    [
                        'name' => 'Chief Engineer',
                        'description' => 'Ullamco aliquip incididunt enim pariatur in commodo amet exercitation nulla.',
                        'available' => 1,
                        'status' => 'active',
                    ],
                ],
            ],
        ];
    }

    public function rankGroupsAndItemsData(): array
    {
        return [
            [
                'name' => 'Command',
                'items' => [
                    [
                        'name' => 'Captain',
                        'base_image' => 'red.png',
                        'overlay_image' => 'o6.png',
                    ],
                    [
                        'name' => 'Commander',
                        'base_image' => 'red.png',
                        'overlay_image' => 'o5.png',
                    ],
                ],
            ],
            [
                'name' => 'Operations',
                'items' => [
                    [
                        'name' => 'Lieutenant Commander',
                        'base_image' => 'yellow.png',
                        'overlay_image' => 'o4.png',
                    ],
                ],
            ],
        ];
    }

    public function rankNamesData(): array
    {
        return [
            ['name' => 'Captain'],
            ['name' => 'Commander'],
            ['name' => 'Lieutenant Commander'],
            ['name' => 'Lieutenant'],
        ];
    }
}
