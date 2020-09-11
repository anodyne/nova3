<?php

namespace Tests\Feature\Notes;

use Tests\TestCase;
use Nova\Notes\Models\Note;
use Nova\Notes\Events\NoteCreated;
use Illuminate\Support\Facades\Event;
use Nova\Notes\Requests\CreateNoteRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @group notes
 */
class CreateNoteTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function authenticatedUserCanViewTheCreateNotePage()
    {
        $this->signIn();

        $response = $this->get(route('notes.create'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function authenticatedUserCanCreateNote()
    {
        $this->signIn();

        $data = Note::factory()->make([
            'user_id' => auth()->id(),
        ]);

        $this->followingRedirects();

        $response = $this->post(route('notes.store'), $data->toArray());
        $response->assertSuccessful();

        $this->assertRouteUsesFormRequest(
            'notes.store',
            CreateNoteRequest::class
        );

        $this->assertDatabaseHas('notes', [
            'user_id' => auth()->id(),
            'title' => $data->title,
            'content' => $data->content,
            'summary' => $data->summary,
        ]);
    }

    /** @test **/
    public function eventIsDispatchedWhenNoteIsCreated()
    {
        Event::fake();

        $this->signIn();

        $this->post(route('notes.store'), Note::factory()->make()->toArray());

        Event::assertDispatched(NoteCreated::class);
    }

    /** @test **/
    public function unauthenticatedUserCannotViewCreateNotePage()
    {
        $response = $this->getJson(route('notes.create'));
        $response->assertUnauthorized();
    }

    /** @test **/
    public function unauthenticatedUserCannotCreateNote()
    {
        $response = $this->postJson(
            route('notes.store'),
            Note::factory()->make()->toArray()
        );
        $response->assertUnauthorized();
    }
}
