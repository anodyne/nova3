<?php

declare(strict_types=1);

namespace Tests\Feature\Notes;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Notes\Models\Note;
use Tests\TestCase;

/**
 * @group notes
 */
class ManageNotesTest extends TestCase
{
    use RefreshDatabase;

    protected $note;

    public function setUp(): void
    {
        parent::setUp();

        $this->note = Note::factory()->create();
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

        $note = Note::factory()->create([
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

        Note::factory()->create([
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

        Note::factory()->create([
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

        Note::factory()->create([
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
