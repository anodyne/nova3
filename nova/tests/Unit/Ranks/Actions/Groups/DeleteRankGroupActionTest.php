<?php

declare(strict_types=1);
use Nova\Ranks\Actions\DeleteRankGroup;
use Nova\Ranks\Models\RankGroup;
uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    $this->group = RankGroup::factory()->create();
});
it('deletes a rank group', function () {
    $group = DeleteRankGroup::run($this->group);

    expect($group->exists)->toBeFalse();
});
