<?php

declare(strict_types=1);

namespace Tests\Feature\Notes;

use Illuminate\Support\Facades\Event;
use Nova\Notes\Events\NoteDuplicated;
use Nova\Notes\Models\Note;
use Tests\TestCase;

/**
 * @group notes
 */
class DuplicateNoteTest extends TestCase
{
    protected $note;

    public function setUp(): void
    {
        parent::setUp();

        $this->note = Note::factory()->create();
    }

    /** @test **/
    public function authenticatedUserCanDuplicateNote()
    {
        $this->signIn($this->note->author);

        $this->followingRedirects();

        $response = $this->post(route('notes.duplicate', $this->note));
        $response->assertSuccessful();

        $this->assertDatabaseHas('notes', [
            'title' => "Copy of {$this->note->title}",
        ]);
    }

    /** @test **/
    public function eventIsDispatchedWhenNoteIsDuplicated()
    {
        Event::fake();

        $this->signIn($this->note->author);

        $this->post(route('notes.duplicate', $this->note));

        Event::assertDispatched(NoteDuplicated::class);
    }

    /** @test **/
    public function authenticatedUserCannotDuplicateNoteTheyDidNotCreate()
    {
        $this->signIn();

        $response = $this->post(route('notes.duplicate', $this->note));
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotDuplicateNote()
    {
        $response = $this->postJson(route('notes.duplicate', $this->note));
        $response->assertUnauthorized();
    }
}
