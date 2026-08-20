<?php

declare(strict_types=1);

use Illuminate\Http\Request;
use Nova\Users\Data\AssignUserCharactersData;

it('casts a primary character to an integer', function () {
    $data = AssignUserCharactersData::from(Request::create('/', 'POST', [
        'assigned_characters' => '10,20',
        'primary_character' => '20',
    ]));

    expect($data->characters)->toBe(['10', '20'])
        ->and($data->primaryCharacter)->toBe(20);
});

it('uses null when a primary character is not filled', function (mixed $primaryCharacter) {
    $data = AssignUserCharactersData::from(Request::create('/', 'POST', [
        'assigned_characters' => '',
        'primary_character' => $primaryCharacter,
    ]));

    expect($data->primaryCharacter)->toBeNull();
})->with([
    'missing' => null,
    'empty' => '',
]);
