<?php namespace Tests\Media;

use Nova\Media\Media;
use Tests\DatabaseTestCase;

class MediaTest extends DatabaseTestCase
{
	protected $media;

	public function setUp()
	{
		parent::setUp();

		$this->media = create(Media::class);
	}

	/**
	 * @test
	 * @covers Nova\Media\Media::mediable
	 */
	public function it_has_a_mediable_object()
	{
		$this->assertInstanceOf('Nova\Characters\Character', $this->media->mediable);
	}

	/**
	 * @test
	 * @covers Nova\Media\Media::makePrimary
	 */
	public function it_can_make_itself_the_primary_media()
	{
		$media1 = create(Media::class, ['mediable_id' => $this->media->mediable_id]);
		$media2 = create(Media::class, ['mediable_id' => $this->media->mediable_id]);

		$media2->makePrimary();

		$this->assertEquals($media2->id, $this->media->mediable->getPrimaryMedia()->id);
	}

	/**
	 * @test
	 * @covers Nova\Media\Media::reorder
	 */
	public function it_can_reorder_itself()
	{
		$this->media->reorder(2);

		$this->assertEquals(2, $this->media->order);
	}
}
