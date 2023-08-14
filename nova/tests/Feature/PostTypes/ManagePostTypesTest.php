<?php

declare(strict_types=1);
use Nova\PostTypes\Models\PostType;
test('authorized user with create permission can view manage post types page', function () {
    $this->signInWithPermission('post-type.create');

    $response = $this->get(route('post-types.index'));
    $response->assertSuccessful();
});
test('authorized user with update permission can view manage post types page', function () {
    $this->signInWithPermission('post-type.update');

    $response = $this->get(route('post-types.index'));
    $response->assertSuccessful();
});
test('authorized user with delete permission can view manage post types page', function () {
    $this->signInWithPermission('post-type.delete');

    $response = $this->get(route('post-types.index'));
    $response->assertSuccessful();
});
test('authorized user with view permission can view manage post types page', function () {
    $this->signInWithPermission('post-type.view');

    $response = $this->get(route('post-types.index'));
    $response->assertSuccessful();
});
test('post types can be filtered by name', function () {
    $this->signInWithPermission('post-type.create');

    PostType::factory()->create([
        'name' => 'barbaz',
    ]);

    $response = $this->get(route('post-types.index'));
    $response->assertSuccessful();

    expect($response['postTypes']->total())->toEqual(PostType::count());

    $response = $this->get(route('post-types.index', 'search=barbaz'));
    $response->assertSuccessful();

    expect($response['postTypes'])->toHaveCount(1);
});
test('unauthorized user cannot view manage post types page', function () {
    $this->signIn();

    $response = $this->get(route('post-types.index'));
    $response->assertNotFound();
});
test('unauthenticated user cannot view manage post types page', function () {
    $response = $this->getJson(route('post-types.index'));
    $response->assertUnauthorized();
});
