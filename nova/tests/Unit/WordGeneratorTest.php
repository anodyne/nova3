<?php

declare(strict_types=1);

use Nova\Foundation\WordGenerator;

uses()->group('words');

beforeEach(function () {
    $this->generator = new WordGenerator();
});

it('can generate words')
    ->expect(fn () => $this->generator->words())
    ->toHaveCount(1);
