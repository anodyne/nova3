<?php namespace Nova\Core\System\Interfaces;

interface CatalogRepositoryInterface {

	public function allRanks();
	
	public function allSkins();

	public function createRank(array $data);

	public function createSkin(array $data);

	public function deleteRank($id, $newRank);

	public function deleteSkin($id, $newSkin);

	public function findRank($id);

	public function findRankByLocation($location);

	public function findSkin($id);

	public function findSkinByLocation($location);
	
	public function installRank($location);

	public function installSkin($location);

	public function updateRank($id, array $data);

	public function updateSkin($id, array $data);

	public function updateSkinVersion($id);

}