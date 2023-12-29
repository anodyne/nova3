<?php

declare(strict_types=1);

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Nova\Media\Livewire\UploadImage;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\from;
use function Pest\Laravel\get;
use function Pest\Laravel\put;
use function Pest\Livewire\livewire;
use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertEquals;

uses()->group('settings');

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'settings.update');
    });

    test('can view the email settings page', function () {
        get(route('settings.email.edit'))
            ->assertSuccessful();
    });

    test('can update email settings', function () {
        from(route('settings.email.edit'))
            ->followingRedirects()
            ->put(route('settings.email.update'), [
                'subject_prefix' => '[Nova 3]',
                'reply_to' => 'donotreply@example.com',
                'from_address' => 'from@example.com',
                'from_name' => 'From',
                'mailer' => 'sendmail',
            ])
            ->assertSuccessful();

        assertDatabaseHas('settings', [
            'key' => 'custom',
            'email->subjectPrefix' => '[Nova 3]',
            'email->replyTo' => 'donotreply@example.com',
        ]);
    });

    it('can upload a logo', function () {
        Storage::fake('media');
        Storage::fake('tmp-for-tests');

        $imagePath = livewire(UploadImage::class)
            ->set('image', UploadedFile::fake()->image('logo.png'))
            ->get('path');

        $data = [
            'subject_prefix' => '[Nova 3]',
            'reply_to' => 'donotreply@example.com',
            'from_address' => 'from@example.com',
            'from_name' => 'From',
            'mailer' => 'sendmail',
            'image_path' => $imagePath,
        ];

        from(route('settings.email.edit'))
            ->followingRedirects()
            ->put(route('settings.email.update'), $data)
            ->assertSuccessful();

        assertCount(1, settings()->getMedia('email-logo'));
    });

    it('can replace a logo', function () {
        Storage::fake('media');
        Storage::fake('tmp-for-tests');

        $imagePath = livewire(UploadImage::class)
            ->set('image', UploadedFile::fake()->image('logo1.png'))
            ->get('path');

        $data = [
            'subject_prefix' => '[Nova 3]',
            'reply_to' => 'donotreply@example.com',
            'from_address' => 'from@example.com',
            'from_name' => 'From',
            'mailer' => 'sendmail',
            'image_path' => $imagePath,
        ];

        assertCount(0, settings()->getMedia('email-logo'));

        from(route('settings.email.edit'))
            ->put(route('settings.email.update'), $data);

        assertCount(1, settings()->getMedia('email-logo'));

        $imagePath = livewire(UploadImage::class)
            ->set('image', UploadedFile::fake()->image('logo2.png'))
            ->get('path');

        $data = [
            'subject_prefix' => '[Nova 3]',
            'reply_to' => 'donotreply@example.com',
            'from_address' => 'from@example.com',
            'from_name' => 'From',
            'mailer' => 'sendmail',
            'image_path' => $imagePath,
        ];

        from(route('settings.email.edit'))
            ->followingRedirects()
            ->put(route('settings.email.update'), $data)
            ->assertSuccessful();

        assertCount(1, settings()->getMedia('email-logo'));
    });

    it('can remove a logo', function () {
        //
    })->skip();
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot view the email settings page', function () {
        get(route('settings.email.edit'))
            ->assertForbidden();
    });

    test('cannot update email settings', function () {
        put(route('settings.email.update'), [])
            ->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the email settings page', function () {
        get(route('settings.email.edit'))
            ->assertRedirectToRoute('login');
    });

    test('cannot update email settings', function () {
        put(route('settings.email.update'), [])
            ->assertRedirectToRoute('login');
    });
});

describe('email ENV writer', function () {
    beforeEach(function () {
        signIn(permissions: 'settings.update');
    });

    it('can write from address configuration', function () {
        $data = [
            'subject_prefix' => '[Nova 3]',
            'reply_to' => 'donotreply@example.com',
            'from_address' => 'from@example.com',
            'from_name' => 'From',
            'mailer' => 'sendmail',
        ];

        from(route('settings.email.edit'))
            ->followingRedirects()
            ->put(route('settings.email.update'), $data)
            ->assertSuccessful();

        assertEquals('sendmail', config('mail.default'));
    });

    it('can write sendmail configuration', function () {
        //
    });

    it('can write SMTP configuration', function () {
        //
    });

    it('can write Mailgun configuration', function () {
        //
    });

    it('can write Mailersend configuration', function () {
        //
    });

    it('can write Postmark configuration', function () {
        //
    });

    it('can write AWS SES configuration', function () {
        //
    });
})->todo('Need to write tests for checking the ENV writer');
