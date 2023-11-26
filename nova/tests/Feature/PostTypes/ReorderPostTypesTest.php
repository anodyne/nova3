<?php

declare(strict_types=1);
use Nova\Stories\Models\PostType;

beforeEach(function () {
    $this->postType1 = PostType::factory()->create(['name' => 'One', 'sort' => 0]);
    $this->postType2 = PostType::factory()->create(['name' => 'Two', 'sort' => 1]);
    $this->postType3 = PostType::factory()->create(['name' => 'Three', 'sort' => 2]);
});
test('authorized user can reorder post types', function () {
    $this->signInWithPermission('post-type.update');

    $this->followingRedirects();

    $response = $this->post(
        route('post-types.reorder'),
        [
            'sort' => implode(',', [
                $this->postType3->id,
                $this->postType2->id,
                $this->postType1->id,
            ]),
        ]
    );
    $response->assertSuccessful();

    $this->postType1->fresh();
    $this->postType2->fresh();
    $this->postType3->fresh();

    $this->assertDatabaseHas('post_types', [
        'id' => $this->postType1->id,
        'sort' => 2,
    ]);
    $this->assertDatabaseHas('post_types', [
        'id' => $this->postType2->id,
        'sort' => 1,
    ]);
    $this->assertDatabaseHas('post_types', [
        'id' => $this->postType3->id,
        'sort' => 0,
    ]);
});
test('unauthorized user cannot reorder post types', function () {
    $this->signIn();

    $response = $this->post(
        route('post-types.reorder'),
        [
            'sort' => implode(',', [
                $this->postType3->id,
                $this->postType2->id,
                $this->postType1->id,
            ]),
        ]
    );
    $response->assertForbidden();
});
test('unauthenticated user cannot reorder post types', function () {
    $response = $this->postJson(
        route('post-types.reorder'),
        [
            'sort' => implode(',', [
                $this->postType3->id,
                $this->postType2->id,
                $this->postType1->id,
            ]),
        ]
    );
    $response->assertUnauthorized();
});
