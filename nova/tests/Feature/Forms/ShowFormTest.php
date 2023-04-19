<?php

declare(strict_types=1);

namespace Tests\Feature\Forms;

use Nova\Forms\Models\Form;
use Tests\TestCase;

/**
 * @group forms
 */
class ShowFormTest extends TestCase
{
    protected $form;

    public function setUp(): void
    {
        parent::setUp();

        $this->form = Form::factory()->create();
    }

    /** @test **/
    public function authorizedUserCanViewAForm()
    {
        $this->signInWithPermission('form.view');

        $response = $this->get(route('forms.show', $this->form));
        $response->assertSuccessful();
        $response->assertViewHas('form', $this->form);
    }

    /** @test **/
    public function unauthorizedUserCannotViewAForm()
    {
        $this->signIn();

        $response = $this->get(route('forms.show', $this->form));
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotViewAForm()
    {
        $response = $this->getJson(route('forms.show', $this->form));
        $response->assertUnauthorized();
    }
}
