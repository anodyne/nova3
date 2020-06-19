<?php

namespace Tests\Unit\Ranks\Actions;

use Tests\TestCase;
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
        $data = new RankNameData;
        $data->name = 'Captain';

        $name = $this->action->execute($data);

        $this->assertTrue($name->exists);
        $this->assertEquals('Captain', $name->name);
    }
}
