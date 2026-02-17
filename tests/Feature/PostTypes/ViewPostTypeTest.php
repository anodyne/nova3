<?php

declare(strict_types=1);

use Nova\Stories\Models\PostType;

use function Pest\Laravel\get;

uses()->group('post-types', 'storytelling');

beforeEach(function () {
    $this->postType = PostType::factory()->create();
});

describe('authorized user', function () {
    beforeEach(fn () => signIn(permissions: 'post-type.view'));

    test('can view the view post types page', function () {
        get(route('admin.post-types.show', $this->postType))->assertSuccessful();
    });
});

describe('unauthorized user', function () {
    beforeEach(fn () => signIn());

    test('cannot view the view post types page', function () {
        get(route('admin.post-types.show', $this->postType))->assertForbidden();
    });
});

describe('unauthenticated user', function () {
    test('cannot view the view post types page', function () {
        get(route('admin.post-types.show', $this->postType))
            ->assertRedirectToRoute('login');
    });
});
