<?php

namespace Tests\Feature\Posts;

use Tests\TestCase;
use Nova\Posts\Models\Post;
use Nova\Posts\Events\PostCreated;
use Illuminate\Support\Facades\Event;
use Nova\Posts\Requests\CreatePostRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @group posts
 */
class CreatePostTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function authorizedUserCanViewTheCreatePostPage()
    {
        $this->signInWithPermission('post.create');

        $response = $this->get(route('posts.create'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserCanCreateAPost()
    {
        $this->signInWithPermission('post.create');

        $post = Post::factory()->make();

        $this->followingRedirects();

        $response = $this->post(
            route('posts.store'),
            $post->toArray()
        );
        $response->assertSuccessful();

        $this->assertDatabaseHas('posts', $post->only('title', 'content'));

        $this->assertRouteUsesFormRequest(
            'posts.store',
            CreatePostRequest::class
        );
    }

    /** @test **/
    public function creatingAPostCalculatesItsWordCount()
    {
        $this->signInWithPermission('post.create');

        $post = Post::factory()->make([
            'content' => 'This is my awesome post.',
        ]);

        $this->followingRedirects();

        $response = $this->post(
            route('posts.store'),
            $post->toArray()
        );
        $response->assertSuccessful();

        $this->assertDatabaseHas('posts', [
            'word_count' => 5,
        ]);
    }

    /** @test **/
    public function creatingAPostWithHtmlContentCalculatesItsWordCount()
    {
        $this->signInWithPermission('post.create');

        $post = Post::factory()->make([
            'content' => 'This <strong>is</strong> my <span class="font-semibold">awesome</span> post.',
        ]);

        $this->followingRedirects();

        $response = $this->post(
            route('posts.store'),
            $post->toArray()
        );
        $response->assertSuccessful();

        $this->assertDatabaseHas('posts', [
            'word_count' => 5,
        ]);
    }

    /** @test **/
    public function eventIsDispatchedWhenPostIsCreated()
    {
        Event::fake();

        $this->signInWithPermission('post.create');

        $this->post(
            route('posts.store'),
            Post::factory()->make()->toArray()
        );

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

        $response = $this->postJson(
            route('posts.store'),
            Post::factory()->make()->toArray()
        );
        $response->assertForbidden();
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
        $response = $this->postJson(
            route('posts.store'),
            Post::factory()->make()->toArray()
        );
        $response->assertUnauthorized();
    }
}
