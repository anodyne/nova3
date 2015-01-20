<?php namespace Nova\Foundation\Services\Extensions;

interface Extensible {

	public function install();
	public function loadConfig();
	public function loadFileRoutes();
	public function uninstall();

}