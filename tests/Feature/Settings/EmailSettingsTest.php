<?php

declare(strict_types=1);

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Nova\Media\Livewire\UploadImage;
use Nova\Settings\Enums\SettingsKey;
use Nova\Settings\Livewire\EmailSettings;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\from;
use function Pest\Laravel\get;
use function Pest\Livewire\livewire;
use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertEquals;

uses()->group('settings');

describe('authorized user', function () {
    beforeEach(fn () => signIn(permissions: 'settings.update'));

    test('can view the email settings page', function () {
        get(route('admin.settings.email.edit'))
            ->assertSuccessful();
    });

    test('can update email settings', function () {
        livewire(EmailSettings::class)
            ->set('form.subjectPrefix', '[Nova 3]')
            ->set('form.replyTo', 'donotreply@example.com')
            ->set('form.fromAddress', 'from@example.com')
            ->set('form.fromName', 'From')
            ->set('form.mailer', 'sendmail')
            ->call('save');

        assertDatabaseHas('settings', [
            'key' => SettingsKey::Custom->value,
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

        livewire(EmailSettings::class)
            ->set('form.imageAction', 'add')
            ->set('form.imageTempPath', $imagePath)
            ->call('save');

        assertCount(1, settings()->getMedia('email-logo'));
    })->skip();

    it('can replace a logo', function () {
        Storage::fake('media');
        Storage::fake('tmp-for-tests');

        $imagePath = livewire(UploadImage::class)
            ->set('image', UploadedFile::fake()->image('logo1.png'))
            ->get('path');

        assertCount(0, settings()->getMedia('email-logo'));

        livewire(EmailSettings::class)
            ->set('form.imageAction', 'add')
            ->set('form.imageTempPath', $imagePath)
            ->call('save');

        assertCount(1, settings()->getMedia('email-logo'));

        $imagePath = livewire(UploadImage::class)
            ->set('image', UploadedFile::fake()->image('logo2.png'))
            ->get('path');

        livewire(EmailSettings::class)
            ->set('form.imageAction', 'replace')
            ->set('form.imageTempPath', $imagePath)
            ->call('save');

        assertCount(1, settings()->getMedia('email-logo'));
    })->skip();

    it('can remove a logo', function () {
        //
    })->skip();
});

describe('unauthorized user', function () {
    beforeEach(fn () => signIn());

    test('cannot view the email settings page', function () {
        get(route('admin.settings.email.edit'))
            ->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the email settings page', function () {
        get(route('admin.settings.email.edit'))
            ->assertRedirectToRoute('login');
    });
});

describe('email ENV writer', function () {
    beforeEach(fn () => signIn(permissions: 'settings.update'));

    it('can write from address configuration', function () {
        $data = [
            'subject_prefix' => '[Nova 3]',
            'reply_to' => 'donotreply@example.com',
            'from_address' => 'from@example.com',
            'from_name' => 'From',
            'mailer' => 'sendmail',
        ];

        from(route('admin.settings.email.edit'))
            ->followingRedirects()
            ->put(route('admin.settings.email.update'), $data)
            ->assertSuccessful();

        assertEquals('sendmail', config('mail.default'));
    })->skip();

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
