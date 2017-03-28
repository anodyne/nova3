<?php namespace Nova\Foundation;

use Symfony\Component\Finder\Finder;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\FileLoader as BaseFileLoader;

class TranslationFileLoader extends BaseFileLoader
{
	protected $novaPath;
	protected $extensionPath;

	public function __construct(Filesystem $files, $path, $novaPath, $extensionPath)
	{
		parent::__construct($files, $path);

		$this->novaPath = $novaPath;
		$this->extensionPath = $extensionPath;
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
		$extensionLang = [];

		if ($this->files->exists($fullCore = "{$this->novaPath}/{$locale}.json")) {
			$novaLang = json_decode($this->files->get($fullCore), true);
		}

		$extensionLang = $this->loadExtensionLanguageFiles($locale);

		if ($this->files->exists($fullApp = "{$this->path}/{$locale}.json")) {
			$appLang = json_decode($this->files->get($fullApp), true);
		}

		return array_replace_recursive($novaLang, $extensionLang, $appLang);
	}

	protected function loadExtensionLanguageFiles($locale): array
	{
		// Start building the finder
		$finder = new Finder;

		/**
		 * Finder Criteria
		 *
		 * Must be a directory
		 * Must be in ./extensions
		 * Must not be the Override directory
		 * Must only be 2 levels deep (vendor and names)
		 */
		$finder->directories()
			->in($this->extensionPath)
			->exclude('Override')
			->depth('< 2');

		$langItems = collect();

		// Loop through whatever we have from the finder results
		foreach ($finder as $dir) {
			// Build the path to the extension language directory
			$langPath = join(DIRECTORY_SEPARATOR, [
				$this->extensionPath,
				$dir->getRelativePathName(),
				'lang',
				"{$locale}.json"
			]);
			
			// If there's a language file, decode it and add it to the array
			if ($this->files->exists($langPath)) {
				$langItems = $langItems->merge(collect(json_decode($this->files->get($langPath), true)));
			}
		}

		return $langItems->all();
	}
}
