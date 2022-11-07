<?php

declare(strict_types=1);

namespace Tests\Unit\Notes\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Notes\Actions\UpdateNote;
use Nova\Notes\Data\NoteData;
use Nova\Notes\Models\Note;
use Tests\TestCase;

/**
 * @group notes
 */
class UpdateNoteActionTest extends TestCase
{
    use RefreshDatabase;

    protected $note;

    public function setUp(): void
    {
        parent::setUp();

        $this->note = Note::factory()->create([
            'title' => 'My First Note',
            'content' => 'Content',
        ]);
    }

    /** @test **/
    public function itUpdatesANote()
    {
        $data = NoteData::from([
            'title' => 'My Note',
            'content' => 'New content',
        ]);

        $note = UpdateNote::run($this->note, $data);

        $this->assertEquals('My Note', $note->title);
        $this->assertEquals('New content', $note->content);
    }
}
