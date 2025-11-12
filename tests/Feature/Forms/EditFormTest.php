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
    $this->form = Form::factory()->active()->create();
});

describe('authorized user', function () {
    beforeEach(fn () => signIn(permissions: 'form.update'));

    test('can view the edit form page', function () {
        get(route('admin.forms.edit', $this->form))->assertSuccessful();
    });

    test('can update a form', function () {
        Event::fake();

        $data = Form::factory()->active()->forRequest();

        from(route('admin.forms.edit', $this->form))
            ->followingRedirects()
            ->put(route('admin.forms.update', $this->form), $data->payload)
            ->assertSuccessful();

        assertDatabaseHas(Form::class, [
            'id' => $this->form->id,
            'status' => 'active',
        ]);

        Event::assertDispatched(FormUpdated::class);
    });

    test('can set a form active', function () {
        Event::fake();

        $data = Form::factory()->active()->forRequest();

        from(route('admin.forms.edit', $this->form))
            ->followingRedirects()
            ->put(route('admin.forms.update', $this->form), $data->payload)
            ->assertSuccessful();

        assertDatabaseHas(Form::class, [
            'id' => $this->form->id,
            'status' => 'active',
        ]);
    });

    test('can set a form inactive', function () {
        Event::fake();

        $data = Form::factory()->inactive()->forRequest();

        from(route('admin.forms.edit', $this->form))
            ->followingRedirects()
            ->put(route('admin.forms.update', $this->form), $data->payload)
            ->assertSuccessful();

        assertDatabaseHas(Form::class, [
            'id' => $this->form->id,
            'status' => 'inactive',
        ]);
    });
});

describe('form options', function () {
    beforeEach(fn () => signIn(permissions: 'form.update'));

    test('can allow only authenticated users', function () {
        Event::fake();

        $data = [
            'name' => 'Test form',
            'key' => 'test-form',
            'type' => 'basic',
            'options' => [
                'onlyAuthenticatedUsers' => 'on',
            ],
        ];

        from(route('admin.forms.edit', $this->form))
            ->followingRedirects()
            ->put(route('admin.forms.update', $this->form), $data)
            ->assertSuccessful();

        assertDatabaseHas(Form::class, [
            'id' => $this->form->id,
            'type' => 'basic',
            'options->onlyAuthenticatedUsers' => true,
        ]);
    });

    test('can allow any user', function () {
        Event::fake();

        $data = [
            'name' => 'Test form',
            'key' => 'test-form',
            'type' => 'basic',
            'options' => [],
        ];

        from(route('admin.forms.edit', $this->form))
            ->followingRedirects()
            ->put(route('admin.forms.update', $this->form), $data)
            ->assertSuccessful();

        assertDatabaseHas(Form::class, [
            'id' => $this->form->id,
            'type' => 'basic',
            'options->onlyAuthenticatedUsers' => false,
        ]);
    });

    test('can allow collecting responses', function () {
        Event::fake();

        $data = [
            'name' => 'Test form',
            'key' => 'test-form',
            'type' => 'basic',
            'options' => [
                'collectResponses' => 'on',
            ],
        ];

        from(route('admin.forms.edit', $this->form))
            ->followingRedirects()
            ->put(route('admin.forms.update', $this->form), $data)
            ->assertSuccessful();

        assertDatabaseHas(Form::class, [
            'id' => $this->form->id,
            'type' => 'basic',
            'options->collectResponses' => true,
        ]);
    });

    test('can disallow collecting responses', function () {
        Event::fake();

        $data = [
            'name' => 'Test form',
            'key' => 'test-form',
            'type' => 'basic',
            'options' => [],
        ];

        from(route('admin.forms.edit', $this->form))
            ->followingRedirects()
            ->put(route('admin.forms.update', $this->form), $data)
            ->assertSuccessful();

        assertDatabaseHas(Form::class, [
            'id' => $this->form->id,
            'type' => 'basic',
            'options->collectResponses' => false,
        ]);
    });

    test('can allow a single response', function () {
        Event::fake();

        $data = [
            'name' => 'Test form',
            'key' => 'test-form',
            'type' => 'basic',
            'options' => [
                'collectResponses' => 'on',
                'singleSubmission' => 'on',
            ],
        ];

        from(route('admin.forms.edit', $this->form))
            ->followingRedirects()
            ->put(route('admin.forms.update', $this->form), $data)
            ->assertSuccessful();

        assertDatabaseHas(Form::class, [
            'id' => $this->form->id,
            'type' => 'basic',
            'options->collectResponses' => true,
            'options->singleSubmission' => true,
        ]);
    });

    test('can allow multiple responses', function () {
        Event::fake();

        $data = [
            'name' => 'Test form',
            'key' => 'test-form',
            'type' => 'basic',
            'options' => [
                'collectResponses' => 'on',
            ],
        ];

        from(route('admin.forms.edit', $this->form))
            ->followingRedirects()
            ->put(route('admin.forms.update', $this->form), $data)
            ->assertSuccessful();

        assertDatabaseHas(Form::class, [
            'id' => $this->form->id,
            'type' => 'basic',
            'options->collectResponses' => true,
            'options->singleSubmission' => false,
        ]);
    });

    test('can allow emailing responses', function () {
        Event::fake();

        $data = [
            'name' => 'Test form',
            'key' => 'test-form',
            'type' => 'basic',
            'options' => [
                'emailResponses' => 'on',
            ],
        ];

        from(route('admin.forms.edit', $this->form))
            ->followingRedirects()
            ->put(route('admin.forms.update', $this->form), $data)
            ->assertSuccessful();

        assertDatabaseHas(Form::class, [
            'id' => $this->form->id,
            'type' => 'basic',
            'options->emailResponses' => true,
        ]);
    });

    test('can disallow emailing responses', function () {
        Event::fake();

        $data = [
            'name' => 'Test form',
            'key' => 'test-form',
            'type' => 'basic',
            'options' => [],
        ];

        from(route('admin.forms.edit', $this->form))
            ->followingRedirects()
            ->put(route('admin.forms.update', $this->form), $data)
            ->assertSuccessful();

        assertDatabaseHas(Form::class, [
            'id' => $this->form->id,
            'type' => 'basic',
            'options->emailResponses' => false,
        ]);
    });

    test('can allow setting email recipients when allowing emailing responses', function () {
        Event::fake();

        $data = [
            'name' => 'Test form',
            'key' => 'test-form',
            'type' => 'basic',
            'options' => [
                'emailResponses' => 'on',
                'emailRecipients' => 'one@example.test,two@example.test',
            ],
        ];

        from(route('admin.forms.edit', $this->form))
            ->followingRedirects()
            ->put(route('admin.forms.update', $this->form), $data)
            ->assertSuccessful();

        assertDatabaseHas(Form::class, [
            'id' => $this->form->id,
            'type' => 'basic',
            'options->emailResponses' => true,
            'options->emailRecipients' => 'one@example.test,two@example.test',
        ]);
    });
});

describe('unauthorized user', function () {
    beforeEach(fn () => signIn());

    test('cannot view the edit form page', function () {
        get(route('admin.forms.edit', $this->form))
            ->assertNotFound();
    });

    test('cannot update a form', function () {
        $data = Form::factory()->forRequest();

        put(route('admin.forms.update', $this->form), $data->payload)
            ->assertNotFound();
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
