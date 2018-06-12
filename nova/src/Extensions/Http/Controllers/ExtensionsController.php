<?php namespace Nova\Extensions\Http\Controllers;

use Controller;
use Symfony\Component\Finder\Finder;
use Nova\Extensions\SystemExtension;

class ExtensionsController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->middleware('auth');

		$this->views('admin', 'template');
	}

	public function index()
	{
		$this->data->extensionClass = $extensionClass = new SystemExtension;

		$this->authorize('manage', $extensionClass);

		$this->views('extensions.all-extensions', 'page');

		$this->setPageTitle("Extensions");

		// Get all of the installed extensions
		$this->data->extensions = $installedExtensions = SystemExtension::get();

		// Find all the directories in the extensions folder (except Override)
		$finder = Finder::create()
			->directories()
			->in(extension_path())
			->depth('== 1')
			->exclude('Override');

		// Start a new collection to store the paths
		$filesystemExtensions = collect();

		// Loop through the directories and add them to the collection
		foreach ($finder as $f) {
			$filesystemExtensions->push($f->getRelativePathname());
		}

		// Figure out the list of installed extensions with only their path
		$installedExtensions = $installedExtensions->map(function ($e) {
			return "{$e->vendor}/{$e->name}";
		});

		// Get the difference between what's in the database and what's on the
		// filesystem so we know which extensions haven't been installed yet
		$this->data->extensionsToBeInstalled = $filesystemExtensions->unique()->diff($installedExtensions);
	}

	public function create()
	{
		// Create a new extension

		// If we've come from an install button on index page, check for the
		// existence of some flash data that should help us create the new
		// extension properly.

		// If we haven't come from the install button on the index page, show
		// the various options for creating the file structure skeleton.

		// We need to make sure that we are checking for the existence of the
		// directory that we're trying to create.
	}

	public function store()
	{
		// Store the new extension in the database
	}

	public function edit()
	{
		// Edit an extension

		// Should we allow renaming an extension? If so, should we handle
		// re-naming the directory too?
	}

	public function update()
	{
		// Update the extension in the database
	}

	public function destroy()
	{
		// Delete the extension from the database
	}
}
