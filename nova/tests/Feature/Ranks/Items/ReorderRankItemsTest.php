<?php

declare(strict_types=1);
use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Ranks\Models\RankItem;
beforeEach(function () {
    $this->item1 = RankItem::factory()->create(['sort' => 0]);
    $this->item2 = RankItem::factory()->create(['sort' => 1]);
    $this->item3 = RankItem::factory()->create(['sort' => 2]);
});
test('authorized user can reorder rank items', function () {
    $this->signInWithPermission('rank.update');

    $this->followingRedirects();

    $response = $this->post(
        route('ranks.items.reorder'),
        [
            'sort' => implode(',', [
                $this->item3->id,
                $this->item2->id,
                $this->item1->id,
            ]),
        ]
    );
    $response->assertSuccessful();

    $this->item1->fresh();
    $this->item2->fresh();
    $this->item3->fresh();

    $this->assertDatabaseHas('rank_items', [
        'id' => $this->item1->id,
        'sort' => 2,
    ]);
    $this->assertDatabaseHas('rank_items', [
        'id' => $this->item2->id,
        'sort' => 1,
    ]);
    $this->assertDatabaseHas('rank_items', [
        'id' => $this->item3->id,
        'sort' => 0,
    ]);
});
test('unauthorized user cannot reorder rank items', function () {
    $this->signIn();

    $response = $this->post(
        route('ranks.items.reorder'),
        [
            'sort' => implode(',', [
                $this->item3->id,
                $this->item2->id,
                $this->item1->id,
            ]),
        ]
    );
    $response->assertForbidden();
});
test('unauthenticated user cannot reorder rank items', function () {
    $response = $this->postJson(
        route('ranks.items.reorder'),
        [
            'sort' => implode(',', [
                $this->item3->id,
                $this->item2->id,
                $this->item1->id,
            ]),
        ]
    );
    $response->assertUnauthorized();
});
