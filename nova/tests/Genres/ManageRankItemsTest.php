<?php namespace Tests\Genres;

use Status;
use Tests\DatabaseTestCase;

class ManageRankItemsTest extends DatabaseTestCase
{
	/** @test **/
	public function unauthorized_users_cannot_manage_rank_items()
	{
		$item = create('Nova\Genres\Rank');

		$this->withExceptionHandling();

		$this->get(route('ranks.items.index'))->assertRedirect(route('login'));
		$this->get(route('ranks.items.create'))->assertRedirect(route('login'));
		$this->post(route('ranks.items.store'))->assertRedirect(route('login'));
		$this->patch(route('ranks.items.update', $item))->assertRedirect(route('login'));
		$this->delete(route('ranks.items.destroy', $item))->assertRedirect(route('login'));
		$this->patch(route('ranks.items.reorder'))->assertRedirect(route('login'));
		$this->post(route('ranks.items.duplicate', $item))->assertRedirect(route('login'));

		$this->signIn();

		$this->get(route('ranks.items.index'))->assertStatus(403);
		$this->get(route('ranks.items.create'))->assertStatus(403);
		$this->post(route('ranks.items.store'))->assertStatus(403);
		$this->patch(route('ranks.items.update', $item))->assertStatus(403);
		$this->delete(route('ranks.items.destroy', $item))->assertStatus(403);
		$this->patch(route('ranks.items.reorder'))->assertStatus(403);
		$this->post(route('ranks.items.duplicate', $item))->assertStatus(403);
	}

	/** @test **/
	public function a_rank_can_be_created()
	{
		$admin = $this->createAdmin();

		$this->signIn($admin);

		$item = make('Nova\Genres\Rank');

		$this->post(route('ranks.items.store'), $item->toArray());

		$this->assertDatabaseHas('ranks', ['base' => $item->base, 'overlay' => $item->overlay]);
	}

	/** @test **/
	public function a_rank_can_be_updated()
	{
		$admin = $this->createAdmin();

		$this->signIn($admin);

		$item = create('Nova\Genres\Rank');

		$item->fill(['base' => "new-base.png"]);

		$this->patch(route('ranks.items.update', $item), $item->toArray());

		$this->assertDatabaseHas('ranks', ['id' => $item->id, 'base' => "new-base.png"]);
	}

	/** @test **/
	public function a_rank_can_be_deleted()
	{
		$admin = $this->createAdmin();

		$this->signIn($admin);

		$item = create('Nova\Genres\Rank');

		$this->delete(route('ranks.items.destroy', [$item]));

		$this->assertDatabaseMissing('ranks', ['id' => $item->id]);
	}

	/** @test **/
	public function ranks_can_be_reordered()
	{
		$admin = $this->createAdmin();

		$this->signIn($admin);

		$item1 = create('Nova\Genres\Rank', ['order' => 0]);
		$item2 = create('Nova\Genres\Rank', ['order' => 1]);
		$item3 = create('Nova\Genres\Rank', ['order' => 2]);

		$response = $this->patch('/admin/ranks/items/reorder', ['items' => [$item2->id, $item3->id, $item1->id]]);

		$response->assertStatus(200);

		$this->assertDatabaseHas('ranks', ['id' => $item2->id, 'order' => 0]);
		$this->assertDatabaseHas('ranks', ['id' => $item3->id, 'order' => 1]);
		$this->assertDatabaseHas('ranks', ['id' => $item1->id, 'order' => 2]);
	}

	/** @test **/
	public function a_rank_can_be_duplicated()
	{
		$admin = $this->createAdmin();

		$this->signIn($admin);

		$item = create('Nova\Genres\Rank');

		$response = $this->post(route('ranks.items.duplicate', [$item]));

		$this->assertDatabaseHas('ranks', []);
	}
}
