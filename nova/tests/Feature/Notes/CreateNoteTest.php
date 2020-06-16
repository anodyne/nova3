<?php

namespace Tests\Feature\Notes;

use Tests\TestCase;
use Nova\Notes\Models\Note;
use Nova\Notes\Events\NoteCreated;
use Illuminate\Support\Facades\Event;
use Nova\Notes\Http\Requests\CreateNoteRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;

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

        $data = factory(Note::class)->make([
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

        $this->post(route('notes.store'), factory(Note::class)->make()->toArray());

        Event::assertDispatched(NoteCreated::class);
    }

    /** @test **/
    public function activityIsLoggedWhenNoteIsCreated()
    {
        $note = factory(Note::class)->create();

        $this->assertDatabaseHas('activity_log', [
            'description' => $note->title . ' note was created',
        ]);
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
            factory(Note::class)->make()->toArray()
        );
        $response->assertUnauthorized();
    }
}
