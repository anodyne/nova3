<?php

namespace Tests\Feature\Themes;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageThemesTest extends TestCase
{
    use RefreshDatabase;

    public function testAnAuthorizedUserCanViewTheManageThemesPage()
    {
        $this->signIn();

        $this->get(route('themes.index'))
            ->assertSuccessful();
    }
}