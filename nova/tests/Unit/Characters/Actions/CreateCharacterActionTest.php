<?php

declare(strict_types=1);
use Nova\Characters\Actions\CreateCharacter;
use Nova\Characters\Data\CharacterData;
use Nova\Ranks\Models\RankItem;

uses()->group('characters');

it('can create a character', function () {
    $rank = RankItem::factory()->create();

    $data = CharacterData::from([
        'name' => 'Jack Sparrow',
        'rank_id' => $rank->id,
    ]);

    $character = CreateCharacter::run($data);

    expect($character->exists)->toBeTrue();
    expect($character->name)->toEqual('Jack Sparrow');
    expect($character->rank_id)->toEqual($rank->id);
});
it('can create a character without a rank', function () {
    $data = CharacterData::from([
        'name' => 'Jack Sparrow',
        'rank_id' => null,
    ]);

    $character = CreateCharacter::run($data);

    expect($character->exists)->toBeTrue();
    expect($character->name)->toEqual('Jack Sparrow');
    expect($character->rank)->toBeNull();
});
