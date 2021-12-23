<?php

declare(strict_types=1);

namespace Tests\Feature\Forms;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Forms\Models\Form;
use Tests\TestCase;

/**
 * @group forms
 */
class ManageFormsTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function authorizedUserWithCreatePermissionCanViewManageFormsPage()
    {
        $this->signInWithPermission('form.create');

        $response = $this->get(route('forms.index'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserWithUpdatePermissionCanViewManageFormsPage()
    {
        $this->signInWithPermission('form.update');

        $response = $this->get(route('forms.index'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserWithDeletePermissionCanViewManageFormsPage()
    {
        $this->signInWithPermission('form.delete');

        $response = $this->get(route('forms.index'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserWithViewPermissionCanViewManageFormsPage()
    {
        $this->signInWithPermission('form.view');

        $response = $this->get(route('forms.index'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function formsCanBeFilteredByName()
    {
        $this->signInWithPermission('form.create');

        Form::factory()->create([
            'name' => 'barbaz',
        ]);

        $response = $this->get(route('forms.index'));
        $response->assertSuccessful();

        $this->assertEquals(Form::count(), $response['forms']->total());

        $response = $this->get(route('forms.index', 'search=barbaz'));
        $response->assertSuccessful();

        $this->assertCount(1, $response['forms']);
    }

    /** @test **/
    public function formsCanBeFilteredByKey()
    {
        $this->signInWithPermission('form.create');

        Form::factory()->create([
            'key' => 'foobar',
        ]);

        $response = $this->get(route('forms.index'));
        $response->assertSuccessful();

        $this->assertEquals(Form::count(), $response['forms']->total());

        $response = $this->get(route('forms.index', 'search=foobar'));
        $response->assertSuccessful();

        $this->assertCount(1, $response['forms']);
    }

    /** @test **/
    public function unauthorizedUserCannotViewManageFormsPage()
    {
        $this->signIn();

        $response = $this->get(route('forms.index'));
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotViewManageFormsPage()
    {
        $response = $this->getJson(route('forms.index'));
        $response->assertUnauthorized();
    }
}
