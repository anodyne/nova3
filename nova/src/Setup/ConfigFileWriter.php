<?php namespace Nova\Setup;

use Illuminate\Filesystem\Filesystem;

class ConfigFileWriter
{
	protected $files;

	public function __construct(Filesystem $files)
	{
		$this->files = $files;
	}

	public function write($file, array $replacements = [], $fileToWrite = false)
	{
		// Grab the content from the generator
		$content = $this->files->get(app_path("Setup/stubs/{$file}.stub"));

		if (count($replacements) > 0) {
			foreach ($replacements as $placeholder => $replacement) {
				$content = str_replace($placeholder, $replacement, $content);
			}
		}

		$filename = ($fileToWrite) ?: $file;

		// Create the file and store the content
		$this->files->put(app()->appConfigPath("{$filename}.php"), $content);
	}
}
