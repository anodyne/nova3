<?php

declare(strict_types=1);

namespace Tests\Feature\Forms;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Nova\Forms\Events\FormDeleted;
use Nova\Forms\Models\Form;
use Tests\TestCase;

/**
 * @group forms
 */
class DeleteFormTest extends TestCase
{
    use RefreshDatabase;

    protected $form;

    public function setUp(): void
    {
        parent::setUp();

        $this->form = Form::factory()->create();
    }

    /** @test **/
    public function authorizedUserCanDeleteForm()
    {
        $this->signInWithPermission('form.delete');

        $this->followingRedirects();

        $response = $this->delete(route('forms.destroy', $this->form));
        $response->assertSuccessful();

        $this->assertDatabaseMissing('forms', [
            'id' => $this->form->id,
        ]);
    }

    /** @test **/
    public function eventIsDispatchedWhenRoleIsDeleted()
    {
        Event::fake();

        $this->signInWithPermission('form.delete');

        $this->delete(route('forms.destroy', $this->form));

        Event::assertDispatched(FormDeleted::class);
    }

    /** @test **/
    public function lockedFormCannotBeDeleted()
    {
        $this->signInWithPermission('form.delete');

        $form = Form::factory()->locked()->create();

        $response = $this->delete(route('forms.destroy', $form));
        $response->assertForbidden();

        $this->assertDatabaseHas('forms', [
            'id' => $form->id,
            'locked' => true,
        ]);
    }

    /** @test **/
    public function unauthorizedUserCannotDeleteForm()
    {
        $this->signIn();

        $response = $this->delete(route('forms.destroy', $this->form));
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotDeleteForm()
    {
        $response = $this->deleteJson(route('forms.destroy', $this->form));
        $response->assertUnauthorized();
    }
}
