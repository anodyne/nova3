<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Faker\Generator as Faker;
use Nova\Ranks\Models\RankItem;
use Nova\Ranks\Models\RankName;
use Nova\Ranks\Models\RankGroup;

$factory->define(RankItem::class, function (Faker $faker) {
    return [
        'group_id' => function () {
            return create(RankGroup::class)->id;
        },
        'name_id' => function () {
            return create(RankName::class)->id;
        },
        'base_image' => 'base.png',
        'overlay_image' => 'overlay.png',
    ];
});
