<?php

namespace Tests\Unit\Ranks\Actions;

use Tests\TestCase;
use Nova\Ranks\Models\RankName;
use Nova\Ranks\Actions\DeleteRankName;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @group ranks
 */
class DeleteRankNameActionTest extends TestCase
{
    use RefreshDatabase;

    protected $action;

    protected $name;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(DeleteRankName::class);

        $this->name = create(RankName::class);
    }

    /** @test **/
    public function itDeletesARankName()
    {
        $name = $this->action->execute($this->name);

        $this->assertFalse($name->exists);
    }
}
