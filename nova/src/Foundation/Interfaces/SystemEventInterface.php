<?php namespace Nova\Core\Interfaces;

interface SystemEventInterface {

	public function cleanup($days);
	public function create();

}