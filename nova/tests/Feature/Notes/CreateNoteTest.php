<?php

namespace Tests\Feature\Notes;

use Tests\TestCase;
use Nova\Notes\Models\Note;
use Nova\Notes\Events\NoteCreated;
use Illuminate\Support\Facades\Event;
use Nova\Notes\Http\Requests\CreateNoteRequest;
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

        $data = make(Note::class, [
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

        $this->post(route('notes.store'), make(Note::class)->toArray());

        Event::assertDispatched(NoteCreated::class);
    }

    /** @test **/
    public function activityIsLoggedWhenNoteIsCreated()
    {
        $note = create(Note::class);

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
            make(Note::class)->toArray()
        );
        $response->assertUnauthorized();
    }
}
