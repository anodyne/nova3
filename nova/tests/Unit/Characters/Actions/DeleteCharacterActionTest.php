<?php

declare(strict_types=1);
use Nova\Characters\Actions\DeleteCharacter;
use Nova\Characters\Models\Character;

uses()->group('characters');

it('can delete a character', function () {
    $character = Character::factory()->active()->create([
        'name' => 'Liam Shaw',
    ]);

    DeleteCharacter::run($character);

    $this->assertSoftDeleted(Character::class, [
        'name' => 'Liam Shaw',
    ]);
});
it('can delete a character without any identifiable data', function () {
    $this->markTestIncomplete();

    $this->assertSoftDeleted(Character::class, []);
});
it('can force delete a character without any identifiable data', function () {
    $this->markTestIncomplete();

    $this->assertDatabaseMissing(Character::class, []);
});
