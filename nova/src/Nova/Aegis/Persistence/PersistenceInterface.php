<?php namespace Nova\Aegis\Persistence;

interface PersistenceInterface {

	public function check();

	public function add(PersistableInterface $persistable, $remember = false);

	public function addAndRemember(PersistableInterface $persistable);

	public function remove(PersistableInterface $persistable);

	public function flush(PersistableInterface $persistable);

}