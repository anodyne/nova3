<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Faker\Generator as Faker;
use Nova\Characters\Models\Character;
use Nova\Characters\Models\States\Active;
use Nova\Characters\Models\States\Inactive;
use Nova\Characters\Models\States\Npc;
use Nova\Characters\Models\States\Pending;
use Nova\Characters\Models\States\Pnpc;
use Nova\Characters\Models\States\Primary;
use Nova\Ranks\Models\RankItem;

$factory->define(Character::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'rank_id' => function () {
            return factory(RankItem::class)->create()->id;
        }
    ];
});

$factory->state(Character::class, 'status:active', ['status' => Active::class]);
$factory->state(Character::class, 'status:inactive', ['status' => Inactive::class]);
$factory->state(Character::class, 'status:pending', ['status' => Pending::class]);

$factory->state(Character::class, 'type:primary', ['type' => Primary::class]);
$factory->state(Character::class, 'type:npc', ['type' => Npc::class]);
$factory->state(Character::class, 'type:pnpc', ['type' => Pnpc::class]);
