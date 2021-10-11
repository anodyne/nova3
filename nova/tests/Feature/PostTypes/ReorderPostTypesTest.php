<?php

declare(strict_types=1);

namespace Tests\Feature\PostTypes;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\PostTypes\Models\PostType;
use Tests\TestCase;

/**
 * @group stories
 * @group post-types
 */
class ReorderPostTypesTest extends TestCase
{
    use RefreshDatabase;

    protected $postType1;

    protected $postType2;

    protected $postType3;

    public function setUp(): void
    {
        parent::setUp();

        $this->postType1 = PostType::factory()->create(['name' => 'One', 'sort' => 0]);
        $this->postType2 = PostType::factory()->create(['name' => 'Two', 'sort' => 1]);
        $this->postType3 = PostType::factory()->create(['name' => 'Three', 'sort' => 2]);
    }

    /** @test **/
    public function authorizedUserCanReorderPostTypes()
    {
        $this->signInWithPermission('story.update');

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
    }

    /** @test **/
    public function unauthorizedUserCannotReorderPostTypes()
    {
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
    }

    /** @test **/
    public function unauthenticatedUserCannotReorderPostTypes()
    {
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
    }
}
