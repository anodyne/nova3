<?php

namespace Tests\Unit\Notes\Actions;

use Tests\TestCase;
use Nova\Notes\Models\Note;
use Nova\Notes\Actions\DuplicateNote;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DuplicateNoteTest extends TestCase
{
    use RefreshDatabase;

    protected $action;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(DuplicateNote::class);
    }

    /** @test **/
    public function itDuplicatesANote()
    {
        $originalNote = factory(Note::class)->create([
            'title' => 'My Note',
            'content' => 'Content',
        ]);

        $note = $this->action->execute($originalNote);

        $this->assertInstanceOf(Note::class, $note);

        $this->assertEquals('Copy of My Note', $note->title);
        $this->assertEquals('Content', $note->content);
    }
}
