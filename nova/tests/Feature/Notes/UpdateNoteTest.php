<?php

declare(strict_types=1);

namespace Tests\Feature\Notes;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Nova\Notes\Events\NoteUpdated;
use Nova\Notes\Models\Note;
use Nova\Notes\Requests\UpdateNoteRequest;
use Tests\TestCase;

/**
 * @group notes
 */
class UpdateNoteTest extends TestCase
{
    use RefreshDatabase;

    protected $note;

    public function setUp(): void
    {
        parent::setUp();

        $this->note = Note::factory()->create();
    }

    /** @test **/
    public function authenticatedUserCanViewTheEditNotePage()
    {
        $this->signIn($this->note->author);

        $response = $this->get(route('notes.edit', $this->note));
        $response->assertSuccessful();
    }

    /** @test **/
    public function authenticatedUserCanUpdateNote()
    {
        $this->signIn($this->note->author);

        $data = [
            'id' => $this->note->id,
            'title' => 'New Title',
            'editor-content' => 'New content',
            'summary' => 'New summary',
        ];

        $this->followingRedirects();

        $response = $this->put(route('notes.update', $this->note), $data);
        $response->assertSuccessful();

        $this->assertRouteUsesFormRequest(
            'notes.update',
            UpdateNoteRequest::class
        );

        $this->assertDatabaseHas('notes', [
            'id' => $this->note->id,
            'title' => 'New Title',
            'content' => 'New content',
            'summary' => 'New summary',
        ]);
    }

    /** @test **/
    public function eventIsDispatchedWhenNoteIsUpdated()
    {
        Event::fake();

        $this->signIn($this->note->author);

        $this->put(route('notes.update', $this->note), [
            'id' => $this->note->id,
            'title' => 'New Title',
            'editor-content' => 'New content',
            'summary' => 'New summary',
        ]);

        Event::assertDispatched(NoteUpdated::class);
    }

    /** @test **/
    public function authenticatedUserCannotViewTheEditPageOfANoteTheyDidNotCreate()
    {
        $this->signIn();

        $response = $this->get(route('notes.edit', $this->note));
        $response->assertForbidden();
    }

    /** @test **/
    public function authenticatedUserCannotUpdateNoteTheyDidNotCreate()
    {
        $this->signIn();

        $response = $this->putJson(route('notes.update', $this->note), [
            'title' => 'Foo',
        ]);
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotViewTheEditNotePage()
    {
        $response = $this->getJson(route('notes.edit', $this->note));
        $response->assertUnauthorized();
    }

    /** @test **/
    public function unauthenticatedUserCannotUpdateNote()
    {
        $response = $this->putJson(route('notes.update', $this->note), []);
        $response->assertUnauthorized();
    }
}
