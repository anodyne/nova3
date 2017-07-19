<?php namespace Nova\Genres\Data;

use Nova\Genres\Rank;
use Nova\Foundation\Data\BindsData;
use Nova\Foundation\Data\Deletable;

class RankInfoDeletor implements Deletable
{
	use BindsData;

	public function delete($info)
	{
		// Delete the ranks associated with this info
		$info->ranks->each(function ($rank) {
			deletor(Rank::class)->delete($rank);
		});

		// Delete the rank info
		$info->delete();

		return $info;
	}
}
