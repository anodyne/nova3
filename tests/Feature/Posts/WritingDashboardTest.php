<?php

declare(strict_types=1);

use function Pest\Laravel\get;

uses()->group('stories');
uses()->group('posts');
uses()->group('dashboards');

describe('authorized user', function () {
    //
});

describe('unauthorized user', function () {
    //
});

describe('unauthenticated user', function () {
    test('cannot view the writing dashboard', function () {
        get(route('writing-overview'))->assertRedirectToRoute('login');
    });
});
