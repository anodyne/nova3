<?php

declare(strict_types=1);
use Nova\Ranks\Actions\DuplicateRankGroup;
use Nova\Ranks\Actions\DuplicateRankGroupRankItems;
use Nova\Ranks\Data\RankGroupData;
use Nova\Ranks\Data\RankItemData;
use Nova\Ranks\Models\RankGroup;
uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    $this->group = RankGroup::factory()
        ->hasRanks(2, function (array $attributes, RankGroup $group) {
            return ['group_id' => $group->id];
        })
        ->create([
            'name' => 'Command',
        ]);
});
it('duplicates the rank items from another rank group', function () {
    $group = DuplicateRankGroup::run(
        $this->group,
        RankGroupData::from(['name' => 'New Name'])
    );

    DuplicateRankGroupRankItems::run($group, $this->group, RankItemData::from([
        'base_image' => 'new.png',
    ]));

    $group->refresh();

    expect($group->ranks)->toHaveCount(2);
    expect($group->ranks->first()->base_image)->toEqual('new.png');
});
