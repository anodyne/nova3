<?php

declare(strict_types=1);

namespace Tests\Feature\Ranks\Names;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Nova\Ranks\Events\RankNameCreated;
use Nova\Ranks\Models\RankName;
use Nova\Ranks\Requests\CreateRankNameRequest;
use Tests\TestCase;

/**
 * @group ranks
 */
class CreateRankNameTest extends TestCase
{
    /** @test **/
    public function authorizedUserCanViewTheCreateRankNamePage()
    {
        $this->signInWithPermission('rank.create');

        $response = $this->get(route('ranks.names.create'));
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserCanCreateARankName()
    {
        $this->signInWithPermission('rank.create');

        $this->followingRedirects();

        $response = $this->post(
            route('ranks.names.store'),
            $rankNameData = RankName::factory()->make()->toArray()
        );
        $response->assertSuccessful();

        $this->assertRouteUsesFormRequest(
            'ranks.names.store',
            CreateRankNameRequest::class
        );

        $this->assertDatabaseHas('rank_names', $rankNameData);
    }

    /** @test **/
    public function eventIsDispatchedWhenRankNameIsCreated()
    {
        Event::fake();

        $this->signInWithPermission('rank.create');

        $this->post(
            route('ranks.names.store'),
            RankName::factory()->make()->toArray()
        );

        Event::assertDispatched(RankNameCreated::class);
    }

    /** @test **/
    public function unauthorizedUserCannotViewTheCreateRankNamePage()
    {
        $this->signIn();

        $response = $this->get(route('ranks.names.create'));
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthorizedUserCannotCreateARankName()
    {
        $this->signIn();

        $response = $this->post(
            route('ranks.names.store'),
            RankName::factory()->make()->toArray()
        );
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotViewTheCreateRankNamePage()
    {
        $response = $this->getJson(route('ranks.names.create'));
        $response->assertUnauthorized();
    }

    /** @test **/
    public function unauthenticatedUserCannotCreateARankName()
    {
        $response = $this->postJson(
            route('ranks.names.store'),
            RankName::factory()->make()->toArray()
        );
        $response->assertUnauthorized();
    }
}
