<?php

declare(strict_types=1);

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\from;
use function Pest\Laravel\get;
use function Pest\Laravel\put;

uses()->group('settings');

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'settings.update');
    });

    test('can view the general settings page', function () {
        get(route('settings.general.edit'))
            ->assertSuccessful();
    });

    test('can update general settings', function () {
        from(route('settings.general.edit'))
            ->followingRedirects()
            ->put(route('settings.general.update'), [
                'game_name' => 'Foo',
                'dateFormatTags' => '[[{"value":"#year_long#","text":"Year, long (2024)","prefix":"#"}]]',
            ])
            ->assertSuccessful();

        assertDatabaseHas('settings', [
            'key' => 'custom',
            'general->gameName' => 'Foo',
            'general->dateFormat' => '#year_long#',
            'general->dateFormatTags' => '[[{"value":"#year_long#","text":"Year, long (2024)","prefix":"#"}]]',
        ]);
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot view the general settings page', function () {
        get(route('settings.general.edit'))
            ->assertForbidden();
    });

    test('cannot update general settings', function () {
        put(route('settings.general.update'), [])
            ->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the general settings page', function () {
        get(route('settings.general.edit'))
            ->assertRedirectToRoute('login');
    });

    test('cannot update general settings', function () {
        put(route('settings.general.update'), [])
            ->assertRedirectToRoute('login');
    });
});
