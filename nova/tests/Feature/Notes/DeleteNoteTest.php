<?php

namespace Tests\Feature\Notes;

use Tests\TestCase;
use Nova\Notes\Models\Note;
use Nova\Notes\Events\NoteDeleted;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @group notes
 */
class DeleteNoteTest extends TestCase
{
    use RefreshDatabase;

    protected $note;

    public function setUp(): void
    {
        parent::setUp();

        $this->note = Note::factory()->create();
    }

    /** @test **/
    public function authenticatedUserCanDeleteNote()
    {
        $this->signIn($this->note->author);

        $this->followingRedirects();

        $response = $this->delete(route('notes.destroy', $this->note));
        $response->assertSuccessful();

        $this->assertDatabaseMissing('notes', [
            'id' => $this->note->id,
        ]);
    }

    /** @test **/
    public function eventIsDispatchedWhenNoteIsDeleted()
    {
        Event::fake();

        $this->signIn($this->note->author);

        $this->delete(route('notes.destroy', $this->note));

        Event::assertDispatched(NoteDeleted::class);
    }

    /** @test **/
    public function authenticatedUserCannotDeleteNoteTheyDidNotCreate()
    {
        $this->signIn();

        $response = $this->delete(route('notes.destroy', $this->note));
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotDeleteNote()
    {
        $response = $this->deleteJson(route('notes.destroy', $this->note));
        $response->assertUnauthorized();
    }
}
