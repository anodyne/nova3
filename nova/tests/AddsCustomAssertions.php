<?php

namespace Tests;

use Illuminate\Support\Arr;
use PHPUnit\Framework\Assert as PHPUnit;
use Illuminate\Foundation\Testing\Assert;
use Illuminate\Foundation\Testing\TestResponse;

trait AddsCustomAssertions
{
    /**
     * Setup macros to test Inertia responses.
     *
     * @return void
     */
    protected function setupTestResponseMacros(): void
    {
        TestResponse::macro('assertResponseHas', function ($key, $value) {
            $data = $this->original->getData();
            $data = $data['page']['props'] ?? $data;

            PHPUnit::assertEquals($data[$key], $value);

            return $this;
        });

        TestResponse::macro('assertResponseMissing', function ($key, $value) {
            $data = $this->original->getData();
            $data = $data['page']['props'] ?? $data;

            PHPUnit::assertNotEquals($data[$key], $value);

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

        TestResponse::macro('props', function ($key = null) {
            $props = json_decode(json_encode($this->original->getData()['page']['props']), JSON_OBJECT_AS_ARRAY);

            if ($key) {
                return Arr::get($props, $key);
            }

            return $props;
        });

        TestResponse::macro('assertHasProp', function ($key) {
            Assert::assertTrue(Arr::has($this->props(), $key));

            return $this;
        });

        TestResponse::macro('assertPropValue', function ($key, $value) {
            $this->assertHasProp($key);

            if (is_callable($value)) {
                $value($this->props($key));
            } else {
                Assert::assertEquals($this->props($key), $value);
            }

            return $this;
        });

        TestResponse::macro('assertPropCount', function ($key, $count) {
            $this->assertHasProp($key);
            Assert::assertCount($count, $this->props($key));

            return $this;
        });
    }
}
