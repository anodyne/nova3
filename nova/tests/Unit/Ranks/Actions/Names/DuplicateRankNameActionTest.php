<?php

declare(strict_types=1);
use Nova\Ranks\Actions\DuplicateRankName;
use Nova\Ranks\Models\RankName;
uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    $this->name = RankName::factory()->create([
        'name' => 'Captain',
    ]);
});
it('duplicates a rank name', function () {
    $name = DuplicateRankName::run($this->name);

    expect($name->exists)->toBeTrue();
    expect($name->name)->toEqual('Copy of Captain');
});
