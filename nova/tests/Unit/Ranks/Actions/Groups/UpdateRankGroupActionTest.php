<?php

declare(strict_types=1);
use Nova\Ranks\Actions\UpdateRankGroup;
use Nova\Ranks\Data\RankGroupData;
use Nova\Ranks\Models\RankGroup;
uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    $this->group = RankGroup::factory()->create();
});
it('updates a rank group', function () {
    $data = RankGroupData::from([
        'name' => 'Command',
    ]);

    $group = UpdateRankGroup::run($this->group, $data);

    expect($group->exists)->toBeTrue();
    expect($group->name)->toEqual('Command');
});
