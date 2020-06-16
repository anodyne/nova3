<?php

namespace Tests\Unit\Notes\Actions;

use Tests\TestCase;
use Nova\Notes\Models\Note;
use Nova\Notes\Actions\DeleteNote;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteNoteActionTest extends TestCase
{
    use RefreshDatabase;

    protected $action;

    protected $note;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(DeleteNote::class);

        $this->note = create(Note::class);
    }

    /** @test **/
    public function itDeletesANote()
    {
        $note = $this->action->execute($this->note);

        $this->assertFalse($note->exists);
    }
}
