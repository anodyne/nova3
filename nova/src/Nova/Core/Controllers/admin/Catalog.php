<?php namespace Nova\Core\Controllers\Admin;

use File;
use View;
use Input;
use Media;
use Location;
use Redirect;
use SplFileInfo;
use AdminBaseController;
use RankCatalogValidator;
use SkinCatalogValidator;
use CatalogRepositoryInterface;
use SiteContentRepositoryInterface;
use Symfony\Component\Finder\Finder;

class Catalog extends AdminBaseController {

	public function __construct(SiteContentRepositoryInterface $content,
			CatalogRepositoryInterface $catalog)
	{
		parent::__construct($content);

		// Set the injected interfaces
		$this->catalog = $catalog;
	}

	public function getIndex()
	{
		$this->_view = 'admin/catalog/catalogs';
	}

	public function getModules()
	{
		# code...
	}
	public function postModules()
	{
		# code...
	}

	public function getRanks($id = false)
	{
		// Verify the user is allowed
		$this->currentUser->allowed(['catalog.create', 'catalog.edit', 'catalog.delete'], true);

		// Set the JS view
		$this->_jsView = 'admin/catalog/ranks_js';

		if ($id !== false)
		{
			// Set the view
			$this->_view = 'admin/catalog/ranks_action';

			// Set the ID
			$id = (is_numeric($id)) ? $id : 0;

			// Get the rank set
			$this->_data->rank = $this->catalog->findRank($id);

			// Set the action
			$this->_mode = $this->_data->action = ((int) $id === 0) ? 'create' : 'update';
		}
		else
		{
			// Set the view
			$this->_view = 'admin/catalog/ranks';

			// Set the path to the ranks
			$this->_data->rankPath = "app/assets/common/{$this->genre}/ranks/";

			// Get all the ranks for the current genre
			$ranks = $this->_data->ranks = $this->catalog->allRanks();

			// Get a simple array of ranks
			$simpleRanks = $ranks->toSimpleArray('id', 'location');

			// Get the listing of the current genre's ranks
			$finder = Finder::create()->directories()->in(APPPATH."assets/common/{$this->genre}/ranks")
				->depth('== 0')
				->filter(function(SplFileInfo $fileinfo) use ($simpleRanks)
				{
					if (in_array($fileinfo->getRelativePathName(), $simpleRanks))
					{
						return false;
					}
				});

			// Start the list of pending ranks
			$this->_data->pending = [];

			// Loop through the directories and get the info
			foreach ($finder as $f)
			{
				// Get a shorter version of the relative path name
				$relativePath = $f->getRelativePathName();

				// If we have a QuickInstall file, add it to the pending list
				if (File::exists(APPPATH."assets/common/{$this->genre}/ranks/{$relativePath}/rank.json"))
				{
					// Get the contents of the QuickInstall file
					$rankContents = File::get(APPPATH."assets/common/{$this->genre}/ranks/{$relativePath}/rank.json");

					$this->_data->pending[$relativePath] = json_decode($rankContents);
				}
			}

			// Build the delete rank set modal
			$this->_ajax[] = View::make(Location::partial('common/modal'))
				->with('modalId', 'deleteRankSet')
				->with('modalHeader', lang('Short.delete', ucwords(lang('rank_set'))))
				->with('modalBody', false)
				->with('modalFooter', false);

			// Build the install rank set modal
			$this->_ajax[] = View::make(Location::partial('common/modal'))
				->with('modalId', 'installRankSet')
				->with('modalHeader', lang('Short.install', ucwords(lang('rank_set'))))
				->with('modalBody', false)
				->with('modalFooter', false);
		}
	}
	public function postRanks()
	{
		// Get the action
		$action = e(Input::get('formAction'));

		// Set up the validation service
		$validator = new RankCatalogValidator;

		// If the validation fails, stop and go back
		if ( ! $validator->passes())
		{
			if ($action == 'delete' or $action == 'install')
			{
				// Set the flash message
				$flashMessage = lang('Short.validate', lang('action.failed')).'. ';
				$flashMessage.= implode(' ', $validator->getErrors()->all());

				return Redirect::to('admin/catalog/ranks')
					->with('flashStatus', 'danger')
					->with('flashMessage', $flashMessage);
			}
			
			return Redirect::back()->withInput()->withErrors($validator->getErrors());
		}

		/**
		 * Create a rank set.
		 */
		if ($this->currentUser->hasAccess('catalog.create') and $action == 'create')
		{
			// Create the rank set
			$item = $this->catalog->create(Input::all());

			// Set the flash info
			$flashStatus = ($item) ? 'success' : 'danger';
			$flashMessage = ($item) 
				? lang('Short.alert.success.create', lang('rank_set'))
				: lang('Short.alert.failure.create', lang('rank_set'));
		}

		/**
		 * Install a rank set.
		 */
		if ($this->currentUser->hasAccess('catalog.create') and $action == 'install')
		{
			// Install the rank set
			$item = $this->catalog->installRank(Input::get('location'));

			// Set the flash info
			$flashStatus = 'success';
			$flashMessage = lang('Short.alert.success.install', lang('rank_set'));
		}

		/**
		 * Edit a rank set.
		 */
		if ($this->currentUser->hasAccess('catalog.update') and $action == 'update')
		{
			// Update the rank set
			$item = $this->catalog->updateRank(Input::get('id'), Input::all());

			// Set the flash info
			$flashStatus = ($item) ? 'success' : 'danger';
			$flashMessage = ($item) 
				? lang('Short.alert.success.update', lang('rank_set'))
				: lang('Short.alert.failure.update', lang('rank_set'));
		}

		/**
		 * Delete the rank set.
		 */
		if ($this->currentUser->hasAccess('catalog.delete') and $action == 'delete')
		{
			// Delete the rank set
			$item = $this->catalog->deleteRank(Input::get('id'), Input::get('new_rank_set'));

			// Set the flash info
			$flashStatus = ($item) ? 'success' : 'danger';
			$flashMessage = ($item) 
				? lang('Short.alert.success.delete', lang('rank_set'))
				: lang('Short.alert.failure.delete', lang('rank_set'));
		}

		return Redirect::to("admin/catalog/ranks")
			->with('flashStatus', $flashStatus)
			->with('flashMessage', $flashMessage);
	}

