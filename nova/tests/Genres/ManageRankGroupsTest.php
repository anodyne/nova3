<?php namespace Tests\Genres;

use Status;
use Tests\DatabaseTestCase;

class ManageRankGroupsTest extends DatabaseTestCase
{
	/** @test **/
	public function unauthorized_users_cannot_manage_rank_groups()
	{
		$group = create('Nova\Genres\RankGroup');

		$this->withExceptionHandling();

		$this->get(route('ranks.groups.index'))->assertRedirect(route('login'));
		$this->get(route('ranks.groups.create'))->assertRedirect(route('login'));
		$this->post(route('ranks.groups.store'))->assertRedirect(route('login'));
		$this->patch(route('ranks.groups.update'))->assertRedirect(route('login'));
		$this->delete(route('ranks.groups.destroy', $group))->assertRedirect(route('login'));
		$this->patch(route('ranks.groups.reorder'))->assertRedirect(route('login'));
		$this->post(route('ranks.groups.duplicate', $group))->assertRedirect(route('login'));

		$this->signIn();

		$this->get(route('ranks.groups.index'))->assertStatus(403);
		$this->get(route('ranks.groups.create'))->assertStatus(403);
		$this->post(route('ranks.groups.store'))->assertStatus(403);
		$this->patch(route('ranks.groups.update'))->assertStatus(403);
		$this->delete(route('ranks.groups.destroy', $group))->assertStatus(403);
		$this->patch(route('ranks.groups.reorder'))->assertStatus(403);
		$this->post(route('ranks.groups.duplicate', $group))->assertStatus(403);
	}

	/** @test **/
	public function a_rank_group_can_be_created()
	{
		$admin = $this->createAdmin();

		$this->signIn($admin);

		$group = make('Nova\Genres\RankGroup');

		$this->post(route('ranks.groups.store'), $group->toArray());

		$this->assertDatabaseHas('ranks_groups', ['name' => $group->name]);
	}

	/** @test **/
	public function all_rank_groups_can_be_updated()
	{
		$admin = $this->createAdmin();

		$this->signIn($admin);

		$group1 = create('Nova\Genres\RankGroup');
		$group2 = create('Nova\Genres\RankGroup');

		$group1->fill(['name' => "New Name"]);
		$group2->fill(['display' => (int) false]);

		$groupsData['groups'] = [
			$group1->toArray(),
			$group2->toArray(),
		];

		$this->patch(route('ranks.groups.update'), $groupsData);

		$this->assertDatabaseHas('ranks_groups', ['id' => $group1->id, 'name' => "New Name"]);
		$this->assertDatabaseHas('ranks_groups', ['id' => $group2->id, 'display' => (int) false]);
	}

	/** @test **/
	public function a_rank_group_can_be_deleted()
	{
		$admin = $this->createAdmin();

		$this->signIn($admin);

		$group = create('Nova\Genres\RankGroup');

		$this->delete(route('ranks.groups.destroy', [$group]));

		$this->assertDatabaseMissing('ranks_groups', ['id' => $group->id]);
	}

	/** @test **/
	public function a_rank_group_can_be_reordered()
	{
		$admin = $this->createAdmin();

		$this->signIn($admin);

		$group1 = create('Nova\Genres\RankGroup', ['order' => 0]);
		$group2 = create('Nova\Genres\RankGroup', ['order' => 1]);
		$group3 = create('Nova\Genres\RankGroup', ['order' => 2]);

		$response = $this->patch('/admin/ranks/groups/reorder', ['groups' => [$group2->id, $group3->id, $group1->id]]);

		$response->assertStatus(200);

		$this->assertDatabaseHas('ranks_groups', ['id' => $group2->id, 'order' => 0]);
		$this->assertDatabaseHas('ranks_groups', ['id' => $group3->id, 'order' => 1]);
		$this->assertDatabaseHas('ranks_groups', ['id' => $group1->id, 'order' => 2]);
	}

	/** @test **/
	public function a_rank_group_can_be_duplicated()
	{
		$admin = $this->createAdmin();

		$this->signIn($admin);

		$group = create('Nova\Genres\RankGroup');

		$response = $this->post(route('ranks.groups.duplicate', [$group]));

		$this->assertDatabaseHas('ranks_groups', ['name' => 'Copy of '.$group->name]);
	}
}
