<?php

declare(strict_types=1);

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Nova\Departments\Events\DepartmentCreated;
use Nova\Departments\Models\Department;
use Nova\Media\Livewire\UploadImage;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\from;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Livewire\livewire;
use function PHPUnit\Framework\assertCount;

uses()->group('departments');

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'department.create');
    });

    test('can view the create department page', function () {
        get(route('admin.departments.create'))->assertSuccessful();
    });

    test('can create a department', function () {
        Event::fake();

        $data = Department::factory()->make();

        from(route('admin.departments.create'))
            ->followingRedirects()
            ->post(route('admin.departments.store'), $data->toArray())
            ->assertSuccessful();

        assertDatabaseHas(Department::class, $data->toArray());

        Event::assertDispatched(DepartmentCreated::class);
    });

    test('can upload a story image when creating', function () {
        Storage::fake('media');
        Storage::fake('tmp-for-tests');

        $imagePath = livewire(UploadImage::class)
            ->set('image', UploadedFile::fake()->image('department-image.png'))
            ->get('path');

        $data = array_merge(
            Department::factory()->make()->toArray(),
            ['image_path' => $imagePath]
        );

        from(route('admin.departments.create'))
            ->followingRedirects()
            ->post(route('admin.departments.store'), $data)
            ->assertSuccessful();

        $department = Department::where('name', $data['name'])->first();

        assertCount(1, $department->getMedia('header'));
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot view the create department page', function () {
        get(route('admin.departments.create'))->assertForbidden();
    });

    test('cannot create a department', function () {
        $data = Department::factory()->make();

        post(route('admin.departments.store'), $data->toArray())->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the create department page', function () {
        get(route('admin.departments.create'))
            ->assertRedirectToRoute('login');
    });

    test('cannot create a department', function () {
        post(route('admin.departments.store'), [])
            ->assertRedirectToRoute('login');
    });
});
