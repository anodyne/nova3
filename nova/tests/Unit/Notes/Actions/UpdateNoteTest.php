<?php

namespace Tests\Unit\Notes\Actions;

use Tests\TestCase;
use Nova\Notes\Models\Note;
use Nova\Notes\Actions\UpdateNote;
use Nova\Notes\DataTransferObjects\NoteData;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateNoteTest extends TestCase
{
    use RefreshDatabase;

    protected $action;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(UpdateNote::class);
    }

    /** @test **/
    public function itUpdatesANote()
    {
        $originalNote = factory(Note::class)->create([
            'title' => 'My First Note',
            'content' => 'Content',
        ]);

        $this->assertEquals('My First Note', $originalNote->title);
        $this->assertEquals('Content', $originalNote->content);

        $data = new NoteData;
        $data->title = 'My Note';
        $data->content = 'Content of my note';

        $note = $this->action->execute($originalNote, $data);

        $this->assertInstanceOf(Note::class, $note);

        $this->assertEquals('My Note', $note->title);
        $this->assertEquals('Content of my note', $note->content);
    }
}
