<?php

declare(strict_types=1);

namespace Tests\Unit\Notes\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Notes\Actions\CreateNote;
use Nova\Notes\Data\NoteData;
use Nova\Users\Models\User;
use Tests\TestCase;

/**
 * @group notes
 */
class CreateNoteActionTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function itCreatesANewNote()
    {
        $data = NoteData::from([
            'title' => 'My Note',
            'content' => 'Content of my note',
            'user' => $user = User::factory()->active()->create(),
        ]);

        $note = CreateNote::run($data);

        $this->assertTrue($note->exists);
        $this->assertEquals('My Note', $note->title);
        $this->assertEquals('Content of my note', $note->content);
        $this->assertEquals($user->id, $note->user_id);
    }
}
