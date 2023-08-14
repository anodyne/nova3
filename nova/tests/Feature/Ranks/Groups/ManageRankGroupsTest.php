<?php

declare(strict_types=1);
use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Ranks\Models\RankGroup;
test('authorized user with create permission can view manage rank groups page', function () {
    $this->signInWithPermission('rank.create');

    $response = $this->get(route('ranks.groups.index'));
    $response->assertSuccessful();
});
test('authorized user with update permission can view manage rank groups page', function () {
    $this->signInWithPermission('rank.update');

    $response = $this->get(route('ranks.groups.index'));
    $response->assertSuccessful();
});
test('authorized user with delete permission can view manage rank groups page', function () {
    $this->signInWithPermission('rank.delete');

    $response = $this->get(route('ranks.groups.index'));
    $response->assertSuccessful();
});
test('authorized user with view permission can view manage rank groups page', function () {
    $this->signInWithPermission('rank.view');

    $response = $this->get(route('ranks.groups.index'));
    $response->assertSuccessful();
});
test('rank groups can be filtered by name', function () {
    $this->signInWithPermission('rank.create');

    RankGroup::factory()->create([
        'name' => 'Command',
    ]);

    $response = $this->get(route('ranks.groups.index'));
    $response->assertSuccessful();

    expect($response['groups']->total())->toEqual(RankGroup::count());

    $response = $this->get(route('ranks.groups.index', 'search=command'));
    $response->assertSuccessful();

    expect($response['groups'])->toHaveCount(1);
});
test('unauthorized user cannot view manage rank groups page', function () {
    $this->signIn();

    $response = $this->get(route('ranks.groups.index'));
    $response->assertForbidden();
});
test('unauthenticated user cannot view manage rank groups page', function () {
    $response = $this->getJson(route('ranks.groups.index'));
    $response->assertUnauthorized();
});
