<?php

declare(strict_types=1);
use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Ranks\Models\RankName;
beforeEach(function () {
    $this->name1 = RankName::factory()->create(['sort' => 0]);
    $this->name2 = RankName::factory()->create(['sort' => 1]);
    $this->name3 = RankName::factory()->create(['sort' => 2]);
});
test('authorized user can reorder rank names', function () {
    $this->signInWithPermission('rank.update');

    $this->followingRedirects();

    $response = $this->post(
        route('ranks.names.reorder'),
        [
            'sort' => implode(',', [
                $this->name3->id,
                $this->name2->id,
                $this->name1->id,
            ]),
        ]
    );
    $response->assertSuccessful();

    $this->name1->fresh();
    $this->name2->fresh();
    $this->name3->fresh();

    $this->assertDatabaseHas('rank_names', [
        'id' => $this->name1->id,
        'sort' => 2,
    ]);
    $this->assertDatabaseHas('rank_names', [
        'id' => $this->name2->id,
        'sort' => 1,
    ]);
    $this->assertDatabaseHas('rank_names', [
        'id' => $this->name3->id,
        'sort' => 0,
    ]);
});
test('unauthorized user cannot reorder rank names', function () {
    $this->signIn();

    $response = $this->post(
        route('ranks.names.reorder'),
        [
            'sort' => implode(',', [
                $this->name3->id,
                $this->name2->id,
                $this->name1->id,
            ]),
        ]
    );
    $response->assertForbidden();
});
test('unauthenticated user cannot reorder rank names', function () {
    $response = $this->postJson(
        route('ranks.names.reorder'),
        [
            'sort' => implode(',', [
                $this->name3->id,
                $this->name2->id,
                $this->name1->id,
            ]),
        ]
    );
    $response->assertUnauthorized();
});
