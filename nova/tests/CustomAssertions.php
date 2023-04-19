<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Testing\TestResponse;
use PHPUnit\Framework\Assert as PHPUnit;

trait CustomAssertions
{
    /**
     * Setup macros to test responses.
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
