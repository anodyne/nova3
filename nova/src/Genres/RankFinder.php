<?php namespace Nova\Genres;

use Nova\Settings\Settings;
use Symfony\Component\Finder\Finder;

class RankFinder
{
	public function getBaseImages()
	{
		// Set the path to the correct rank folder
		$rankPath = base_path('ranks/'.Settings::item('rank')->first()->value);

		// Get the base images
		$finderBaseImages = (new Finder)->files()->in("{$rankPath}/base");
		$baseImages = [];

		// 1_officers

		foreach ($finderBaseImages as $file) {
			$relativePath = str_replace('_', ' ', $file->getRelativePath());
			$relativePath = str_replace('\\', ' ', $relativePath);
			$relativePath = ucwords($relativePath);

			$pathName = str_replace('\\', '/', $file->getRelativePathname());

			$baseImages[$relativePath][] = $pathName;
		}

		krsort($baseImages);

		return collect($baseImages);
	}
}
