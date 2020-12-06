<?php

namespace Tests\Feature\Setup;

use Tests\TestCase;

/**
 * @group setup
 */
class SetupCenterTest extends TestCase
{
    /** @test **/
    public function userCanViewTheSetupCenter()
    {
        $response = $this->get('/setup');
        $response->assertOk();
    }
}
