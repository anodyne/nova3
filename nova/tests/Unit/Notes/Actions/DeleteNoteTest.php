<?php

namespace Tests\Unit\Notes\Actions;

use Tests\TestCase;
use Nova\Notes\Models\Note;
use Nova\Notes\Actions\DeleteNote;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteNoteTest extends TestCase
{
    use RefreshDatabase;

    protected $action;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(DeleteNote::class);
    }

    /** @test **/
    public function itDeletesANote()
    {
        $note = factory(Note::class)->create();

        $note = $this->action->execute($note);

        $this->assertInstanceOf(Note::class, $note);
    }
}
