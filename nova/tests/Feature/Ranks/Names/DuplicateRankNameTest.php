<?php

namespace Tests\Feature\Ranks\Names;

use Tests\TestCase;
use Nova\Ranks\Models\RankName;
use Illuminate\Support\Facades\Event;
use Nova\Ranks\Events\RankNameDuplicated;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @group ranks
 */
class DuplicateRankNameTest extends TestCase
{
    use RefreshDatabase;

    protected $name;

    public function setUp(): void
    {
        parent::setUp();

        $this->name = create(RankName::class, [
            'name' => 'Captain',
        ]);
    }

    /** @test **/
    public function authorizedUserCanDuplicateRankName()
    {
        $this->signInWithPermission(['rank.create', 'rank.update']);

        $this->followingRedirects();

        $response = $this->post(route('ranks.names.duplicate', $this->name));
        $response->assertSuccessful();

        $this->assertDatabaseHas('rank_names', [
            'name' => "Copy of {$this->name->name}",
        ]);
    }

    /** @test **/
    public function eventIsDispatchedWhenRankNameIsDuplicated()
    {
        Event::fake();

        $this->signInWithPermission(['rank.create', 'rank.update']);

        $this->post(route('ranks.names.duplicate', $this->name));

        Event::assertDispatched(RankNameDuplicated::class);
    }

    /** @test **/
    public function unauthorizedUserCannotDuplicateRankName()
    {
        $this->signIn();

        $response = $this->post(route('ranks.names.duplicate', $this->name));
        $response->assertForbidden();
    }

    /** @test **/
    public function unauthenticatedUserCannotDuplicateRankName()
    {
        $response = $this->postJson(
            route('ranks.names.duplicate', $this->name)
        );
        $response->assertUnauthorized();
    }
}
