<?php

namespace Tests\Unit\Notes\Actions;

use Tests\TestCase;
use Nova\Notes\Models\Note;
use Nova\Users\Models\User;
use Nova\Notes\Actions\CreateNote;
use Nova\Notes\DataTransferObjects\NoteData;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateNoteTest extends TestCase
{
    use RefreshDatabase;

    protected $action;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(CreateNote::class);
    }

    /** @test **/
    public function itCreatesANewNote()
    {
        $data = new NoteData;
        $data->title = 'My Note';
        $data->content = 'Content of my note';
        $data->user_id = factory(User::class)->create()->id;

        $note = $this->action->execute($data);

        $this->assertInstanceOf(Note::class, $note);

        $this->assertEquals('My Note', $note->title);
        $this->assertEquals('Content of my note', $note->content);
    }
}
