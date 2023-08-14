<?php

declare(strict_types=1);
use Nova\Ranks\Actions\DeleteRankName;
use Nova\Ranks\Models\RankName;
uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    $this->name = RankName::factory()->create();
});
it('deletes a rank name', function () {
    $name = DeleteRankName::run($this->name);

    expect($name->exists)->toBeFalse();
});
