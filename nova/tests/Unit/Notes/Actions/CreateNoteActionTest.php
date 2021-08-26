<?php

declare(strict_types=1);

namespace Tests\Unit\Notes\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Notes\Actions\CreateNote;
use Nova\Notes\DataTransferObjects\NoteData;
use Nova\Users\Models\User;
use Tests\TestCase;

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
