<?php

declare(strict_types=1);

namespace Tests\Unit\Ranks\Actions\Names;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Ranks\Actions\UpdateRankName;
use Nova\Ranks\DataTransferObjects\RankNameData;
use Nova\Ranks\Models\RankName;
use Tests\TestCase;

/**
 * @group ranks
 */
class UpdateRankNameActionTest extends TestCase
{
    use RefreshDatabase;

    protected $action;

    protected $name;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(UpdateRankName::class);

        $this->name = RankName::factory()->create();
    }

    /** @test **/
    public function itUpdatesARankName()
    {
        $data = new RankNameData([
            'name' => 'Captain',
        ]);

        $name = $this->action->execute($this->name, $data);

        $this->assertTrue($name->exists);
        $this->assertEquals('Captain', $name->name);
    }
}
