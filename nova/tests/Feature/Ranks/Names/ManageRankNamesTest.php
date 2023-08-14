<?php

declare(strict_types=1);
use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Ranks\Models\RankName;
test('authorized user with create permission can view manage rank names page', function () {
    $this->signInWithPermission('rank.create');

    $response = $this->get(route('ranks.names.index'));
    $response->assertSuccessful();
});
test('authorized user with update permission can view manage rank names page', function () {
    $this->signInWithPermission('rank.update');

    $response = $this->get(route('ranks.names.index'));
    $response->assertSuccessful();
});
test('authorized user with delete permission can view manage rank names page', function () {
    $this->signInWithPermission('rank.delete');

    $response = $this->get(route('ranks.names.index'));
    $response->assertSuccessful();
});
test('authorized user with view permission can view manage rank names page', function () {
    $this->signInWithPermission('rank.view');

    $response = $this->get(route('ranks.names.index'));
    $response->assertSuccessful();
});
test('rank names can be filtered by name', function () {
    $this->signInWithPermission('rank.create');

    RankName::factory()->create([
        'name' => 'Captain',
    ]);

    $response = $this->get(route('ranks.names.index'));
    $response->assertSuccessful();

    expect($response['names']->total())->toEqual(RankName::count());

    $response = $this->get(route('ranks.names.index', 'search=captain'));
    $response->assertSuccessful();

    expect($response['names'])->toHaveCount(1);
});
test('unauthorized user cannot view manage rank names page', function () {
    $this->signIn();

    $response = $this->get(route('ranks.names.index'));
    $response->assertForbidden();
});
test('unauthenticated user cannot view manage rank names page', function () {
    $response = $this->getJson(route('ranks.names.index'));
    $response->assertUnauthorized();
});
