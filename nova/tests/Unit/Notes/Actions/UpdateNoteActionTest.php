<?php

namespace Tests\Unit\Notes\Actions;

use Tests\TestCase;
use Nova\Notes\Models\Note;
use Nova\Notes\Actions\UpdateNote;
use Nova\Notes\DataTransferObjects\NoteData;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @group notes
 */
class UpdateNoteActionTest extends TestCase
{
    use RefreshDatabase;

    protected $action;

    protected $note;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(UpdateNote::class);

        $this->note = create(Note::class, [
            'title' => 'My First Note',
            'content' => 'Content',
            'summary' => 'Summary',
        ]);
    }

    /** @test **/
    public function itUpdatesANote()
    {
        $data = new NoteData([
            'title' => 'My Note',
            'content' => 'New content',
            'summary' => 'New summary',
        ]);

        $note = $this->action->execute($this->note, $data);

        $this->assertEquals('My Note', $note->title);
        $this->assertEquals('New content', $note->content);
        $this->assertEquals('New summary', $note->summary);
    }
}
