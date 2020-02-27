<?php

namespace Tests\Feature\Notes;

use Tests\TestCase;
use Nova\Notes\Models\Note;
use Nova\Notes\Events\NoteUpdated;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateNoteTest extends TestCase
{
    use RefreshDatabase;

    protected $note;

    public function setUp(): void
    {
        parent::setUp();

        $this->note = factory(Note::class)->create();
    }

    /** @test **/
    public function userCanUpdateNote()
    {
        $this->signIn($this->note->author);

        $response = $this->get(route('notes.edit', $this->note));
        $response->assertOk();

        $data = [
            'id' => $this->note->id,
            'title' => 'New Title',
            'content' => 'New content',
        ];

        $response = $this->put(route('notes.update', $this->note), $data);

        $this->followRedirects($response)->assertOk();

        $this->assertDatabaseHas('notes', [
            'id' => $this->note->id,
            'title' => 'New Title',
            'content' => 'New content',
        ]);
    }

    /** @test **/
    public function userCannotUpdateNoteTheyDidNotCreate()
    {
        $this->signIn();

        $response = $this->get(route('notes.edit', $this->note));
        $response->assertForbidden();

        $response = $this->put(route('notes.update', $this->note), []);
        $response->assertForbidden();
    }

    /** @test **/
    public function guestCannotUpdateNote()
    {
        $response = $this->get(route('notes.edit', $this->note));
        $response->assertRedirect(route('login'));

        $response = $this->put(route('notes.update', $this->note), []);
        $response->assertRedirect(route('login'));
    }

    /** @test **/
    public function eventIsDispatchedWhenNoteIsUpdated()
    {
        Event::fake();

        $this->signIn($this->note->author);

        $this->put(route('notes.update', $this->note), [
            'id' => $this->note->id,
            'title' => 'New Title',
            'content' => 'New content',
        ]);

        $note = $this->note->refresh();

        Event::assertDispatched(NoteUpdated::class, function ($event) use ($note) {
            return $event->note->is($note);
        });
    }

    /** @test **/
    public function activityIsLoggedWhenNoteIsUpdated()
    {
        $this->note->update([
            'title' => 'Foo',
        ]);

        $this->assertDatabaseHas('activity_log', [
            'description' => $this->note->title . ' note was updated',
        ]);
    }

    /** @test **/
    public function titleIsRequiredToUpdateNote()
    {
        $this->signIn($this->note->author);

        $response = $this->putJson(route('notes.update', $this->note), [
            'content' => 'Foo',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('title');
    }
}
