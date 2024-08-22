<?php

declare(strict_types=1);

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Nova\Media\Livewire\UploadImage;
use Nova\Settings\Enums\AvatarShape;
use Nova\Settings\Enums\AvatarStyle;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\from;
use function Pest\Laravel\get;
use function Pest\Laravel\put;
use function Pest\Laravel\withoutExceptionHandling;
use function Pest\Livewire\livewire;
use function PHPUnit\Framework\assertCount;

uses()->group('settings');

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'settings.update');
    });

    it('can view the appearance settings page', function () {
        get(route('admin.settings.appearance.edit'))
            ->assertSuccessful();
    });

    it('can update appearance settings', function () {
        withoutExceptionHandling();

        from(route('admin.settings.appearance.edit'))
            ->followingRedirects()
            ->put(route('admin.settings.appearance.update'), [
                'theme' => 'Pulsar',
                'admin_fonts' => [
                    'headerProvider' => 'local',
                    'headerFamily' => 'Inter',
                    'bodyProvider' => 'local',
                    'bodyFamily' => 'Inter',
                ],
                'colors_gray' => 'Zinc',
                'colors_primary' => 'Violet',
                'colors_success' => 'Lime',
                'colors_danger' => 'Red',
                'colors_warning' => 'Yellow',
                'colors_info' => 'Blue',
                'avatar_shape' => AvatarShape::Square->value,
                'avatar_style' => AvatarStyle::Rings->value,
                'panda' => '0',
            ])
            ->assertSuccessful();

        assertDatabaseHas('settings', [
            'key' => 'custom',
            'appearance->theme' => 'Pulsar',
            'appearance->colorsGray' => 'Zinc',
            'appearance->colorsPrimary' => 'Violet',
            'appearance->colorsSuccess' => 'Lime',
            'appearance->colorsDanger' => 'Red',
            'appearance->colorsWarning' => 'Yellow',
            'appearance->colorsInfo' => 'Blue',
            'appearance->avatarShape' => 'square',
            'appearance->avatarStyle' => 'rings',
            'appearance->adminFonts->headerProvider' => 'local',
            'appearance->adminFonts->headerFamily' => 'Inter',
            'appearance->adminFonts->bodyProvider' => 'local',
            'appearance->adminFonts->bodyFamily' => 'Inter',
            'appearance->panda' => false,
        ]);
    });

    it('can upload a logo', function () {
        Storage::fake('media');
        Storage::fake('tmp-for-tests');

        $imagePath = livewire(UploadImage::class)
            ->set('image', UploadedFile::fake()->image('logo.png'))
            ->get('path');

        $data = [
            'theme' => 'Pulsar',
            'admin_fonts' => [
                'headerProvider' => 'local',
                'headerFamily' => 'Inter',
                'bodyProvider' => 'local',
                'bodyFamily' => 'Inter',
            ],
            'colors_gray' => 'Zinc',
            'colors_primary' => 'Violet',
            'colors_success' => 'Lime',
            'colors_danger' => 'Red',
            'colors_warning' => 'Yellow',
            'colors_info' => 'Blue',
            'avatar_shape' => 'square',
            'avatar_style' => 'rings',
            'panda' => '0',
            'image_path' => $imagePath,
        ];

        from(route('admin.settings.appearance.edit'))
            ->followingRedirects()
            ->put(route('admin.settings.appearance.update'), $data)
            ->assertSuccessful();

        assertCount(1, settings()->getMedia('logo'));
    });

    it('can replace a logo', function () {
        Storage::fake('media');
        Storage::fake('tmp-for-tests');

        $imagePath = livewire(UploadImage::class)
            ->set('image', UploadedFile::fake()->image('logo1.png'))
            ->get('path');

        $data = [
            'theme' => 'Pulsar',
            'admin_fonts' => [
                'headerProvider' => 'local',
                'headerFamily' => 'Inter',
                'bodyProvider' => 'local',
                'bodyFamily' => 'Inter',
            ],
            'colors_gray' => 'Zinc',
            'colors_primary' => 'Violet',
            'colors_success' => 'Lime',
            'colors_danger' => 'Red',
            'colors_warning' => 'Yellow',
            'colors_info' => 'Blue',
            'avatar_shape' => 'square',
            'avatar_style' => 'rings',
            'panda' => '0',
            'image_path' => $imagePath,
        ];

        assertCount(0, settings()->getMedia('logo'));

        from(route('admin.settings.appearance.edit'))
            ->put(route('admin.settings.appearance.update'), $data);

        assertCount(1, settings()->getMedia('logo'));

        $imagePath = livewire(UploadImage::class)
            ->set('image', UploadedFile::fake()->image('logo2.png'))
            ->get('path');

        $data = [
            'theme' => 'Pulsar',
            'admin_fonts' => [
                'headerProvider' => 'local',
                'headerFamily' => 'Inter',
                'bodyProvider' => 'local',
                'bodyFamily' => 'Inter',
            ],
            'colors_gray' => 'Zinc',
            'colors_primary' => 'Violet',
            'colors_success' => 'Lime',
            'colors_danger' => 'Red',
            'colors_warning' => 'Yellow',
            'colors_info' => 'Blue',
            'avatar_shape' => 'square',
            'avatar_style' => 'rings',
            'panda' => '0',
            'image_path' => $imagePath,
        ];

        from(route('admin.settings.appearance.edit'))
            ->followingRedirects()
            ->put(route('admin.settings.appearance.update'), $data)
            ->assertSuccessful();

        assertCount(1, settings()->getMedia('logo'));
    });

    it('can remove a logo', function () {
        //
    })->skip();
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    it('cannot view the appearance settings page', function () {
        get(route('admin.settings.appearance.edit'))
            ->assertForbidden();
    });

    it('cannot update appearance settings', function () {
        put(route('admin.settings.appearance.update'), [])
            ->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    it('cannot view the appearance settings page', function () {
        get(route('admin.settings.appearance.edit'))
            ->assertRedirectToRoute('login');
    });

    it('cannot update appearance settings', function () {
        put(route('admin.settings.appearance.update'), [])
            ->assertRedirectToRoute('login');
    });
});
