<?php

namespace Tests;

use Illuminate\Support\Arr;
use Illuminate\Testing\Assert;
use Illuminate\Testing\TestResponse;
use PHPUnit\Framework\Assert as PHPUnit;

trait AddsCustomAssertions
{
    /**
     * Setup macros to test Inertia responses.
     *
     * @return void
     */
    protected function setupTestResponseMacros(): void
    {
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
