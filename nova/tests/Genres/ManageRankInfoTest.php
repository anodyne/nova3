<?php namespace Tests\Genres;

use Tests\DatabaseTestCase;

class ManageRankInfoTest extends DatabaseTestCase
{
	/** @test **/
	public function unauthorized_users_cannot_manage_rank_info()
	{
		$info = create('Nova\Genres\RankInfo');

		$this->withExceptionHandling();

		$this->get(route('ranks.info.index'))->assertRedirect(route('login'));
		$this->get(route('ranks.info.create'))->assertRedirect(route('login'));
		$this->post(route('ranks.info.store'))->assertRedirect(route('login'));
		$this->patch(route('ranks.info.update'))->assertRedirect(route('login'));
		$this->delete(route('ranks.info.destroy', $info))->assertRedirect(route('login'));

		$this->signIn();

		$this->get(route('ranks.info.index'))->assertStatus(403);
		$this->get(route('ranks.info.create'))->assertStatus(403);
		$this->post(route('ranks.info.store'))->assertStatus(403);
		$this->patch(route('ranks.info.update'))->assertStatus(403);
		$this->delete(route('ranks.info.destroy', $info))->assertStatus(403);
	}

	/** @test **/
	public function rank_info_can_be_created()
	{
		$admin = $this->createAdmin();

		$this->signIn($admin);

		$info = make('Nova\Genres\RankInfo');

		$this->post(route('ranks.info.store'), $info->toArray());

		$this->assertDatabaseHas('ranks_info', ['name' => $info->name]);
	}

	/** @test **/
	public function all_rank_info_can_be_updated()
	{
		$admin = $this->createAdmin();

		$this->signIn($admin);

		$info1 = create('Nova\Genres\RankInfo');
		$info2 = create('Nova\Genres\RankInfo');

		$info1->fill(['name' => "New Name"]);
		$info2->fill(['short_name' => "NEW2"]);

		$infoData['info'] = [
			$info1->toArray(),
			$info2->toArray(),
		];

		$this->patch(route('ranks.info.update'), $infoData);

		$this->assertDatabaseHas('ranks_info', ['id' => $info1->id, 'name' => "New Name"]);
		$this->assertDatabaseHas('ranks_info', ['id' => $info2->id, 'short_name' => "NEW2"]);
	}

	/** @test **/
	public function rank_info_can_be_deleted()
	{
		$admin = $this->createAdmin();

		$this->signIn($admin);

		$info = create('Nova\Genres\RankInfo');

		$this->delete(route('ranks.info.destroy', [$info]));

		$this->assertDatabaseMissing('ranks_info', ['id' => $info->id]);
	}

	/** @test **/
	public function rank_info_can_be_reordered()
	{
		$admin = $this->createAdmin();

		$this->signIn($admin);

		$info1 = create('Nova\Genres\RankInfo', ['order' => 0]);
		$info2 = create('Nova\Genres\RankInfo', ['order' => 1]);
		$info3 = create('Nova\Genres\RankInfo', ['order' => 2]);

		$response = $this->patch('/admin/ranks/info/reorder', ['info' => [$info2->id, $info3->id, $info1->id]]);

		$response->assertStatus(200);

		$this->assertDatabaseHas('ranks_info', ['id' => $info2->id, 'order' => 0]);
		$this->assertDatabaseHas('ranks_info', ['id' => $info3->id, 'order' => 1]);
		$this->assertDatabaseHas('ranks_info', ['id' => $info1->id, 'order' => 2]);
	}
}
