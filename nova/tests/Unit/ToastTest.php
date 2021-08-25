<?php

declare(strict_types=1);

use Nova\Foundation\Toast;

uses()->group('toast');

beforeEach(function () {
    $this->toast = app(Toast::class);
});

it('can set the toast message', function () {
    $this->toast->withMessage('Message');

    expect($this->toast->message)->toBe('Message');
});

it('can set the action text', function () {
    $this->toast->withActionText('Save');

    expect($this->toast->actionText)->toBe('Save');
});

it('can set the action url', function () {
    $this->toast->withActionLink('https://google.com');

    expect($this->toast->actionLink)->toBe('https://google.com');
});

it('can set an error type', function () {
    $this->toast->error();

    expect($this->toast->type)->toBe('error');
});

it('can set a success type', function () {
    $this->toast->success();

    expect($this->toast->type)->toBe('success');
});
