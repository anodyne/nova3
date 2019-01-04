<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    /** @test **/
    public function testBasicTest()
    {
        $this->get(route('home'))->assertSuccessful();
    }
}
