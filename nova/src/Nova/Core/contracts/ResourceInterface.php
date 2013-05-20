<?php namespace Nova\Core\Contracts;

interface ResourceInterface {

	public function getEtag($regen = false);

	public function setResourceName($name);

	public function getResourceName();

}