<?php

declare(strict_types=1);
use Nova\Ranks\Actions\CreateRankItem;
use Nova\Ranks\Data\RankItemData;
use Nova\Ranks\Models\RankGroup;
use Nova\Ranks\Models\RankName;
uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    $this->group = RankGroup::factory()->create();

    $this->name = RankName::factory()->create();
});
it('creates a rank item', function () {
    $data = RankItemData::from([
        'group_id' => $this->group->id,
        'name_id' => $this->name->id,
        'base_image' => 'base.png',
        'overlay_image' => 'overlay.png',
    ]);

    $item = CreateRankItem::run($data);

    expect($item->exists)->toBeTrue();
    expect($item->group_id)->toEqual($this->group->id);
    expect($item->name_id)->toEqual($this->name->id);
    expect($item->base_image)->toEqual('base.png');
    expect($item->overlay_image)->toEqual('overlay.png');
});
