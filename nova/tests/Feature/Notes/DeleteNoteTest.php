<?php

namespace Tests\Feature\Notes;

use Tests\TestCase;
use Nova\Notes\Models\Note;
use Nova\Notes\Events\NoteDeleted;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteNoteTest extends TestCase
{
    use RefreshDatabase;

    protected $note;

    public function setUp(): void
    {
        parent::setUp();

        $this->note = factory(Note::class)->create();
    }

    /** @test **/
    public function userCanDeleteNote()
    {
        $this->signIn($this->note->author);

        $response = $this->delete(route('notes.destroy', $this->note));

        $this->followRedirects($response)->assertOk();

        $this->assertDatabaseMissing('notes', [
            'id' => $this->note->id,
        ]);
    }

    /** @test **/
    public function userCannotDeleteNoteTheyDidNotCreate()
    {
        $this->signIn();

        $response = $this->delete(route('notes.destroy', $this->note));

        $response->assertForbidden();
    }

    /** @test **/
    public function guestCannotDeleteNote()
    {
        $response = $this->delete(route('notes.destroy', $this->note));

        $response->assertRedirect(route('login'));
    }

    /** @test **/
    public function eventIsDispatchedWhenNoteIsDeleted()
    {
        Event::fake();

        $this->signIn($this->note->author);

        $this->delete(route('notes.destroy', $this->note));

        Event::assertDispatched(NoteDeleted::class, function ($event) {
            return $event->note->is($this->note);
        });
    }

    /** @test **/
    public function activityIsLoggedWhenNoteIsDeleted()
    {
        $this->note->delete();

        $this->assertDatabaseHas('activity_log', [
            'description' => $this->note->title . ' note was deleted',
        ]);
    }
}
