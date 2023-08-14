<?php

declare(strict_types=1);
use Nova\Ranks\Actions\DeleteRankItem;
use Nova\Ranks\Models\RankItem;
uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    $this->item = RankItem::factory()->create();
});
it('deletes a rank item', function () {
    $item = DeleteRankItem::run($this->item);

    expect($item->exists)->toBeFalse();
});
