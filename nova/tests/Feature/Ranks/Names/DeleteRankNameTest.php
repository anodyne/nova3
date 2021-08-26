<?php

declare(strict_types=1);

namespace Tests\Feature\Ranks\Names;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Nova\Ranks\Events\RankNameDeleted;
use Nova\Ranks\Models\RankName;
use Tests\TestCase;

/**
 * @group ranks
 */
class DeleteRankNameTest extends TestCase
{
    use RefreshDatabase;

    protected $name;

    public function setUp(): void
    {
        parent::setUp();

        $this->name = RankName::factory()->create();
    }

    /** @test **/
    public function authorizedUserCanDeleteARankGroup()
    {
        $this->signInWithPermission('rank.delete');

        $this->followingRedirects();

        $response = $this->delete(route('ranks.names.destroy', $this->name));
        $response->assertSuccessful();

        $this->assertDatabaseMissing('rank_names', $this->name->only('id'));
    }

    /** @test **/
    public function eventIsDispatchedWhenRankNameIsDeleted()
    {
        Event::fake();

        $this->signInWithPermission('rank.delete');

        $this->delete(route('ranks.names.destroy', $this->name));

        Event::assertDispatched(RankNameDeleted::class);
    }

    /** @test **/
    public function unauthorizedUserCannotDeleteARankName()
    {
        $this->signIn();

        $response = $this->delete(route('ranks.names.destroy', $this->name));
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotDeleteARankName()
    {
        $response = $this->deleteJson(
            route('ranks.names.destroy', $this->name)
        );
        $response->assertUnauthorized();
    }
}
