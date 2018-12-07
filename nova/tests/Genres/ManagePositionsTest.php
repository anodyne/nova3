<?php namespace Tests\Genres;

use Status;
use Tests\DatabaseTestCase;

class ManagePositionsTest extends DatabaseTestCase
{
	protected $position;

	public function setUp()
	{
		parent::setUp();

		$this->position = create('Nova\Genres\Position');
	}

	/** @test **/
	public function unauthorized_users_cannot_manage_positions()
	{
		$this->withExceptionHandling();

		$this->get(route('positions.index'))->assertRedirect(route('login'));
		$this->get(route('positions.create'))->assertRedirect(route('login'));
		$this->post(route('positions.store'))->assertRedirect(route('login'));
		$this->patch(route('positions.update', $this->position))->assertRedirect(route('login'));
		$this->delete(route('positions.destroy', $this->position))->assertRedirect(route('login'));

		$this->signIn();

		$this->get(route('positions.index'))->assertStatus(403);
		$this->get(route('positions.create'))->assertStatus(403);
		$this->post(route('positions.store'))->assertStatus(403);
		$this->patch(route('positions.update', $this->position))->assertStatus(403);
		$this->delete(route('positions.destroy', $this->position))->assertStatus(403);
	}

	/** @test **/
	public function a_position_can_be_created()
	{
		$admin = $this->createAdmin();

		$this->signIn($admin);

		$position = make('Nova\Genres\Position', ['department_id' => 1]);

		$this->post(route('positions.store'), $position->toArray());

		$this->assertDatabaseHas('positions', [
			'name' => $position->name,
			'description' => $position->description,
			'department_id' => $position->department_id,
		]);
	}

	/** @test **/
	public function all_positions_can_be_updated()
	{
		$admin = $this->createAdmin();

		$this->signIn($admin);

		$position1 = create('Nova\Genres\Position');
		$position2 = create('Nova\Genres\Position');
		$position3 = create('Nova\Genres\Position');

		$position1->fill(['name' => "New Name"]);
		$position2->fill(['available' => 3]);
		$position3->fill(['display' => (int) false]);

		$positionsData['positions'] = [
			$position1->toArray(),
			$position2->toArray(),
			$position3->toArray(),
		];

		$this->patch(route('positions.update'), $positionsData);

		$this->assertDatabaseHas('positions', ['id' => $position1->id, 'name' => "New Name"]);
		$this->assertDatabaseHas('positions', ['id' => $position2->id, 'available' => 3]);
		$this->assertDatabaseHas('positions', ['id' => $position3->id, 'display' => (int) false]);
	}

	/** @test **/
	public function a_position_can_be_deleted()
	{
		$admin = $this->createAdmin();

		$this->signIn($admin);

		$this->delete(route('positions.destroy', [$this->position]));

		$this->assertDatabaseMissing('positions', ['id' => $this->position->id]);
	}

	/** @test **/
	public function a_position_can_be_reordered()
	{
		$admin = $this->createAdmin();

		$this->signIn($admin);

		$position1 = create('Nova\Genres\Position', ['order' => 0]);
		$position2 = create('Nova\Genres\Position', ['order' => 1]);
		$position3 = create('Nova\Genres\Position', ['order' => 2]);

		$response = $this->patch('/admin/positions/reorder', ['positions' => [$position2->id, $position3->id, $position1->id]]);

		$response->assertStatus(200);

		$this->assertDatabaseHas('positions', ['id' => $position2->id, 'order' => 0]);
		$this->assertDatabaseHas('positions', ['id' => $position3->id, 'order' => 1]);
		$this->assertDatabaseHas('positions', ['id' => $position1->id, 'order' => 2]);
	}

	/** @test **/
	public function has_no_errors()
	{
		$admin = $this->createAdmin();
		$this->signIn($admin);

		$this->get(route('positions.index'))->assertSuccessful();
		$this->get(route('positions.create'))->assertSuccessful();
	}
}
