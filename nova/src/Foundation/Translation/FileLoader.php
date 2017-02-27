<?php namespace Nova\Foundation\Translation;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\FileLoader as BaseFileLoader;

class FileLoader extends BaseFileLoader {

	protected $corePath;

	public function __construct(Filesystem $files, $path, $corePath)
	{
		parent::__construct($files, $path);

		$this->corePath = $corePath;
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
		$coreLang = [];
		$appLang = [];

		if ($this->files->exists($fullCore = "{$this->corePath}/{$locale}.json")) {
			$coreLang = json_decode($this->files->get($fullCore), true);
		}

		if ($this->files->exists($fullApp = "{$this->path}/{$locale}.json")) {
			$appLang = json_decode($this->files->get($fullApp), true);
		}

		return array_replace_recursive($coreLang, $appLang);
	}
}