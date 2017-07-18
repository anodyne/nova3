<?php namespace Tests\Genres;

use Tests\DatabaseTestCase;

class RankGroupTest extends DatabaseTestCase
{
	protected $group;

	public function setUp()
	{
		parent::setUp();

		$this->group = create('Nova\Genres\RankGroup');
	}

	/** @test **/
	public function it_has_a_collection_of_ranks()
	{
		$rank = create('Nova\Genres\Rank', ['group_id' => $this->group->id]);
		
		$this->assertCount(1, $this->group->fresh()->ranks);

		$this->assertInstanceOf('Nova\Genres\Rank', $this->group->fresh()->ranks->first());
	}
}
