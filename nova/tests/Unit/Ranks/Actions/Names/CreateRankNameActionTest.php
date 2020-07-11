<?php

namespace Tests\Unit\Ranks\Actions\Names;

use Tests\TestCase;
use Nova\Ranks\Models\RankName;
use Nova\Ranks\Actions\CreateRankName;
use Nova\Ranks\DataTransferObjects\RankNameData;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @group ranks
 */
class CreateRankNameActionTest extends TestCase
{
    use RefreshDatabase;

    protected $action;

    public function setUp(): void
    {
        parent::setUp();

        $this->action = app(CreateRankName::class);
    }

    /** @test **/
    public function itCreatesARankName()
    {
        $data = new RankNameData([
            'name' => 'Captain',
        ]);

        $name = $this->action->execute($data);

        $this->assertTrue($name->exists);
        $this->assertEquals('Captain', $name->name);
    }

    /** @test **/
    public function itCreatesARankNameWithTheProperSortOrder()
    {
        create(RankName::class, ['sort' => 0]);
        create(RankName::class, ['sort' => 1]);

        $data = new RankNameData([
            'name' => 'Captain',
        ]);

        $name = $this->action->execute($data);

        $this->assertEquals(2, $name->sort);
    }
}
