<?php namespace Tests\Genres;

use Status;
use Nova\Genres\RankGroup;
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

		$item1 = create('Nova\Genres\Rank', ['group_id' => $group->id]);
		$item2 = create('Nova\Genres\Rank', ['group_id' => $group->id]);
		$item3 = create('Nova\Genres\Rank', ['group_id' => $group->id]);

		$this->delete(route('ranks.groups.destroy', [$group]));

		$this->assertDatabaseMissing('ranks_groups', ['id' => $group->id]);
		$this->assertDatabaseMissing('ranks', ['id' => $item1->id]);
		$this->assertDatabaseMissing('ranks', ['id' => $item2->id]);
		$this->assertDatabaseMissing('ranks', ['id' => $item3->id]);
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

		sleep(1);

		create('Nova\Genres\Rank', ['group_id' => $group->id]);
		create('Nova\Genres\Rank', ['group_id' => $group->id]);
		create('Nova\Genres\Rank', ['group_id' => $group->id]);

		$this->post(route('ranks.groups.duplicate', [$group]), [
			'base' => 'new-base.png',
			'name' => 'My New Group',
		]);

		$newGroup = RankGroup::latest()->first();

		$this->assertDatabaseHas('ranks_groups', ['name' => 'My New Group']);

		$this->assertCount(3, $newGroup->ranks->fresh());

		$this->assertDatabaseHas('ranks', ['group_id' => $newGroup->id, 'base' => 'new-base.png']);
	}

	/** @test **/
	public function has_no_errors()
	{
		$admin = $this->createAdmin();
		$this->signIn($admin);

		$this->get(route('ranks.groups.index'))->assertSuccessful();
		$this->get(route('ranks.groups.create'))->assertSuccessful();
	}
}
