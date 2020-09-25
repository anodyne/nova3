<?php

namespace Tests\Unit\Posts\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Posts\Actions\CreateRootPost;
use Nova\Posts\Actions\SetPostPosition;
use Nova\Posts\DataTransferObjects\PostPositionData;
use Nova\Posts\Models\Post;
use Nova\Stories\Models\Story;
use Tests\TestCase;

/**
 * @group posts
 */
class SetPostPositionActionTest extends TestCase
{
    use RefreshDatabase;

    protected SetPostPosition $action;

    protected Post $rootPost;

    protected Story $story;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(SetPostPosition::class);

        $this->story = Story::factory()->create();

        $this->rootPost = app(CreateRootPost::class)->execute($this->story);
    }

    /** @test **/
    public function itCanAddAPostToTheEndOfTheStory()
    {
        $post = Post::factory()->create([
            'story_id' => $this->story->id,
        ]);

        $post = $this->action->execute($post, new PostPositionData([
            'hasPositionChange' => false,
        ]));

        $this->assertEquals($this->rootPost->id, $post->parent_id);
        $this->assertEquals(2, $post->_lft);
    }

    /** @test **/
    public function itCanAddAPostBeforeTheFirstPost()
    {
        $posts = Post::factory()
            ->count(2)
            ->create([
                'story_id' => $this->story->id,
            ]);

        $posts[0]->appendToNode($this->rootPost)->save();

        $post = $this->action->execute(
            $posts[1],
            new PostPositionData([
                'hasPositionChange' => true,
                'direction' => 'before',
                'neighbor' => $posts[0],
            ])
        );

        $posts->each->refresh();

        $this->assertEquals($this->rootPost->id, $posts[0]->parent_id);
        $this->assertEquals(4, $posts[0]->_lft);

        $this->assertEquals($this->rootPost->id, $posts[1]->parent_id);
        $this->assertEquals(2, $posts[1]->_lft);
    }

    /** @test **/
    public function itCanAddAPostAfterTheFirstPost()
    {
        $posts = Post::factory()
            ->count(2)
            ->create([
                'story_id' => $this->story->id,
            ]);

        $posts[0]->appendToNode($this->rootPost)->save();

        $post = $this->action->execute(
            $posts[1],
            new PostPositionData([
                'hasPositionChange' => true,
                'direction' => 'after',
                'neighbor' => $posts[0],
            ])
        );

        $posts->each->refresh();

        $this->assertEquals($this->rootPost->id, $posts[0]->parent_id);
        $this->assertEquals(2, $posts[0]->_lft);

        $this->assertEquals($this->rootPost->id, $posts[1]->parent_id);
        $this->assertEquals(4, $posts[1]->_lft);
    }

    /** @test **/
    public function itCanMoveAPostBeforeAnotherPost()
    {
        $posts = Post::factory()
            ->count(3)
            ->create([
                'story_id' => $this->story->id,
            ]);

        $posts[0]->appendToNode($this->rootPost)->save();
        $posts[1]->appendToNode($this->rootPost)->save();
        $posts->each->refresh();

        $post = $this->action->execute(
            $posts[2],
            new PostPositionData([
                'hasPositionChange' => true,
                'direction' => 'before',
                'neighbor' => $posts[1],
            ])
        );

        $posts->each->refresh();

        $this->assertEquals($this->rootPost->id, $posts[0]->parent_id);
        $this->assertEquals(2, $posts[0]->_lft);

        $this->assertEquals($this->rootPost->id, $posts[1]->parent_id);
        $this->assertEquals(6, $posts[1]->_lft);

        $this->assertEquals($this->rootPost->id, $posts[2]->parent_id);
        $this->assertEquals(4, $posts[2]->_lft);
    }

    /** @test **/
    public function itCanMoveAPostAfterAnotherPost()
    {
        $posts = Post::factory()
            ->count(3)
            ->create([
                'story_id' => $this->story->id,
            ]);

        $posts[0]->appendToNode($this->rootPost)->save();
        $posts[1]->appendToNode($this->rootPost)->save();
        $posts->each->refresh();

        $post = $this->action->execute(
            $posts[2],
            new PostPositionData([
                'hasPositionChange' => true,
                'direction' => 'after',
                'neighbor' => $posts[0],
            ])
        );

        $posts->each->refresh();

        $this->assertEquals($this->rootPost->id, $posts[0]->parent_id);
        $this->assertEquals(2, $posts[0]->_lft);

        $this->assertEquals($this->rootPost->id, $posts[1]->parent_id);
        $this->assertEquals(6, $posts[1]->_lft);

        $this->assertEquals($this->rootPost->id, $posts[2]->parent_id);
        $this->assertEquals(4, $posts[2]->_lft);
    }
}
