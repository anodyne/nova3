<?php namespace Nova\Extensions;

interface Extensible
{
	public function install();
	public function uninstall();
}
