<?php

declare(strict_types=1);
use Nova\Ranks\Actions\UpdateRankItem;
use Nova\Ranks\Data\RankItemData;
use Nova\Ranks\Models\RankGroup;
use Nova\Ranks\Models\RankItem;
use Nova\Ranks\Models\RankName;
uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    $this->item = RankItem::factory()->create();
});
it('updates a rank item', function () {
    $group = RankGroup::factory()->create();
    $name = RankName::factory()->create();

    $data = RankItemData::from([
        'group_id' => $group->id,
        'name_id' => $name->id,
        'base_image' => 'new-base.png',
        'overlay_image' => 'new-overlay.png',
    ]);

    $item = UpdateRankItem::run($this->item, $data);

    expect($item->exists)->toBeTrue();
    expect($item->group_id)->toEqual($group->id);
    expect($item->name_id)->toEqual($name->id);
    expect($item->base_image)->toEqual('new-base.png');
    expect($item->overlay_image)->toEqual('new-overlay.png');
});
