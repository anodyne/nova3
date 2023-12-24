<?php

declare(strict_types=1);

use function Pest\Laravel\from;

uses()->group('settings');

describe('appearance settings', function () {
    it('can update settings', function () {
        from(route('settings.index', 'appearance'))
            ->followingRedirects()
            ->put(route('settings.update'), [])
            ->assertSuccessful();
    });
});
