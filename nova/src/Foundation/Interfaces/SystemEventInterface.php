<?php namespace Nova\Foundation\Interfaces;

interface SystemEventInterface {

	public function cleanup($days);
	public function create();

}