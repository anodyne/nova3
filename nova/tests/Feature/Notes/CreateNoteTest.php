<?php

namespace Tests\Feature\Notes;

use Tests\TestCase;
use Nova\Notes\Models\Note;
use Nova\Notes\Events\NoteCreated;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateNoteTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function userCanCreateANote()
    {
        $this->signIn();

        $response = $this->get(route('notes.create'));
        $response->assertOk();

        $data = factory(Note::class)->make([
            'user_id' => auth()->id(),
        ]);

        $this->followingRedirects();

        $response = $this->post(route('notes.store'), $data->toArray());
        $response->assertOk();

        $this->assertDatabaseHas('notes', [
            'user_id' => auth()->id(),
            'title' => $data->title,
            'content' => $data->content,
        ]);
    }

    /** @test **/
    public function guestCannotCreateRole()
    {
        $response = $this->get(route('notes.create'));
        $response->assertRedirect(route('login'));

        $response = $this->post(route('notes.store'), []);
        $response->assertRedirect(route('login'));
    }

    /** @test **/
    public function eventIsDispatchedWhenNoteIsCreated()
    {
        Event::fake();

        $this->signIn();

        $this->post(route('notes.store'), factory(Note::class)->make()->toArray());

        $note = Note::get()->last();

        Event::assertDispatched(NoteCreated::class, function ($event) use ($note) {
            return $event->note->is($note);
        });
    }

    /** @test **/
    public function titleIsRequiredToCreateNote()
    {
        $this->signIn();

        $response = $this->postJson(route('notes.store'), [
            'content' => 'Foo',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('title');
    }

    /** @test **/
    public function activityIsLoggedWhenNoteIsCreated()
    {
        $note = factory(Note::class)->create();

        $this->assertDatabaseHas('activity_log', [
            'description' => $note->title . ' note was created',
        ]);
    }
}
