<?php namespace Nova\Core\Contracts;

interface CollectionInterface {

	public function getEtags($regen = false);

	public function setCollectionName($name);

	public function getCollectionName();

}