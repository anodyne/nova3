<?php

declare(strict_types=1);
use Nova\Ranks\Actions\DuplicateRankGroup;
use Nova\Ranks\Data\RankGroupData;
use Nova\Ranks\Models\RankGroup;
uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    $this->group = RankGroup::factory()->create([
        'name' => 'Command',
    ]);
});
it('duplicates a rank group', function () {
    $group = DuplicateRankGroup::run($this->group, RankGroupData::from([
        'name' => 'New Name',
    ]));

    expect($group->exists)->toBeTrue();
    expect($group->name)->toEqual('New Name');
});
