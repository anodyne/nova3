<?php

declare(strict_types=1);
use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Ranks\Models\RankGroup;
beforeEach(function () {
    $this->group = RankGroup::factory()->create();
});
test('authorized user can view a rank group', function () {
    $this->signInWithPermission('rank.view');

    $response = $this->get(route('ranks.groups.show', $this->group));
    $response->assertSuccessful();
    $response->assertViewHas('group', $this->group);
    $response->assertViewHas('group.ranks', $this->group->ranks);
});
test('unauthorized user cannot view a rank group', function () {
    $this->signIn();

    $response = $this->get(route('ranks.groups.show', $this->group));
    $response->assertForbidden();
});
test('unauthenticated user cannot view a rank group', function () {
    $response = $this->getJson(route('ranks.groups.show', $this->group));
    $response->assertUnauthorized();
});
