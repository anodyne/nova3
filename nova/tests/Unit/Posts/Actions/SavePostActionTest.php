<?php

declare(strict_types=1);

namespace Tests\Unit\Posts\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Posts\Actions\SavePost;
use Nova\Posts\Data\PostData;
use Nova\Posts\Models\Post;
use Nova\PostTypes\Models\PostType;
use Nova\Stories\Models\Story;
use Tests\TestCase;

/**
 * @group storytelling
 * @group posts
 */
class SavePostActionTest extends TestCase
{
    /** @test **/
    public function itCreatesAPost()
    {
        $data = PostData::from([
            'content' => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Blanditiis, tempore? Officia eos iusto vitae cum quam laboriosam blanditiis autem ullam enim eligendi distinctio totam, porro nesciunt a quos, culpa at!',
            'postTypeId' => PostType::factory()->create()->id,
            'storyId' => Story::factory()->create()->id,
            'title' => 'Post Title',
        ]);

        $post = SavePost::run($data);

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

        $data = PostData::from([
            'id' => $post->id,
            'content' => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Blanditiis, tempore? Officia eos iusto vitae cum quam laboriosam blanditiis autem ullam enim eligendi distinctio totam, porro nesciunt a quos, culpa at!',
            'postTypeId' => $post->post_type_id,
            'storyId' => $post->story_id,
            'title' => 'New Post Title',
        ]);

        $newPost = SavePost::run($data);

        $this->assertEquals('New Post Title', $newPost->title);
        $this->assertEquals($post->id, $newPost->id);
    }

    /** @test **/
    public function itCalculatesTheWordCountWithSimpleContent()
    {
        $data = PostData::from([
            'content' => 'This is my awesome post.',
            'postTypeId' => PostType::first()->id,
            'storyId' => Story::factory()->create()->id,
        ]);

        $this->assertEquals(5, $data->word_count);
    }

    /** @test **/
    public function itCalculatesTheWordCountWithHtmlContent()
    {
        $data = PostData::from([
            'content' => 'This <strong>is</strong> my <span class="font-semibold">awesome</span> post.',
            'postTypeId' => PostType::first()->id,
            'storyId' => Story::factory()->create()->id,
        ]);

        $this->assertEquals(5, $data->word_count);
    }
}
