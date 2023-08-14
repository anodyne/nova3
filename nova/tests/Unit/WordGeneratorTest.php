<?php

declare(strict_types=1);

use Nova\Foundation\WordGenerator;
beforeEach(function () {
    $this->generator = new WordGenerator();
});

it('can generate words', function () {
    $this->generator->words();

    expect($this->generator)->toHaveCount(1);
});
