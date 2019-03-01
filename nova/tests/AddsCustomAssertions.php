<?php

namespace Tests;

use PHPUnit\Framework\Assert as PHPUnit;
use Illuminate\Foundation\Testing\TestResponse;

trait AddsCustomAssertions
{
    protected function setupTestResponseMacros()
    {
        TestResponse::macro('assertResponseHas', function ($key, $value) {
            if ($this->original->data) {
                PHPUnit::assertEquals($this->original->data[$key], $value);

                return $this;
            }

            $view = $this->original->structure->layout->template->content;

            PHPUnit::assertEquals($view->{$key}, $value);

            return $this;
        });

        TestResponse::macro('assertViewContains', function ($key, $value) {
            $this->data($key)->assertContains($value);

            return $this;
        });

        TestResponse::macro('assertViewNotContains', function ($key, $value) {
            $this->data($key)->assertNotContains($value);

            return $this;
        });

        TestResponse::macro('assertViewData', function ($callback) {
            PHPUnit::assertTrue($callback((object) $this->original->getData()));

            return $this;
        });
    }
}