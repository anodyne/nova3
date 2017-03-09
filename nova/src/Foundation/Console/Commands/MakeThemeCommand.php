<?php namespace Nova\Foundation\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class MakeThemeCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $signature = 'nova:make:theme
							{name : The name of the theme}
							{--override-styles : Override all the styles and start from scratch}
							{--include-components : Generate the components directory structure with the most common items for overriding}
							{--include-options : Generate the options file}
							{--include-theme-class : Generate the Theme class for overriding}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Create a new theme skeleton.';

	/**
	 * The filesystem.
	 *
	 * @var	Filesystem
	 */
	protected $files;

	public function __construct(Filesystem $files)
	{
		parent::__construct();

		$this->files = $files;
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		$pathName = str_replace(' ', '', strtolower($this->argument('name')));

		// Build the new theme path
		$themePath = $this->laravel['path.theme']."/{$pathName}";

		// Does the directory already exists?
		if ($this->files->isDirectory($themePath)) {
			$this->error("The {$name} theme directory already exists. Please choose another name for the theme.");
		} else {
			// Build up the list of things to replace
			$replacements = [
				'{ThemeName}' => $this->argument('name'),
				'{ThemeLowercaseName}' => strtolower($pathName),
			];

			// Create the directory structure
			$this->files->makeDirectory($themePath, 0775, true);
			$this->files->makeDirectory($themePath."/design/css", 0775, true);

			// Create the QuickInstall file
			$this->createFileFromStub('quickinstall', $replacements, $themePath, "theme.json");

			// How do we want to handle styles?
			if ($this->option('override-styles')) {
				$this->createFileFromStub('style', $replacements, $themePath, "design/css/style.css");
			} else {
				$this->createFileFromStub('style-custom', $replacements, $themePath, "design/css/custom.css");
			}

			// Include some of the most used components for overriding
			if ($this->option('include-components')) {
				$this->files->makeDirectory($themePath."/components/js", 0775, true);
				$this->files->makeDirectory($themePath."/components/pages");
				$this->files->makeDirectory($themePath."/components/partials");
				$this->files->makeDirectory($themePath."/components/templates");
			}

			// Include the Theme class
			if ($this->option('include-theme-class')) {
				$this->createFileFromStub('theme', $replacements, $themePath, 'Theme.php');
			}

			// Include the options file
			if ($this->option('include-options')) {
				$this->createFileFromStub('options', $replacements, $themePath, 'options.json');
			}

			$this->info("Theme structure created!");
		}
	}

	private function createFileFromStub($stub, array $replacements = [], $path, $fileName)
	{
		// Grab the content from the generator
		$content = $this->files->get(app_path("Foundation/Themes/stubs/{$stub}.stub"));

		if (count($replacements) > 0) {
			foreach ($replacements as $placeholder => $replacement) {
				$content = str_replace($placeholder, $replacement, $content);
			}
		}

		// Create the file and store the content
		$this->files->put("{$path}/{$fileName}", $content);
	}
}
