<?php

namespace Tests\Unit\Posts\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Posts\Actions\SavePost;
use Nova\Posts\DataTransferObjects\PostData;
use Nova\Posts\Models\Post;
use Nova\PostTypes\Models\PostType;
use Nova\Stories\Models\Story;
use Tests\TestCase;

/**
 * @group posts
 */
class SavePostActionTest extends TestCase
{
    use RefreshDatabase;

    protected SavePost $action;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(SavePost::class);
    }

    /** @test **/
    public function itCreatesAPost()
    {
        $data = new PostData([
            'content' => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Blanditiis, tempore? Officia eos iusto vitae cum quam laboriosam blanditiis autem ullam enim eligendi distinctio totam, porro nesciunt a quos, culpa at!',
            'post_type_id' => PostType::factory()->create()->id,
            'story_id' => Story::factory()->create()->id,
            'title' => 'Post Title',
        ]);

        $post = $this->action->execute($data);

        $this->assertTrue($post->exists);

        $this->assertEquals('Post Title', $post->title);
        $this->assertEquals('Lorem, ipsum dolor sit amet consectetur adipisicing elit. Blanditiis, tempore? Officia eos iusto vitae cum quam laboriosam blanditiis autem ullam enim eligendi distinctio totam, porro nesciunt a quos, culpa at!', $post->content);
    }

    /** @test **/
    public function itUpdatesAPostIfOneExists()
    {
        $post = Post::factory()->create([
            'title' => 'Post Title',
        ]);

        $this->assertEquals('Post Title', $post->title);

        $data = new PostData([
            'id' => $post->id,
            'content' => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Blanditiis, tempore? Officia eos iusto vitae cum quam laboriosam blanditiis autem ullam enim eligendi distinctio totam, porro nesciunt a quos, culpa at!',
            'post_type_id' => $post->post_type_id,
            'story_id' => $post->story_id,
            'title' => 'New Post Title',
        ]);

        $newPost = $this->action->execute($data);

        $this->assertEquals('New Post Title', $newPost->title);
        $this->assertEquals($post->id, $newPost->id);
    }

    /** @test **/
    public function itCalculatesTheWordCountWithSimpleContent()
    {
        $data = PostData::fromArray([
            'content' => 'This is my awesome post.',
            'post_type_id' => PostType::first()->id,
            'story_id' => Story::factory()->create()->id,
        ]);

        $this->assertEquals(5, $data->word_count);
    }

    /** @test **/
    public function itCalculatesTheWordCountWithHtmlContent()
    {
        $data = PostData::fromArray([
            'content' => 'This <strong>is</strong> my <span class="font-semibold">awesome</span> post.',
            'post_type_id' => PostType::first()->id,
            'story_id' => Story::factory()->create()->id,
        ]);

        $this->assertEquals(5, $data->word_count);
    }
}
