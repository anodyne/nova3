<?php

namespace Tests\Unit\Posts\Actions;

use Tests\TestCase;
use Nova\Stories\Models\Story;
use Nova\Posts\Actions\CreatePost;
use Nova\PostTypes\Models\PostType;
use Nova\Posts\DataTransferObjects\PostData;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @group posts
 */
class CreatePostActionTest extends TestCase
{
    use RefreshDatabase;

    protected CreatePost $action;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(CreatePost::class);
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
}
