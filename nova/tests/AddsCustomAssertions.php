<?php

namespace Tests;

use PHPUnit\Framework\Assert as PHPUnit;
use Illuminate\Foundation\Testing\TestResponse;

trait AddsCustomAssertions
{
    protected function setupTestResponseMacros()
    {
        TestResponse::macro('assertResponseHas', function ($key, $value) {
            $view = $this->original->structure->layout->template->content;

            PHPUnit::assertEquals($view->{$key}, $value);

            return $this;
        });
    }
}