<?php

declare(strict_types=1);

use Nova\Characters\Models\Character;
use function Pest\Laravel\getJson;

uses()->group('characters');

beforeEach(function () {
    $this->character = Character::factory()->active()->create();
});

describe('authorized user', function () {
    test('can activate a character', function () {

    })->todo();

    test('can activate multiple characters', function () {

    })->todo();
});

test('unauthorized user cannot activate a character', function () {

})->todo();

test('unauthorized user cannot activate multiple characters', function () {

})->todo();

test('unauthenticated user cannot activate a character', function () {
    getJson(route('characters.index'))->assertUnauthorized();
});
