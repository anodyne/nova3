<?php

namespace Nova\Themes;

use Symfony\Component\Finder\Finder;

abstract class Layout
{
	protected $key;
	protected $name;
	protected $image;
	protected $section;
	protected $options = [];

	public function getKey()
	{
		return $this->key;
	}

	public function getName()
	{
		return $this->name;
	}

	public function getImage()
	{
		$finder = (new Finder)
			->files()
			->in([
				base_path('assets/images'),
				theme_path(app('nova.theme')->path),
				resource_path('assets/images'),
				resource_path('assets/svg'),
			])
			->name($this->image);

		if (! $finder->hasResults()) {
			// TODO: Throw an exception
		}

		$iterator = $finder->getIterator();
		$iterator->rewind();

		$file = $iterator->current();

		return str_ireplace(base_path() . '/', '', $file->getPathname());
	}

	public function getSection()
	{
		return $this->section;
	}

	public function getOptions()
	{
		return $this->options;
	}
}
