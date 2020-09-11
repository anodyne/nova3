<?php

namespace Tests\Unit\Notes\Actions;

use Tests\TestCase;
use Nova\Users\Models\User;
use Nova\Notes\Actions\CreateNote;
use Nova\Notes\DataTransferObjects\NoteData;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @group notes
 */
class CreateNoteActionTest extends TestCase
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
        $data = new NoteData([
            'title' => 'My Note',
            'content' => 'Content of my note',
            'summary' => 'Summary of my note',
            'user' => $user = User::factory()->active()->create(),
        ]);

        $note = $this->action->execute($data);

        $this->assertTrue($note->exists);
        $this->assertEquals('My Note', $note->title);
        $this->assertEquals('Content of my note', $note->content);
        $this->assertEquals('Summary of my note', $note->summary);
        $this->assertEquals($user->id, $note->user_id);
    }
}
