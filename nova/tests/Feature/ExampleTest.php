<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function testBasicTest()
    {
        $this->get(route('home'))->assertSuccessful();
    }
}
