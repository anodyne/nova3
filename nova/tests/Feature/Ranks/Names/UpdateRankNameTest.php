<?php

namespace Tests\Feature\Ranks\Names;

use Tests\TestCase;
use Nova\Ranks\Models\RankName;
use Illuminate\Support\Facades\Event;
use Nova\Ranks\Events\RankNameUpdated;
use Nova\Ranks\Requests\UpdateRankNameRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @group ranks
 */
class UpdateRankNameTest extends TestCase
{
    use RefreshDatabase;

    protected $name;

    public function setUp(): void
    {
        parent::setUp();

        $this->name = create(RankName::class);
    }

    /** @test **/
    public function authorizedUserCanViewTheEditRankNamePage()
    {
        $this->signInWithPermission('rank.update');

        $response = $this->get(route('ranks.names.edit', $this->name));
        $response->assertSuccessful();
    }

    /** @test **/
    public function authorizedUserCanUpdateARankName()
    {
        $this->signInWithPermission('rank.update');

        $this->followingRedirects();

        $response = $this->put(
            route('ranks.names.update', $this->name),
            $rankNameData = make(RankName::class)->toArray()
        );
        $response->assertSuccessful();

        $this->assertRouteUsesFormRequest(
            'ranks.names.update',
            UpdateRankNameRequest::class
        );

        $this->assertDatabaseHas('rank_names', $rankNameData);
    }

    /** @test **/
    public function eventIsDispatchedWhenRankNameIsUpdated()
    {
        Event::fake();

        $this->signInWithPermission('rank.update');

        $this->put(
            route('ranks.names.update', $this->name),
            make(RankName::class)->toArray()
        );

        Event::assertDispatched(RankNameUpdated::class);
    }

    /** @test **/
    public function unauthorizedUserCannotViewTheEditRankNamePage()
    {
        $this->signIn();

        $response = $this->get(route('ranks.names.edit', $this->name));
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthorizedUserCannotUpdateARankName()
    {
        $this->signIn();

        $response = $this->put(
            route('ranks.names.update', $this->name),
            make(RankName::class)->toArray()
        );
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotViewTheEditRankNamePage()
    {
        $response = $this->getJson(route('ranks.names.edit', $this->name));
        $response->assertUnauthorized();
    }

    /** @test **/
    public function unauthenticatedUserCannotUpdateARankName()
    {
        $response = $this->putJson(
            route('ranks.names.update', $this->name),
            make(RankName::class)->toArray()
        );
        $response->assertUnauthorized();
    }
}
