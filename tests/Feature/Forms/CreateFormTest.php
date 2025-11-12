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
    beforeEach(fn () => signIn(permissions: 'form.create'));

    test('can view the create form page', function () {
        get(route('admin.forms.create'))->assertSuccessful();
    });

    test('can create a basic form', function () {
        Event::fake();

        $data = Form::factory()->active()->basic()->forRequest();

        from(route('admin.forms.create'))
            ->followingRedirects()
            ->post(route('admin.forms.store'), $data->payload)
            ->assertSuccessful();

        $form = Form::latest()->first();

        assertDatabaseHas(Form::class, [
            'id' => $form->id,
            'type' => 'basic',
        ]);

        Event::assertDispatched(FormCreated::class);
    });

    test('can create an advanced form', function () {
        Event::fake();

        $data = Form::factory()->active()->advanced()->forRequest();

        from(route('admin.forms.create'))
            ->followingRedirects()
            ->post(route('admin.forms.store'), $data->payload)
            ->assertSuccessful();

        $form = Form::latest()->first();

        assertDatabaseHas(Form::class, [
            'id' => $form->id,
            'type' => 'advanced',
        ]);

        Event::assertDispatched(FormCreated::class);
    });
});

describe('form options', function () {
    beforeEach(fn () => signIn(permissions: 'form.create'));

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

        from(route('admin.forms.create'))
            ->followingRedirects()
            ->post(route('admin.forms.store'), $data)
            ->assertSuccessful();

        $form = Form::key($data['key'])->first();

        assertDatabaseHas(Form::class, [
            'id' => $form->id,
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

        from(route('admin.forms.create'))
            ->followingRedirects()
            ->post(route('admin.forms.store'), $data)
            ->assertSuccessful();

        $form = Form::key($data['key'])->first();

        assertDatabaseHas(Form::class, [
            'id' => $form->id,
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

        from(route('admin.forms.create'))
            ->followingRedirects()
            ->post(route('admin.forms.store'), $data)
            ->assertSuccessful();

        $form = Form::key($data['key'])->first();

        assertDatabaseHas(Form::class, [
            'id' => $form->id,
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

        from(route('admin.forms.create'))
            ->followingRedirects()
            ->post(route('admin.forms.store'), $data)
            ->assertSuccessful();

        $form = Form::key($data['key'])->first();

        assertDatabaseHas(Form::class, [
            'id' => $form->id,
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

        from(route('admin.forms.create'))
            ->followingRedirects()
            ->post(route('admin.forms.store'), $data)
            ->assertSuccessful();

        $form = Form::key($data['key'])->first();

        assertDatabaseHas(Form::class, [
            'id' => $form->id,
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

        from(route('admin.forms.create'))
            ->followingRedirects()
            ->post(route('admin.forms.store'), $data)
            ->assertSuccessful();

        $form = Form::key($data['key'])->first();

        assertDatabaseHas(Form::class, [
            'id' => $form->id,
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

        from(route('admin.forms.create'))
            ->followingRedirects()
            ->post(route('admin.forms.store'), $data)
            ->assertSuccessful();

        $form = Form::key($data['key'])->first();

        assertDatabaseHas(Form::class, [
            'id' => $form->id,
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

        from(route('admin.forms.create'))
            ->followingRedirects()
            ->post(route('admin.forms.store'), $data)
            ->assertSuccessful();

        $form = Form::key($data['key'])->first();

        assertDatabaseHas(Form::class, [
            'id' => $form->id,
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

        from(route('admin.forms.create'))
            ->followingRedirects()
            ->post(route('admin.forms.store'), $data)
            ->assertSuccessful();

        $form = Form::key($data['key'])->first();

        assertDatabaseHas(Form::class, [
            'id' => $form->id,
            'type' => 'basic',
            'options->emailResponses' => true,
            'options->emailRecipients' => 'one@example.test,two@example.test',
        ]);
    });
});

describe('unauthorized user', function () {
    beforeEach(fn () => signIn());

    test('cannot view the create form page', function () {
        get(route('admin.forms.create'))->assertNotFound();
    });

    test('cannot create a form', function () {
        $data = Form::factory()->active()->forRequest();

        post(route('admin.forms.store'), $data->payload)->assertNotFound();
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
