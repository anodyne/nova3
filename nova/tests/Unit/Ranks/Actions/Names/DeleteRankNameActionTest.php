<?php

declare(strict_types=1);

namespace Tests\Unit\Ranks\Actions\Names;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Ranks\Actions\DeleteRankName;
use Nova\Ranks\Models\RankName;
use Tests\TestCase;

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

        $this->name = RankName::factory()->create();
    }

    /** @test **/
    public function itDeletesARankName()
    {
        $name = $this->action->execute($this->name);

        $this->assertFalse($name->exists);
    }
}
