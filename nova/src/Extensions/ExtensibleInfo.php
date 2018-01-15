<?php namespace Nova\Extensions;

interface ExtensibleInfo
{
	public function getAuthor();
	public function getCredits($raw = false);
	public function getFullName();
	public function getLocation($raw = false);
	public function getVendor();
	public function getVersion();
}
