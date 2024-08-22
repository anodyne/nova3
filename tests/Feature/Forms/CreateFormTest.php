<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Event;
use Nova\Forms\Events\FormCreated;
use Nova\Forms\Models\Form;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\from;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

uses()->group('forms');

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'form.create');
    });

    test('can view the create form page', function () {
        get(route('admin.forms.create'))->assertSuccessful();
    });

    test('can create a form', function () {
        Event::fake();

        $data = Form::factory()->make();

        from(route('admin.forms.create'))
            ->followingRedirects()
            ->post(route('admin.forms.store'), $data->toArray())
            ->assertSuccessful();

        assertDatabaseHas(Form::class, $data->toArray());

        Event::assertDispatched(FormCreated::class);
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot view the create form page', function () {
        get(route('admin.forms.create'))->assertForbidden();
    });

    test('cannot create a form', function () {
        $data = Form::factory()->make();

        post(route('admin.forms.store'), $data->toArray())->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the create form page', function () {
        get(route('admin.forms.create'))
            ->assertRedirectToRoute('login');
    });

    test('cannot create a form', function () {
        post(route('admin.forms.store'), [])
            ->assertRedirectToRoute('login');
    });
});
