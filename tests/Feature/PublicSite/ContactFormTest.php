<?php

declare(strict_types=1);

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Notification;
use Nova\PublicSite\Notifications\SiteContactMessage;

use function Pest\Laravel\from;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

uses()->group('public-site');
uses()->group('contact');

beforeEach(function () {
    Notification::fake();
});

test('can view the contact page', function () {
    get(route('public.contact'))
        ->assertSeeText('Contact')
        ->assertSuccessful();
});

test('cannot view the contact page if it is disabled from settings', function () {
    updateSettings(function ($settings) {
        $settings->general = $settings->general->with(
            contactFormEnabled: false,
            contactFormDisabledMessage: 'Contact form has been disabled'
        );

        return $settings;
    });

    expect(settings('general.contactFormEnabled'))->toBeFalse();

    get(route('public.contact'))
        ->assertSeeText('Contact form has been disabled')
        ->assertSuccessful();
});

test('cannot send a POST request to the contact page if it is disabled from settings', function () {
    updateSettings(function ($settings) {
        $settings->general = $settings->general->with(
            contactFormEnabled: false,
            contactFormDisabledMessage: 'Contact form has been disabled'
        );

        return $settings;
    });

    expect(settings('general.contactFormEnabled'))->toBeFalse();

    post(route('public.contact.process'), [
        'name' => 'Reginald Barclay',
        'email' => 'barclay@example.test',
        'subject' => 'Test',
        'message' => 'Test message',
    ])
        ->assertNotFound();
});

test('can submit the contact form', function () {
    $user = createUser(permissions: 'site.contact');

    from(route('public.contact'))
        ->followingRedirects()
        ->post(route('public.contact.process'), [
            'name' => 'Reginald Barclay',
            'email' => 'barclay@example.test',
            'subject' => 'Test',
            'message' => 'Test message',
        ])
        ->assertSuccessful();

    Notification::assertSentTo($user, SiteContactMessage::class);
});

describe('rate limits', function () {
    test('by ip address', function () {
        from(route('public.contact'))
            ->followingRedirects()
            ->post(route('public.contact.process'), [
                'name' => 'Reginald Barclay',
                'email' => 'barclay@example.test',
                'subject' => 'Test',
                'message' => 'Test message',
            ])
            ->assertSuccessful();

        from(route('public.contact'))
            ->followingRedirects()
            ->post(route('public.contact.process'), [
                'name' => 'Reginald Barclay',
                'email' => 'barclay@example.test',
                'subject' => 'Test',
                'message' => 'Test message',
            ])
            ->assertStatus(Response::HTTP_TOO_MANY_REQUESTS);
    });
});
