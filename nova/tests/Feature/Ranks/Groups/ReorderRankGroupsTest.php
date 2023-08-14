<?php

declare(strict_types=1);
use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Ranks\Models\RankGroup;
beforeEach(function () {
    $this->group1 = RankGroup::factory()->create(['sort' => 0]);
    $this->group2 = RankGroup::factory()->create(['sort' => 1]);
    $this->group3 = RankGroup::factory()->create(['sort' => 2]);
});
test('authorized user can reorder rank groups', function () {
    $this->signInWithPermission('rank.update');

    $this->followingRedirects();

    $response = $this->post(
        route('ranks.groups.reorder'),
        [
            'sort' => implode(',', [
                $this->group3->id,
                $this->group2->id,
                $this->group1->id,
            ]),
        ]
    );
    $response->assertSuccessful();

    $this->group1->fresh();
    $this->group2->fresh();
    $this->group3->fresh();

    $this->assertDatabaseHas('rank_groups', [
        'id' => $this->group1->id,
        'sort' => 2,
    ]);
    $this->assertDatabaseHas('rank_groups', [
        'id' => $this->group2->id,
        'sort' => 1,
    ]);
    $this->assertDatabaseHas('rank_groups', [
        'id' => $this->group3->id,
        'sort' => 0,
    ]);
});
test('unauthorized user cannot reorder rank groups', function () {
    $this->signIn();

    $response = $this->post(
        route('ranks.groups.reorder'),
        [
            'sort' => implode(',', [
                $this->group3->id,
                $this->group2->id,
                $this->group1->id,
            ]),
        ]
    );
    $response->assertForbidden();
});
test('unauthenticated user cannot reorder rank groups', function () {
    $response = $this->postJson(
        route('ranks.groups.reorder'),
        [
            'sort' => implode(',', [
                $this->group3->id,
                $this->group2->id,
                $this->group1->id,
            ]),
        ]
    );
    $response->assertUnauthorized();
});
