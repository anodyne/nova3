<?php

declare(strict_types=1);
use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Ranks\Models\RankGroup;
use Nova\Ranks\Models\RankItem;
use Nova\Ranks\Models\RankName;
test('authorized user with create permission can view manage rank items page', function () {
    $this->signInWithPermission('rank.create');

    $response = $this->get(route('ranks.items.index'));
    $response->assertSuccessful();
});
test('authorized user with update permission can view manage rank items page', function () {
    $this->signInWithPermission('rank.update');

    $response = $this->get(route('ranks.items.index'));
    $response->assertSuccessful();
});
test('authorized user with delete permission can view manage rank items page', function () {
    $this->signInWithPermission('rank.delete');

    $response = $this->get(route('ranks.items.index'));
    $response->assertSuccessful();
});
test('authorized user with view permission can view manage rank items page', function () {
    $this->signInWithPermission('rank.view');

    $response = $this->get(route('ranks.items.index'));
    $response->assertSuccessful();
});
test('rank items can be filtered by rank name', function () {
    $this->signInWithPermission('rank.create');

    $group = RankGroup::factory()->create(['name' => 'Command']);
    $name = RankName::factory()->create(['name' => 'Captain']);

    RankItem::factory()->create([
        'group_id' => $group,
        'name_id' => $name,
    ]);
    RankItem::factory()->create(['group_id' => $group]);

    $response = $this->get(route('ranks.items.index'));
    $response->assertSuccessful();

    expect($response['items']->total())->toEqual(RankItem::count());

    $response = $this->get(route('ranks.items.index', 'search=captain'));
    $response->assertSuccessful();
    $response->assertSee('Captain');

    expect($response['items'])->toHaveCount(1);
});
test('rank items can be filtered by rank group', function () {
    $this->signInWithPermission('rank.create');

    $command = RankGroup::factory()->create(['name' => 'Command']);
    $ops = RankGroup::factory()->create(['name' => 'Operations']);

    RankItem::factory()->create(['group_id' => $command]);
    RankItem::factory()->create(['group_id' => $command]);

    RankItem::factory()->create(['group_id' => $ops]);
    RankItem::factory()->create(['group_id' => $ops]);

    $response = $this->get(route('ranks.items.index'));
    $response->assertSuccessful();

    expect($response['items']->total())->toEqual(RankItem::count());

    $response = $this->get(route('ranks.items.index', 'group=command'));
    $response->assertSuccessful();

    expect($response['items'])->toHaveCount(2);
});
test('unauthorized user cannot view manage rank items page', function () {
    $this->signIn();

    $response = $this->get(route('ranks.items.index'));
    $response->assertForbidden();
});
test('unauthenticated user cannot view manage rank items page', function () {
    $response = $this->getJson(route('ranks.items.index'));
    $response->assertUnauthorized();
});
