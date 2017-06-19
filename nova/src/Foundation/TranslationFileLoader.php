<?php namespace Nova\Foundation;

use Symfony\Component\Finder\Finder;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\FileLoader as BaseFileLoader;

class TranslationFileLoader extends BaseFileLoader
{
	protected $novaPath;

	public function __construct(Filesystem $files, $path, $novaPath)
	{
		parent::__construct($files, $path);

		$this->novaPath = $novaPath;
	}

	public function load($locale, $group, $namespace = null)
	{
		if ($group == '*' && $namespace == '*') {
			return $this->loadJsonPath($this->path, $locale);
		}

		if (is_null($namespace) || $namespace == '*') {
			return $this->loadPath($this->path, $locale, $group);
		}

		return $this->loadNamespaced($locale, $group, $namespace);
	}

	protected function loadJsonPath($path, $locale)
	{
		$novaLang = [];
		$appLang = [];

		if ($this->files->exists($fullCore = "{$this->novaPath}/{$locale}.json")) {
			$novaLang = json_decode($this->files->get($fullCore), true);
		}

		if ($this->files->exists($fullApp = "{$this->path}/{$locale}.json")) {
			$appLang = json_decode($this->files->get($fullApp), true);
		}

		return array_replace_recursive($novaLang, $appLang);
	}
}
