<?php namespace Nova\Foundation\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class MakeExtensionCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $signature = 'nova:make:extension
							{vendor : The vendor name to be used for the containing directory}
							{name : The name of the extension}
							{--no-controllers : Do not include any controllers}
							{--no-lang : Do not include a default language file}
							{--no-provider : Do not include a service provider}
							{--no-views : Do not include any views}
							{--include-config : Create an empty config file}
							{--include-routes : Create an empty routes file}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Create a new extension skeleton.';

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
		// Grab the vendor and name and strip any spaces
		$vendor = str_replace(' ', '', $this->argument('vendor'));
		$name = str_replace(' ', '', $this->argument('name'));

		if (strtolower($vendor) == 'anodyne') {
			$this->error("You cannot create an extension within the Anodyne namespace. Please use your own namespace for your extension.");
		} else {
			// Build the new extension path
			$extensionPath = extension_path("{$vendor}/{$name}");

			// Does the directory already exists?
			if ($this->files->isDirectory($extensionPath)) {
				$this->error("The {$vendor}/{$name} directory already exists. Please choose another name for the extension.");
			} else {
				// Build up the list of things to replace
				$replacements = [
					'{ExtensionNamespace}' => "Extensions\\{$vendor}\\{$name}",
					'{ExtensionControllerName}' => ucfirst($name).'Controller',
					'{ExtensionVendorName}' => "{$vendor}/{$name}",
					'{ExtensionLowercaseVendorName}' => strtolower("{$vendor}/{$name}"),
					'{ExtensionProperName}' => $this->argument('name'),
					'{ExtensionName}' => $name,
					'{ExtensionLowercaseName}' => strtolower($name),
					'{ExtensionVendor}' => $this->argument('vendor'),
					'{ExtensionLowercaseVendor}' => strtolower($vendor),
					'{ExtensionKey}' => 'extension.'.strtolower($vendor).'.'.strtolower($name),
				];

				// Create the directory
				$this->files->makeDirectory($extensionPath, 0775, true);

				// Create the QuickInstall file
				$this->createFileFromStub('quickinstall', $replacements, $extensionPath, "extension.json");

				// Create an empty extension class
				$this->createFileFromStub('extension', $replacements, $extensionPath, "Extension.php");

				if ( ! $this->option('no-controllers')) {
					// Create the directory structure
					$this->files->makeDirectory("{$extensionPath}/Http/Controllers", 0775, true);

					$controllerStub = ($this->option('include-routes')) ? 'controller-no-page' : 'controller';

					// Create an empty controller
					$this->createFileFromStub($controllerStub, $replacements, $extensionPath.'/Http/Controllers', ucfirst($name).'Controller.php');
				}

				if ( ! $this->option('no-lang')) {
					// Create the directory structure
					$this->files->makeDirectory("{$extensionPath}/lang", 0775, true);

					// Create an empty view file
					$this->createFileFromStub('lang', $replacements, $extensionPath.'/lang', 'en.json');
				}

				if ( ! $this->option('no-views')) {
					// Create the directory structure
					$this->files->makeDirectory("{$extensionPath}/views/components/pages", 0775, true);

					// Create an empty view file
					$this->createFileFromStub('view', $replacements, $extensionPath.'/views/components/pages', strtolower($name).'.blade.php');
				}

				// Create an empty config file
				if ($this->option('include-config')) {
					$this->createFileFromStub('config', $replacements, $extensionPath, "config.php");
				}

				// Create an empty routes file
				if ($this->option('include-routes')) {
					$this->createFileFromStub('routes', $replacements, $extensionPath, "routes.php");
				}

				// Create an empty service provider
				if ( ! $this->option('no-provider')) {
					if ($this->option('no-views')) {
						$this->createFileFromStub('provider-no-views', $replacements, $extensionPath, "ServiceProvider.php");
					} else {
						$this->createFileFromStub('provider', $replacements, $extensionPath, "ServiceProvider.php");
					}
				}

				$this->info("Extension structure created!");
			}
		}
	}

	private function createFileFromStub($stub, array $replacements = [], $path, $fileName)
	{
		// Grab the content from the generator
		$content = $this->files->get(app_path("Foundation/Services/Extensions/stubs/{$stub}.stub"));

		if (count($replacements) > 0) {
			foreach ($replacements as $placeholder => $replacement) {
				$content = str_replace($placeholder, $replacement, $content);
			}
		}

		// Create the file and store the content
		$this->files->put("{$path}/{$fileName}", $content);
	}
}
