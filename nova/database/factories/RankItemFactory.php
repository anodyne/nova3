<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Faker\Generator as Faker;
use Nova\Ranks\Models\RankItem;
use Nova\Ranks\Models\RankName;
use Nova\Ranks\Models\RankGroup;

$factory->define(RankItem::class, function (Faker $faker) {
    return [
        'group_id' => fn () => factory(RankGroup::class)->create()->id,
        'name_id' => fn () => factory(RankName::class)->create()->id,
        'base_image' => 'base.png',
        'overlay_image' => 'overlay.png',
    ];
});
