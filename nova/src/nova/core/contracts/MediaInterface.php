<?php namespace Nova\Core\Contracts;

interface MediaInterface {
	
	public function addMedia();

	public function getAllMedia();

	public function getMediaInfo();

	public function getMediaItem();

	public function removeMedia();

}