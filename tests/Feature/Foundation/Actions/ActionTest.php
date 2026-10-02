<?php

declare(strict_types=1);

use Illuminate\Support\Fluent;
use Nova\Foundation\Actions\Action;

class ConditionalTestAction extends Action
{
    public function handle(string $first, string $second): string
    {
        return $first.' '.$second;
    }
}

it('runs the action and returns its result when the condition allows it', function (string $method, bool $condition) {
    $result = ConditionalTestAction::$method($condition, second: 'world', first: 'hello');

    expect($result)->toBe('hello world');
})->with([
    'runIf true' => ['runIf', true],
    'runUnless false' => ['runUnless', false],
]);

it('returns an empty fluent without resolving the action when the condition skips it', function (string $method, bool $condition) {
    app()->bind(ConditionalTestAction::class, function (): never {
        throw new RuntimeException('The skipped action must not be resolved.');
    });

    $result = ConditionalTestAction::$method($condition);

    expect($result)->toBeInstanceOf(Fluent::class);
    expect($result->toArray())->toBe([]);
})->with([
    'runIf false' => ['runIf', false],
    'runUnless true' => ['runUnless', true],
]);

it('uses the runnable fake when the condition allows execution', function (string $method, bool $condition) {
    $fake = ConditionalTestAction::fake('fake result');

    $result = ConditionalTestAction::$method($condition, 'hello', 'world');

    expect($result)->toBe('fake result');
    $fake->shouldHaveReceived('handle')->with('hello', 'world')->once();
})->with([
    'runIf true' => ['runIf', true],
    'runUnless false' => ['runUnless', false],
]);
