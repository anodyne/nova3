<?php

namespace Tests\Unit\Characters\Actions;

use Tests\TestCase;
use Nova\Ranks\Models\RankItem;
use Nova\Characters\Actions\CreateCharacter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Characters\DataTransferObjects\CharacterData;

/**
 * @group characters
 */
class CreateCharacterActionTest extends TestCase
{
    use RefreshDatabase;

    protected $action;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(CreateCharacter::class);
    }

    /** @test **/
    public function itCanCreateACharacter()
    {
        $rank = create(RankItem::class);

        $data = new CharacterData;
        $data->name = 'Jack Sparrow';
        $data->rank_id = $rank->id;

        $character = $this->action->execute($data);

        $this->assertTrue($character->exists);
        $this->assertEquals('Jack Sparrow', $character->name);
        $this->assertEquals($rank->id, $character->rank_id);
    }
}
