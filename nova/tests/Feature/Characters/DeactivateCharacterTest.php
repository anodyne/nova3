<?php

declare(strict_types=1);

use Nova\Characters\Models\Character;
use function Pest\Laravel\getJson;

uses()->group('characters');

beforeEach(function () {
    $this->character = Character::factory()->active()->create();
});

describe('authorized user', function () {
    test('can deactivate a character', function () {

    })->todo();

    test('can deactivate multiple characters', function () {

    })->todo();
});

test('unauthorized user cannot deactivate a character', function () {

})->todo();

test('unauthorized user cannot deactivate multiple characters', function () {

})->todo();

test('unauthenticated user cannot deactivate a character', function () {
    getJson(route('characters.index'))->assertUnauthorized();
});
