<?php

namespace Tests\Feature\Notes;

use Tests\TestCase;
use Nova\Notes\Models\Note;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @group notes
 */
class ShowNoteTest extends TestCase
{
    use RefreshDatabase;

    protected $note;

    public function setUp(): void
    {
        parent::setUp();

        $this->note = Note::factory()->create();
    }

    /** @test **/
    public function authenticatedUserCanViewOneOfTheirNotes()
    {
        $this->signIn();

        $note = Note::factory()->create([
            'user_id' => auth()->user(),
        ]);

        $response = $this->get(route('notes.show', $note));
        $response->assertSuccessful();
        $response->assertViewHas('note', $note);
    }

    /** @test **/
    public function authenticatedUserCannotViewANoteTheyDidNotCreate()
    {
        $this->signIn();

        $response = $this->get(route('notes.show', $this->note));
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotViewANote()
    {
        $response = $this->getJson(route('notes.show', $this->note));
        $response->assertUnauthorized();
    }
}
