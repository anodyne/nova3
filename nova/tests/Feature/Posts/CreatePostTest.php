<?php

namespace Tests\Feature\Posts;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Livewire\Livewire;
use Nova\Posts\Actions\CreateRootPost;
use Nova\Posts\Events\PostCreated;
use Nova\Posts\Livewire\ComposePost;
use Nova\PostTypes\Models\PostType;
use Nova\Stories\Models\Story;
use Tests\TestCase;

/**
 * @group posts
 */
class CreatePostTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        app(CreateRootPost::class)->execute(
            Story::factory()->current()->create()
        );
    }

    /** @test **/
    public function authorizedUserCanViewTheCreatePostPage()
    {
        $this->signInWithPermission('post.create');

        $response = $this->get(route('posts.create'));
        $response->assertSuccessful();
        $response->assertSeeLivewire('posts:compose');
    }

    /** @test **/
    public function authorizedUserCanCreateAPost()
    {
        $this->signInWithPermission('post.create');

        Livewire::test(ComposePost::class, [
            'allPostTypes' => $postTypes = PostType::get(),
            'allStories' => Story::wherePostable()->get(),
        ])->set('postType', $postTypes->first())
            ->set('title', 'title')
            ->set('day', 'day')
            ->set('time', 'time')
            ->set('location', 'location')
            ->set('content', 'content')
            ->call('publish');

        $this->assertDatabaseHas('posts', [
            'title' => 'title',
            'day' => 'day',
            'time' => 'time',
            'location' => 'location',
            'content' => 'content',
        ]);
    }

    /** @test **/
    public function eventIsDispatchedWhenPostIsCreated()
    {
        Event::fake();

        $this->signInWithPermission('post.create');

        Livewire::test(ComposePost::class, [
            'allPostTypes' => $postTypes = PostType::get(),
            'allStories' => Story::wherePostable()->get(),
        ])->set('postType', $postTypes->first())
            ->set('title', 'title')
            ->set('day', 'day')
            ->set('time', 'time')
            ->set('location', 'location')
            ->set('content', 'content')
            ->call('publish');

        Event::assertDispatched(PostCreated::class);
    }

    /** @test **/
    public function unauthorizedUserCannotViewTheCreatePostPage()
    {
        $this->signIn();

        $response = $this->get(route('posts.create'));
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthorizedUserCannotCreateAPost()
    {
        $this->signIn();

        Livewire::test(ComposePost::class, [
            'allPostTypes' => $postTypes = PostType::get(),
            'allStories' => Story::wherePostable()->get(),
        ])->set('postType', $postTypes->first())
            ->set('title', 'title')
            ->set('day', 'day')
            ->set('time', 'time')
            ->set('location', 'location')
            ->set('content', 'content')
            ->call('publish')
            ->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotViewTheCreatePostPage()
    {
        $response = $this->getJson(route('posts.create'));
        $response->assertUnauthorized();
    }

    /** @test **/
    public function unauthenticatedUserCannotCreateAPost()
    {
        Livewire::test(ComposePost::class, [
            'allPostTypes' => $postTypes = PostType::get(),
            'allStories' => Story::wherePostable()->get(),
        ])->set('postType', $postTypes->first())
            ->set('title', 'title')
            ->set('day', 'day')
            ->set('time', 'time')
            ->set('location', 'location')
            ->set('content', 'content')
            ->call('publish')
            ->assertForbidden();
    }
}
