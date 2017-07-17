<?php namespace Nova\Genres\Data;

use Nova\Foundation\Data\BindsData;
use Nova\Foundation\Data\Deletable;

class RankInfoDeletor implements Deletable
{
	use BindsData;

	public function delete($info)
	{
		// Delete the rank info
		$info->delete();

		return $info;
	}
}