	public function getSkins($id = false)
	{
		// Verify the user is allowed
		$this->currentUser->allowed(['catalog.create', 'catalog.edit', 'catalog.delete'], true);

		// Set the JS view
		$this->_jsView = 'admin/catalog/skins_js';

		// Pass some data to the javascript view
		$this->_jsData->id = $id;
		$this->_jsData->uploadSize = Media::getFileSizeLimit();
		$this->_jsData->acceptedFiles = Media::getFileFormats('csv');

		if ($id !== false)
		{
			// Set the view
			$this->_view = 'admin/catalog/skins_action';

			// Set the ID
			$id = (is_numeric($id)) ? $id : 0;

			// Get the skin
			$skin = $this->_data->skin = $this->catalog->findSkin($id);

			// Set the action
			$this->_mode = $this->_data->action = ((int) $id === 0) ? 'create' : 'update';

			if ((int) $id !== 0 and File::exists(APPPATH."skins/{$skin->location}/options.json"))
			{
				$optionsContent = File::get(APPPATH."skins/{$skin->location}/options.json");

				$this->_data->options = json_decode($optionsContent);
			}
		}
		else
		{
			// Set the view
			$this->_view = 'admin/catalog/skins';

			// Get all the skins
			$skins = $this->_data->skins = $this->catalog->allSkins();

			// Get a simple array of skins
			$simpleSkins = $skins->toSimpleArray('id', 'location');

			// Get the listing of the skins
			$finder = Finder::create()->directories()->in(APPPATH."skins")->depth('== 0')
				->filter(function(SplFileInfo $fileinfo) use ($simpleSkins)
				{
					if (in_array($fileinfo->getRelativePathName(), $simpleSkins))
					{
						return false;
					}
				});

			// Start the list of pending ranks
			$this->_data->pending = [];

			// Loop through the directories and get the info
			foreach ($finder as $f)
			{
				// Get a shorter version of the relative path name
				$relativePath = $f->getRelativePathName();

				// If we have a QuickInstall file, add it to the pending list
				if (File::exists(APPPATH."skins/{$relativePath}/skin.json"))
				{
					// Get the contents of the QuickInstall file
					$skinContents = File::get(APPPATH."skins/{$relativePath}/skin.json");

					$this->_data->pending[$relativePath] = json_decode($skinContents);
				}
			}

			// Build the delete skin modal
			$this->_ajax[] = View::make(Location::partial('common/modal'))
				->with('modalId', 'deleteSkin')
				->with('modalHeader', lang('Short.delete', lang('Skin')))
				->with('modalBody', false)
				->with('modalFooter', false);

			// Build the install skin modal
			$this->_ajax[] = View::make(Location::partial('common/modal'))
				->with('modalId', 'installSkin')
				->with('modalHeader', lang('Short.install', lang('Skin')))
				->with('modalBody', false)
				->with('modalFooter', false);
		}
	}
	public function postSkins()
	{
		// Get the action
		$action = e(Input::get('formAction'));

		// Set up the validation service
		$validator = new SkinCatalogValidator;

		// If the validation fails, stop and go back
		if ( ! $validator->passes())
		{
			if ($action == 'delete' or $action == 'install' or $action == 'version')
			{
				// Set the flash message
				$flashMessage = lang('Short.validate', lang('action.failed')).'. ';
				$flashMessage.= implode(' ', $validator->getErrors()->all());

				return Redirect::to('admin/catalog/skins')
					->with('flashStatus', 'danger')
					->with('flashMessage', $flashMessage);
			}
			
			return Redirect::back()->withInput()->withErrors($validator->getErrors());
		}

		/**
		 * Create a skin.
		 */
		if ($this->currentUser->hasAccess('catalog.create') and $action == 'create')
		{
			// Create the skin
			$item = $this->catalog->createSkin(Input::all());

			// Set the flash info
			$flashStatus = ($item) ? 'success' : 'danger';
			$flashMessage = ($item) 
				? lang('Short.alert.success.create', lang('skin'))
				: lang('Short.alert.failure.create', lang('skin'));
		}

		/**
		 * Install a skin.
		 */
		if ($this->currentUser->hasAccess('catalog.create') and $action == 'install')
		{
			// Install the rank set
			$item = $this->catalog->installSkin(Input::get('location'));

			// Set the flash info
			$flashStatus = 'success';
			$flashMessage = lang('Short.alert.success.install', lang('skin'));
		}

		/**
		 * Update to a newer version of a skin.
		 */
		if ($this->currentUser->hasAccess('catalog.update') and $action == 'version')
		{
			// Update the version of the skin
			$this->catalog->updateSkinVersion(Input::get('id'));

			// Set the flash info
			$flashStatus = 'success';
			$flashMessage = lang('Short.alert.success.install', lang('skin'));
		}

		/**
		 * Edit a skin.
		 */
		if ($this->currentUser->hasAccess('catalog.update') and $action == 'update')
		{
			// Update the skin
			$item = $this->catalog->updateSkin(Input::get('id'), Input::all());

			// Set the flash info
			$flashStatus = ($item) ? 'success' : 'danger';
			$flashMessage = ($item) 
				? lang('Short.alert.success.update', lang('skin'))
				: lang('Short.alert.failure.update', lang('skin'));
		}

		/**
		 * Delete the skin.
		 */
		if ($this->currentUser->hasAccess('catalog.delete') and $action == 'delete')
		{
			// Delete the skin
			$item = $this->catalog->deleteSkin(Input::get('id'), Input::get('new_skin'));

			// Set the flash info
			$flashStatus = ($item) ? 'success' : 'danger';
			$flashMessage = ($item) 
				? lang('Short.alert.success.delete', lang('skin'))
				: lang('Short.alert.failure.delete', lang('skin'));
		}

		return Redirect::to("admin/catalog/skins")
			->with('flashStatus', $flashStatus)
			->with('flashMessage', $flashMessage);
	}
	public function postSkinsUpload($id)
	{
		if ($this->currentUser->hasAccess('catalog.update'))
		{
			// Get the ID
			$id = (is_numeric($id)) ? $id : false;

			// Get the skin catalog
			$skin = $this->catalog->find($id);

			if ($skin)
			{
				// Set the model we're using for uploading
				Media::setModel($skin);

				// Get the options from the file
				$qiOptions = $skin->getQuickInstallFile('options.json');

				if ($qiOptions !== false)
				{
					// Get the upload key header
					$header = $this->request->header('Upload-Key');

					// Get the option we're dealing with
					$optionArr = array_filter($qiOptions->items, function($o) use($header)
					{
						return $o->key == $header;
					});

					if (count($optionArr) > 0)
					{
						// Get the first item
						$item = reset($optionArr);

						// Set where to put the file
						$destination = APPPATH."skins/{$skin->location}/";
						$destination = (isset($item->location))
							? $destination.$item->location
							: $destination;

						// Upload the file
						$upload = Media::add($item->filename, $destination, ['key' => $header]);
					}
				}
			}
		}
	}

	public function getWidgets()
	{
		# code...
	}
	public function postWidgets()
	{
		# code...
	}

}