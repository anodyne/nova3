<?php

declare(strict_types=1);

namespace Tests\Unit\Notes\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Notes\Actions\DeleteNote;
use Nova\Notes\Models\Note;
use Tests\TestCase;

/**
 * @group notes
 */
class DeleteNoteActionTest extends TestCase
{
    use RefreshDatabase;

    protected $note;

    public function setUp(): void
    {
        parent::setUp();

        $this->note = Note::factory()->create();
    }

    /** @test **/
    public function itDeletesANote()
    {
        $note = DeleteNote::run($this->note);

        $this->assertFalse($note->exists);
    }
}
