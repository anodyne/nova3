<?php namespace Tests\Genres;

use Tests\DatabaseTestCase;

class RankInfoTest extends DatabaseTestCase
{
	protected $info;

	public function setUp()
	{
		parent::setUp();

		$this->info = create('Nova\Genres\RankInfo');
	}

	/** @test **/
	public function it_has_a_collection_of_ranks()
	{
		$rank = create('Nova\Genres\Rank', ['info_id' => $this->info->id]);
		
		$this->assertCount(1, $this->info->fresh()->ranks);

		$this->assertInstanceOf('Nova\Genres\Rank', $this->info->fresh()->ranks->first());
	}
}
