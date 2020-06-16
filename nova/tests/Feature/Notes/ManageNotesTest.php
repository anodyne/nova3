<?php

namespace Tests\Feature\Notes;

use Tests\TestCase;
use Nova\Notes\Models\Note;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageNotesTest extends TestCase
{
    use RefreshDatabase;

    protected $note;

    public function setUp(): void
    {
        parent::setUp();

        $this->note = create(Note::class);
    }

    /** @test **/
    public function authenticatedUserCanSeeTheirNotes()
    {
        $this->signIn($this->note->author);

        $response = $this->get(route('notes.index'));
        $response->assertSuccessful();

        $this->assertCount(1, $response['notes']);
    }

    /** @test **/
    public function authenticatedUserCannotSeeNotesTheyDidNotCreate()
    {
        $this->signIn();

        $note = create(Note::class, [
            'user_id' => auth()->user(),
        ]);

        $response = $this->get(route('notes.index'));
        $response->assertSuccessful();

        $this->assertEquals(2, Note::count());
        $this->assertCount(1, $response['notes']);
    }

    /** @test **/
    public function notesCanBeFilteredByTitle()
    {
        $this->signIn($this->note->author);

        create(Note::class, [
            'user_id' => auth()->user(),
            'title' => 'Foo',
        ]);

        $response = $this->get(route('notes.index', 'search=foo'));
        $response->assertSuccessful();

        $this->assertCount(1, $response['notes']);
    }

    /** @test **/
    public function notesCanBeFilteredByContent()
    {
        $this->signIn($this->note->author);

        create(Note::class, [
            'user_id' => auth()->user(),
            'content' => 'foobar',
        ]);

        $response = $this->get(route('notes.index', 'search=foobar'));
        $response->assertSuccessful();

        $this->assertCount(1, $response['notes']);
    }

    /** @test **/
    public function notesCanBeFilteredBySummary()
    {
        $this->signIn($this->note->author);

        create(Note::class, [
            'user_id' => auth()->user(),
            'summary' => 'barbaz',
        ]);

        $response = $this->get(route('notes.index', 'search=barbaz'));
        $response->assertSuccessful();

        $this->assertCount(1, $response['notes']);
    }

    /** @test **/
    public function unauthenticatedUserCannotSeeAnyNotes()
    {
        $response = $this->getJson(route('notes.index'));
        $response->assertUnauthorized();
    }
}
