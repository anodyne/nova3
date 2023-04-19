<?php

declare(strict_types=1);

namespace Tests\Unit\Posts\Actions;

use Nova\Posts\Actions\SetPostPosition;
use Nova\Posts\Data\PostPositionData;
use Nova\Posts\Models\Post;
use Nova\Stories\Models\Story;
use Tests\TestCase;

/**
 * @group storytelling
 * @group posts
 */
class SetPostPositionActionTest extends TestCase
{
    protected Story $story;

    public function setUp(): void
    {
        parent::setUp();

        $this->story = Story::factory()->create();
    }

    /** @test **/
    public function itCanAddAPostToTheEndOfTheStory()
    {
        $post = Post::factory()->count(5)->withStory($this->story)->create();

        $post = SetPostPosition::run($post, PostPositionData::from([
            'hasPositionChange' => false,
        ]));

        $this->assertEquals($this->story->id, $post->story_id);
        $this->assertEquals(1, $post->order_column);
    }

    /** @test **/
    public function itCanAddAPostBeforeTheFirstPost()
    {
        $posts = Post::factory()->count(2)->withStory($this->story)->create();

        SetPostPosition::run(
            $posts[1],
            PostPositionData::from([
                'hasPositionChange' => true,
                'displayDirection' => 'before',
                'displayNeighbor' => $posts[0]->id,
            ])
        );

        $posts->each->refresh();

        $this->assertEquals(1, $posts[0]->order_column);
        $this->assertEquals(0, $posts[1]->order_column);
    }

    /** @test **/
    public function itCanAddAPostAfterTheFirstPost()
    {
        $posts = Post::factory()
            ->count(2)
            ->withStory($this->story)
            ->create();

        $post = SetPostPosition::run(
            $posts[1],
            PostPositionData::from([
                'hasPositionChange' => true,
                'displayDirection' => 'after',
                'displayNeighbor' => $posts[0]->id,
            ])
        );

        $posts->each->refresh();

        $this->assertTrue($posts[0]->nextSibling()->is($posts[1]));
        $this->assertTrue($posts[1]->previousSibling()->is($posts[0]));
    }

    /** @test **/
    public function itCanMoveAPostBeforeAnotherPost()
    {
        $posts = Post::factory()
            ->count(3)
            ->withStory($this->story)
            ->create();

        $posts->each->refresh();

        $post = SetPostPosition::run(
            $posts[2],
            PostPositionData::from([
                'hasPositionChange' => true,
                'displayDirection' => 'before',
                'displayNeighbor' => $posts[1]->id,
            ])
        );

        $posts->each->refresh();

        $this->assertTrue($posts[0]->nextSibling()->is($posts[2]));
        $this->assertTrue($posts[1]->previousSibling()->is($posts[2]));
        $this->assertTrue($posts[2]->previousSibling()->is($posts[0]));
        $this->assertTrue($posts[2]->nextSibling()->is($posts[1]));
    }

    /** @test **/
    public function itCanMoveAPostAfterAnotherPost()
    {
        $posts = Post::factory()
            ->count(3)
            ->withStory($this->story)
            ->create();

        $posts->each->refresh();

        $post = SetPostPosition::run(
            $posts[2],
            PostPositionData::from([
                'hasPositionChange' => true,
                'displayDirection' => 'after',
                'displayNeighbor' => $posts[0]->id,
            ])
        );

        $posts->each->refresh();

        $this->assertTrue($posts[0]->nextSibling()->is($posts[2]));
        $this->assertTrue($posts[1]->previousSibling()->is($posts[2]));
        $this->assertTrue($posts[2]->previousSibling()->is($posts[0]));
        $this->assertTrue($posts[2]->nextSibling()->is($posts[1]));
    }
}
