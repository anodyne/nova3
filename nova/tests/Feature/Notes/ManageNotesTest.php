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

        $this->note = factory(Note::class)->create();
    }

    /** @test **/
    public function userCanSeeTheirNotes()
    {
        $this->signIn($this->note->author);

        $response = $this->get(route('notes.index'));
        $response->assertOk();

        $this->assertCount(1, $response['notes']);
    }

    /** @test **/
    public function userCannotSeeNotesTheyDidNotCreate()
    {
        $this->signIn();

        $response = $this->get(route('notes.index'));
        $response->assertOk();

        $this->assertCount(0, $response['notes']);
    }

    /** @test **/
    public function notesCanBeFilteredByTitle()
    {
        $this->signIn($this->note->author);

        factory(Note::class)->create([
            'user_id' => auth()->id(),
            'title' => 'Foo',
        ]);

        $response = $this->get(route('notes.index') . '?search=foo');
        $response->assertOk();

        $this->assertCount(1, $response['notes']);
    }

    /** @test **/
    public function notesCanBeFilteredByContent()
    {
        $this->signIn($this->note->author);

        factory(Note::class)->create([
            'user_id' => auth()->id(),
            'content' => 'foo',
        ]);

        $response = $this->get(route('notes.index') . '?search=foo');
        $response->assertOk();

        $this->assertCount(1, $response['notes']);
    }
}
