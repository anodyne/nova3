<?php

declare(strict_types=1);

namespace Tests\Unit\Notes\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Notes\Actions\DuplicateNote;
use Nova\Notes\Models\Note;
use Tests\TestCase;

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

        $this->originalNote = Note::factory()->create([
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
