<?php namespace Nova\Core\Repositories\Eloquent;

use User;
use Settings;
use RankCatalog;
use SkinCatalog;
use SecurityTrait;
use CatalogRepositoryInterface;

class CatalogRepository implements CatalogRepositoryInterface {

	use SecurityTrait;

	public function allRanks()
	{
		return RankCatalog::currentGenre()->get();
	}

	public function allSkins()
	{
		return SkinCatalog::active()->get();
	}

	public function createRank(array $data)
	{
		return RankCatalog::create($data);
	}

	public function createSkin(array $data)
	{
		return SkinCatalog::create($data);
	}

	public function deleteRank($id, $newRank)
	{
		$id = $this->sanitizeInt($id);

		// Get the rank set
		$item = $this->find($id);

		if ($item)
		{
			$newRank = $this->sanitizeString($newRank);

			if ( ! $newRank)
				return false;

			// Get all users
			$users = User::all();

			foreach ($users as $user)
			{
				// Filter the preferences to just the rank
				$pref = $user->preferences->filter(function($p)
				{
					return $p->key == 'rank';
				})->first();

				// Update the preference
				$pref->update(['value' => $newRank]);
			}

			// If the rank default is what we're deleting, change that as well
			if (Settings::getSettings('rank') == $item->location)
			{
				Settings::updateItems(['rank' => $newRank]);
			}

			return $item->delete();
		}

		return false;
	}

	public function deleteSkin($id, $newSkin)
	{
		$id = $this->sanitizeInt($id);

		// Get the skin
		$item = $this->findSkin($id);

		if ($item)
		{
			$newSkin = $this->sanitizeString($newSkin);

			if ( ! $newSkin)
				return false;

			// Get all users
			$users = User::all();

			foreach ($users as $user)
			{
				// Filter the preferences to just the main skin
				$prefSkinMain = $user->preferences->filter(function($p)
				{
					return $p->key == 'skin_main';
				})->first();

				// Filter the preferences to just the admin skin
				$prefSkinAdmin = $user->preferences->filter(function($p)
				{
					return $p->key == 'skin_admin';
				})->first();

				// Update the preference
				$prefSkinMain->update(['value' => $newSkin]);
				$prefSkinAdmin->update(['value' => $newSkin]);
			}

			// If the main skin default is what we're deleting, change that as well
			if (Settings::getSettings('skin_main') == $item->location)
			{
				Settings::updateItems(['skin_main' => $newSkin]);
			}

			// If the admin skin default is what we're deleting, change that as well
			if (Settings::getSettings('skin_admin') == $item->location)
			{
				Settings::updateItems(['skin_admin' => $newSkin]);
			}

			// If the login skin default is what we're deleting, change that as well
			if (Settings::getSettings('skin_login') == $item->location)
			{
				Settings::updateItems(['skin_login' => $newSkin]);
			}

			return $item->delete();
		}

		return false;
	}

	public function findRank($id)
	{
		$id = $this->sanitizeInt($id);

		return RankCatalog::find($id);
	}

	public function findRankByLocation($location)
	{
		$location = $this->sanitizeString($location);

		return RankCatalog::currentGenre()->location($location)->first();
	}

	public function findSkin($id)
	{
		$id = $this->sanitizeInt($id);

		return SkinCatalog::find($id);
	}

	public function findSkinByLocation($location)
	{
		$location = $this->sanitizeString($location);

		return SkinCatalog::location($location)->first();
	}

	public function installRank($location)
	{
		$location = $this->sanitizeString($location);

		return RankCatalog::install($location);
	}

	public function installSkin($location)
	{
		$location = $this->sanitizeString($location);

		return SkinCatalog::install($location);
	}

	public function updateRank($id, array $data)
	{
		$id = $this->sanitizeInt($id);

		// Get the rank catalog
		$item = $this->findRank($id);

		if ($item)
			return $item->update($data);

		return false;
	}

	public function updateSkin($id, array $data)
	{
		$id = $this->sanitizeInt($id);

		// Get the skin catalog
		$item = $this->findSkin($id);

		if ($item)
			return $item->update($data);

		return false;
	}

	public function updateSkinVersion($id)
	{
		$id = $this->sanitizeInt($id);

		// Get the skin
		$item = $this->findSkin($id);

		if ($item)
			return $item->applyUpdate();

		return false;
	}

}