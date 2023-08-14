<?php

declare(strict_types=1);
use Nova\Ranks\Actions\UpdateRankName;
use Nova\Ranks\Data\RankNameData;
use Nova\Ranks\Models\RankName;
uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    $this->name = RankName::factory()->create();
});
it('updates a rank name', function () {
    $data = RankNameData::from([
        'name' => 'Captain',
    ]);

    $name = UpdateRankName::run($this->name, $data);

    expect($name->exists)->toBeTrue();
    expect($name->name)->toEqual('Captain');
});
