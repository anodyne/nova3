<?php

declare(strict_types=1);

namespace Tests\Unit\Characters\Actions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Characters\Actions\CreateCharacter;
use Nova\Characters\Data\CharacterData;
use Nova\Ranks\Models\RankItem;
use Tests\TestCase;

/**
 * @group characters
 */
class CreateCharacterActionTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function itCanCreateACharacter()
    {
        $rank = RankItem::factory()->create();

        $data = CharacterData::from([
            'name' => 'Jack Sparrow',
            'rank_id' => $rank->id,
        ]);

        $character = CreateCharacter::run($data);

        $this->assertTrue($character->exists);
        $this->assertEquals('Jack Sparrow', $character->name);
        $this->assertEquals($rank->id, $character->rank_id);
    }
}
