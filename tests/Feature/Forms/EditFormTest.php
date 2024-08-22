<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Event;
use Nova\Forms\Events\FormUpdated;
use Nova\Forms\Models\Form;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\from;
use function Pest\Laravel\get;
use function Pest\Laravel\put;

uses()->group('forms');

beforeEach(function () {
    $this->form = Form::factory()->create();
});

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'form.update');
    });

    test('can view the edit form page', function () {
        get(route('admin.forms.edit', $this->form))->assertSuccessful();
    });

    test('can update a form', function () {
        Event::fake();

        $data = Form::factory()->make();

        from(route('admin.forms.edit', $this->form))
            ->followingRedirects()
            ->put(route('admin.forms.update', $this->form), $data->toArray())
            ->assertSuccessful();

        assertDatabaseHas(Form::class, $data->toArray());

        Event::assertDispatched(FormUpdated::class);
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot view the edit form page', function () {
        get(route('admin.forms.edit', $this->form))
            ->assertForbidden();
    });

    test('cannot update a form', function () {
        $data = Form::factory()->make();

        put(route('admin.forms.update', $this->form), $data->toArray())
            ->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the edit form page', function () {
        get(route('admin.forms.edit', $this->form))
            ->assertRedirectToRoute('login');
    });

    test('cannot update a form', function () {
        put(route('admin.forms.update', $this->form), [])
            ->assertRedirectToRoute('login');
    });
});
