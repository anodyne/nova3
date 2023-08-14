<?php

declare(strict_types=1);
use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Ranks\Models\RankGroup;
use Nova\Ranks\Models\RankItem;
use Nova\Ranks\Models\RankName;
beforeEach(function () {
    $this->group = RankGroup::factory()->create();
    $this->name = RankName::factory()->create();
    $this->item = RankItem::factory()->create([
        'group_id' => $this->group,
        'name_id' => $this->name,
    ]);
});
test('authorized user can view a rank item', function () {
    $this->signInWithPermission('rank.view');

    $response = $this->get(route('ranks.items.show', $this->item));
    $response->assertSuccessful();
    $response->assertViewHas('item', $this->item);
    $response->assertSee($this->group->name);
    $response->assertSee($this->name->name);
});
test('unauthorized user cannot view a rank item', function () {
    $this->signIn();

    $response = $this->get(route('ranks.items.show', $this->item));
    $response->assertForbidden();
});
test('unauthenticated user cannot view a rank item', function () {
    $response = $this->getJson(route('ranks.items.show', $this->item));
    $response->assertUnauthorized();
});
