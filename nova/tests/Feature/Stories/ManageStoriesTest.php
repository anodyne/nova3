<?php

declare(strict_types=1);
test('authorized user with create permission can view manage stories page', function () {
    $this->signInWithPermission('story.create');

    $response = $this->get(route('stories.index'));
    $response->assertSuccessful();
});
test('authorized user with update permission can view manage stories page', function () {
    $this->signInWithPermission('story.update');

    $response = $this->get(route('stories.index'));
    $response->assertSuccessful();
});
test('authorized user with delete permission can view manage stories page', function () {
    $this->signInWithPermission('story.delete');

    $response = $this->get(route('stories.index'));
    $response->assertSuccessful();
});
test('authorized user with view permission can view manage stories page', function () {
    $this->signInWithPermission('story.view');

    $response = $this->get(route('stories.index'));
    $response->assertSuccessful();
});
test('unauthorized user cannot view manage stories page', function () {
    $this->signIn();

    $response = $this->get(route('stories.index'));
    $response->assertNotFound();
});
test('unauthenticated user cannot view manage stories page', function () {
    $response = $this->getJson(route('stories.index'));
    $response->assertUnauthorized();
});
