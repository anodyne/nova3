<?php namespace Nova\Aegis\Persistence;

interface PersistableInterface {

	public function generatePersistenceCode();

	public function getPersistenceCodes();

	public function addPersistenceCode($code);

	public function removePersistenceCode($code);

}