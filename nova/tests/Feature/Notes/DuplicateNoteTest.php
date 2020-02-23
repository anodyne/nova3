<?php

namespace Tests\Feature\Notes;

use Tests\TestCase;
use Nova\Notes\Models\Note;
use Illuminate\Support\Facades\Event;
use Nova\Notes\Events\NoteDuplicated;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DuplicateNoteTest extends TestCase
{
    use RefreshDatabase;

    protected $note;

    public function setUp(): void
    {
        parent::setUp();

        $this->note = factory(Note::class)->create();
    }

    /** @test **/
    public function userCanDuplicateNote()
    {
        $this->signIn($this->note->author);

        $response = $this->post(route('notes.duplicate', $this->note));

        $this->followRedirects($response)->assertOk();

        $note = Note::get()->last();

        $this->assertDatabaseHas('notes', [
            'title' => "Copy of {$this->note->title}",
        ]);
    }

    /** @test **/
    public function userCannotDuplicateNoteTheyDidNotCreate()
    {
        $this->signIn();

        $response = $this->post(route('notes.duplicate', $this->note));

        $response->assertForbidden();
    }

    /** @test **/
    public function guestCannotDuplicateNote()
    {
        $response = $this->post(route('notes.duplicate', $this->note));

        $response->assertRedirect(route('login'));
    }

    /** @test **/
    public function eventIsDispatchedWhenNoteIsDuplicated()
    {
        Event::fake();

        $this->signIn($this->note->author);

        $this->post(route('notes.duplicate', $this->note));

        $note = Note::get()->last();

        Event::assertDispatched(NoteDuplicated::class, function ($event) use ($note) {
            return $event->note->is($note) && $event->originalNote->is($this->note);
        });
    }
}
