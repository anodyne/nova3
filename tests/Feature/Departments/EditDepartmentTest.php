<?php

declare(strict_types=1);

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Nova\Departments\Events\DepartmentUpdated;
use Nova\Departments\Models\Department;
use Nova\Media\Livewire\UploadImage;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\from;
use function Pest\Laravel\get;
use function Pest\Laravel\put;
use function Pest\Livewire\livewire;
use function PHPUnit\Framework\assertCount;

uses()->group('departments');

beforeEach(function () {
    $this->department = Department::factory()->create();
});

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'department.update');
    });

    test('can view the edit department page', function () {
        get(route('departments.edit', $this->department))->assertSuccessful();
    });

    test('can update a department', function () {
        Event::fake();

        $data = Department::factory()->make();

        from(route('departments.edit', $this->department))
            ->followingRedirects()
            ->put(route('departments.update', $this->department), $data->toArray())
            ->assertSuccessful();

        assertDatabaseHas(Department::class, $data->toArray());

        Event::assertDispatched(DepartmentUpdated::class);
    });

    test('can add a story image', function () {
        Storage::fake('media');
        Storage::fake('tmp-for-tests');

        $imagePath = livewire(UploadImage::class)
            ->set('image', UploadedFile::fake()->image('department-image.png'))
            ->get('path');

        $data = array_merge(
            Department::factory()->make()->toArray(),
            ['image_path' => $imagePath]
        );

        from(route('departments.edit', $this->department))
            ->followingRedirects()
            ->put(route('departments.update', $this->department), $data)
            ->assertSuccessful();

        $this->department->refresh();

        assertCount(1, $this->department->getMedia('header'));
    });

    test('can remove an uploaded department image', function () {
    })->todo();

    test('can replace an uploaded department image', function () {
        Storage::fake('media');
        Storage::fake('tmp-for-tests');

        $imagePath = livewire(UploadImage::class)
            ->set('image', UploadedFile::fake()->image('department-image.png'))
            ->get('path');

        $data = array_merge(
            Department::factory()->make()->toArray(),
            ['image_path' => $imagePath]
        );

        assertCount(0, $this->department->getMedia('header'));

        from(route('departments.edit', $this->department))
            ->put(route('departments.update', $this->department), $data);

        $this->department->refresh();

        assertCount(1, $this->department->getMedia('header'));

        $imagePath = livewire(UploadImage::class)
            ->set('image', UploadedFile::fake()->image('department-image-2.png'))
            ->get('path');

        $data = array_merge(
            Department::factory()->make()->toArray(),
            ['image_path' => $imagePath]
        );

        from(route('departments.edit', $this->department))
            ->followingRedirects()
            ->put(route('departments.update', $this->department), $data)
            ->assertSuccessful();

        $this->department->refresh();

        assertCount(1, $this->department->getMedia('header'));
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot view the edit department page', function () {
        get(route('departments.edit', $this->department))
            ->assertForbidden();
    });

    test('cannot update a department', function () {
        $data = Department::factory()->make();

        put(route('departments.update', $this->department), $data->toArray())
            ->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the edit department page', function () {
        get(route('departments.edit', $this->department))
            ->assertRedirect(route('login'));
    });

    test('cannot update a department', function () {
        put(route('departments.update', $this->department), [])
            ->assertRedirect(route('login'));
    });
});
