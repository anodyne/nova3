<?php

declare(strict_types=1);
use Nova\Ranks\Actions\CreateRankName;
use Nova\Ranks\Data\RankNameData;
use Nova\Ranks\Models\RankName;
uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('creates a rank name', function () {
    $data = RankNameData::from([
        'name' => 'Captain',
    ]);

    $name = CreateRankName::run($data);

    expect($name->exists)->toBeTrue();
    expect($name->name)->toEqual('Captain');
});
it('creates a rank name with the proper sort order', function () {
    RankName::factory()->create(['sort' => 0]);
    RankName::factory()->create(['sort' => 1]);

    $data = RankNameData::from([
        'name' => 'Captain',
    ]);

    $name = CreateRankName::run($data);

    expect($name->sort)->toEqual(2);
});
