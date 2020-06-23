<?php

namespace Tests\Unit\Notes\Actions;

use Tests\TestCase;
use Nova\Notes\Models\Note;
use Nova\Notes\Actions\DuplicateNote;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @group notes
 */
class DuplicateNoteActionTest extends TestCase
{
    use RefreshDatabase;

    protected $action;

    protected $originalNote;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(DuplicateNote::class);

        $this->originalNote = create(Note::class, [
            'title' => 'My Note',
            'content' => 'Content',
            'summary' => 'Summary',
        ]);
    }

    /** @test **/
    public function itDuplicatesANote()
    {
        $note = $this->action->execute($this->originalNote);

        $this->assertEquals('Copy of My Note', $note->title);
        $this->assertEquals('Content', $note->content);
        $this->assertEquals('Summary', $note->summary);
    }
}
