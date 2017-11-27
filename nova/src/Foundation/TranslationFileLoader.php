<?php namespace Nova\Foundation;

use Symfony\Component\Finder\Finder;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\FileLoader as BaseFileLoader;

class TranslationFileLoader extends BaseFileLoader
{
	protected $novaPath;
	protected $novaLangItems = [];
	protected $appLangItems = [];

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

	public function getAppLangItems(): array
	{
		return $this->appLangItems;
	}

	public function getNovaLangItems(): array
	{
		return $this->novaLangItems;
	}

	protected function loadJsonPath($path, $locale)
	{
		$novaLang = [];
		$appLang = [];

		if ($this->files->exists($fullCore = "{$this->novaPath}/{$locale}.json")) {
			$this->novaLangItems = json_decode($this->files->get($fullCore), true);
		}

		if ($this->files->exists($fullApp = "{$this->path}/{$locale}.json")) {
			$this->appLangItems = json_decode($this->files->get($fullApp), true);
		}

		return array_replace_recursive($this->novaLangItems, $this->appLangItems);
	}
}
