<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\TestCase;
use Pest\Concerns\Expectable;
use Pest\PendingCalls\BeforeEachCall;
use Pest\PendingCalls\TestCall;
use Pest\Support\HigherOrderTapProxy;

/**
 * Runs the given closure before each test in the current file.
 *
 * @param-closure-this TestCase  $closure
 *
 * @return HigherOrderTapProxy<Expectable|TestCall|TestCase>|Expectable|TestCall|TestCase|mixed
 */
function beforeEach(?Closure $closure = null): BeforeEachCall {}
