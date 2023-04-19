<?php

declare(strict_types=1);

namespace Tests\Feature\Characters;

use Illuminate\Support\Facades\Event;
use Nova\Characters\Events\CharacterCreated;
use Nova\Characters\Events\CharacterCreatedByAdmin;
use Nova\Characters\Models\Character;
use Nova\Characters\Models\States\Statuses\Active;
use Nova\Characters\Models\States\Statuses\Pending;
use Nova\Characters\Requests\CreateCharacterRequest;
use Nova\Departments\Models\Position;
use Nova\Ranks\Models\RankItem;
use Nova\Users\Models\User;
use Tests\TestCase;
use Tests\UsesSettings;

/**
 * @group characters
 */
class CreateCharacterWithoutPermissionsTest extends TestCase
{
    use UsesSettings;

    /** @test **/
    public function userWithoutPermissionsCanViewTheCreateCharacterPageWhenAllowCharacterCreationSettingIsTrue()
    {
        $this->updateSetting(
            fn ($settings) => $settings->characters->allowCharacterCreation = true
        );

        $this->signIn();

        $response = $this->get(route('characters.create'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function userWithoutPermissionsCannotViewTheCreateCharacterPageWhenAllowCharacterCreationSettingIsFalse()
    {
        $this->updateSetting(
            fn ($settings) => $settings->characters->allowCharacterCreation = false
        );

        $this->signIn();

        $response = $this->get(route('characters.create'));
        $response->assertForbidden();
    }

    /** @test **/
    public function userWithoutPermissionsCanCreateACharacterWhenAllowCharacterCreationSettingIsTrue()
    {
        $this->updateSetting(
            fn ($settings) => $settings->characters->allowCharacterCreation = true
        );

        $this->signIn();

        $position = Position::factory()->create();
        $rank = RankItem::factory()->create();
        $user = User::factory()->active()->create();

        $this->followingRedirects();

        $response = $this->post(route('characters.store'), [
            'name' => 'Jack Sparrow',
            'rank_id' => $rank->id,
            'positions' => [$position->id],
            'self_assign' => true,
        ]);
        $response->assertSuccessful();

        $character = Character::latest()->first();

        $this->assertDatabaseHas('characters', [
            'name' => 'Jack Sparrow',
        ]);

        $this->assertDatabaseHas('character_position', [
            'character_id' => $character->id,
            'position_id' => $position->id,
        ]);

        $this->assertDatabaseHas('character_user', [
            'character_id' => $character->id,
            'user_id' => auth()->id(),
        ]);

        $this->assertRouteUsesFormRequest(
            'characters.store',
            CreateCharacterRequest::class
        );
    }

    /** @test **/
    public function userWithoutPermissionsCannotCreateACharacterWhenAllowCharacterCreationSettingIsFalse()
    {
        $this->updateSetting(
            fn ($settings) => $settings->characters->allowCharacterCreation = false
        );

        $this->signIn();

        $response = $this->postJson(route('characters.store'), [
            'name' => 'Jack Sparrow',
            'positions' => [1],
        ]);
        $response->assertForbidden();

        $this->assertDatabaseMissing('characters', [
            'name' => 'Jack Sparrow',
        ]);
    }

    /** @test **/
    public function userWithoutPermissionsCanCreateCharacterAsAPrimaryCharacterWhenAllowSettingPrimaryCharacterSettingIsTrue()
    {
        $this->updateSetting(function ($settings) {
            $settings->characters->allowCharacterCreation = true;
            $settings->characters->autoLinkCharacter = true;
            $settings->characters->allowSettingPrimaryCharacter = true;
        });

        $this->signIn(User::factory()->active()->create());

        $position = Position::factory()->create();
        $rank = RankItem::factory()->create();

        $response = $this->post(route('characters.store'), [
            'name' => 'Jack Sparrow',
            'rank_id' => $rank->id,
            'positions' => [$position->id],
            'self_assign' => true,
            'self_primary_assign' => true,
        ]);

        $character = Character::latest()->first();

        $this->assertCount(1, $character->users);
        $this->assertCount(1, $character->primaryUsers);
        $this->assertTrue($character->users->first()->is(auth()->user()));
        $this->assertTrue($character->primaryUsers->first()->is(auth()->user()));
    }

    /** @test **/
    public function eventsAreDispatchedWhenACharacterIsCreated()
    {
        $this->updateSetting(
            fn ($settings) => $settings->characters->allowCharacterCreation = true
        );

        $this->signIn();

        Event::fake();

        $position = Position::factory()->create();
        $rank = RankItem::factory()->create();

        $this->followingRedirects();

        $response = $this->post(route('characters.store'), [
            'name' => 'Jack Sparrow',
            'rank_id' => $rank->id,
            'positions' => [$position->id],
            'self_assign' => true,
        ]);

        Event::assertDispatched(CharacterCreated::class);

        Event::assertNotDispatched(CharacterCreatedByAdmin::class);
    }

    /** @test **/
    public function characterCreatedByUserWithoutPermissionsIsAssignedToTheCreatingUserWhenAutoLinkCharacterIsTrue()
    {
        $this->updateSetting(function ($settings) {
            $settings->characters->allowCharacterCreation = true;
            $settings->characters->autoLinkCharacter = true;
        });

        $this->signIn();

        $position = Position::factory()->create();
        $rank = RankItem::factory()->create();

        $response = $this->post(route('characters.store'), [
            'name' => 'Jack Sparrow',
            'rank_id' => $rank->id,
            'positions' => [$position->id],
            'self_assign' => true,
        ]);

        $character = Character::latest()->first();

        $this->assertCount(1, $character->users);
        $this->assertTrue($character->users->first()->is(auth()->user()));
    }

    /** @test **/
    public function characterCreatedByUserWithoutPermissionsIsNotAssignedToTheCreatingUserWhenAutoLinkCharacterIsFalse()
    {
        $this->updateSetting(function ($settings) {
            $settings->characters->allowCharacterCreation = true;
            $settings->characters->autoLinkCharacter = false;
        });

        $this->signIn();

        $position = Position::factory()->create();
        $rank = RankItem::factory()->create();

        $response = $this->post(route('characters.store'), [
            'name' => 'Jack Sparrow',
            'rank_id' => $rank->id,
            'positions' => [$position->id],
        ]);

        $character = Character::latest()->first();

        $this->assertCount(0, $character->users);
    }

    /** @test **/
    public function characterCreatedByUserWithoutPermissionsHasAStatusOfPendingWhenRequireApprovalSettingIsTrue()
    {
        $this->updateSetting(function ($settings) {
            $settings->characters->allowCharacterCreation = true;
            $settings->characters->requireApprovalForCharacterCreation = true;
        });

        $this->signIn();

        $position = Position::factory()->create();
        $rank = RankItem::factory()->create();

        $response = $this->post(route('characters.store'), [
            'name' => 'Jack Sparrow',
            'rank_id' => $rank->id,
            'positions' => [$position->id],
            'self_assign' => true,
        ]);

        $character = Character::latest()->first();

        $this->assertInstanceOf(Pending::class, $character->status);
    }

    /** @test **/
    public function characterCreatedByUserWithoutPermissionsHasAStatusOfActiveWhenRequireApprovalSettingIsFalse()
    {
        $this->updateSetting(function ($settings) {
            $settings->characters->allowCharacterCreation = true;
            $settings->characters->requireApprovalForCharacterCreation = false;
        });

        $this->signIn();

        $position = Position::factory()->create();
        $rank = RankItem::factory()->create();

        $response = $this->post(route('characters.store'), [
            'name' => 'Jack Sparrow',
            'rank_id' => $rank->id,
            'positions' => [$position->id],
            'self_assign' => true,
        ]);

        $character = Character::latest()->first();

        $this->assertInstanceOf(Active::class, $character->status);
    }
}
