<?php namespace Tests\Genres;

use Tests\DatabaseTestCase;

class RankTest extends DatabaseTestCase
{
	protected $rank;

	public function setUp()
	{
		parent::setUp();

		$this->rank = create('Nova\Genres\Rank');
	}

	/** @test **/
	public function it_belongs_to_a_rank_group()
	{
		$this->assertInstanceOf('Nova\Genres\RankGroup', $this->rank->group);
	}

	/** @test **/
	public function it_has_rank_info()
	{
		$this->assertInstanceOf('Nova\Genres\RankInfo', $this->rank->info);
	}
}
