<?php

declare(strict_types=1);
use Nova\Ranks\Actions\CreateRankGroup;
use Nova\Ranks\Data\RankGroupData;
use Nova\Ranks\Models\RankGroup;
uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('creates a rank group', function () {
    $data = RankGroupData::from([
        'name' => 'Command',
    ]);

    $group = CreateRankGroup::run($data);

    expect($group->exists)->toBeTrue();
    expect($group->name)->toEqual('Command');
});
it('creates a rank group with the proper sort order', function () {
    RankGroup::factory()->create(['sort' => 0]);
    RankGroup::factory()->create(['sort' => 1]);

    $data = RankGroupData::from([
        'name' => 'Command',
    ]);

    $group = CreateRankGroup::run($data);

    expect($group->sort)->toEqual(2);
});
