<?php

declare(strict_types=1);

use Nova\Stories\Models\Story;

use function Pest\Laravel\get;

uses()->group('stories');

beforeEach(function () {
    $this->story = Story::factory()->create();
});

describe('authorized user', function () {
    beforeEach(function () {
        signIn(permissions: 'story.view');
    });

    test('can view the view story page', function () {
        get(route('stories.show', $this->story))->assertSuccessful();
    });
});

describe('unauthorized user', function () {
    beforeEach(function () {
        signIn();
    });

    test('cannot view the view story page', function () {
        get(route('stories.show', $this->story))->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the view story page', function () {
        get(route('stories.show', $this->story))
            ->assertRedirectToRoute('login');
    });
});
