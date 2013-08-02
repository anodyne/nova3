<?php namespace Nova\Core\Controllers\Admin;

use File;
use User;
use View;
use Input;
use Sentry;
use Location;
use Redirect;
use Settings;
use RankCatalog;
use SkinCatalog;
use SplFileInfo;
use AdminBaseController;
use RankCatalogValidator;
use SkinCatalogValidator;
use Symfony\Component\Finder\Finder;

class Catalog extends AdminBaseController {

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
		Sentry::getUser()->allowed(['catalog.create', 'catalog.edit', 'catalog.delete'], true);

		// Set the JS view
		$this->_jsView = 'admin/catalog/ranks_js';

		if ($id !== false)
		{
			// Set the view
			$this->_view = 'admin/catalog/ranks_action';

			// Get the rank set
			$this->_data->rank = RankCatalog::find($id);

			// Set the action
			$this->_data->action = ((int) $id === 0) ? 'create' : 'update';
		}
		else
		{
			// Set the view
			$this->_view = 'admin/catalog/ranks';

			// Set the path to the ranks
			$this->_data->rankPath = "app/assets/common/{$this->genre}/ranks/";

			// Get all the ranks for the current genre
			$ranks = $this->_data->ranks = RankCatalog::currentGenre()->get();

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
				->with('modalBody', '')
				->with('modalFooter', false);

			// Build the install rank set modal
			$this->_ajax[] = View::make(Location::partial('common/modal'))
				->with('modalId', 'installRankSet')
				->with('modalHeader', lang('Short.install', ucwords(lang('rank_set'))))
				->with('modalBody', '')
				->with('modalFooter', false);
		}
	}
	public function postRanks()
	{
		// Get the action
		$action = e(Input::get('action'));

		// Get the current user
		$user = Sentry::getUser();

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
		if ($user->hasAccess('catalog.create') and $action == 'create')
		{
			// Create the rank set
			$item = RankCatalog::create(Input::all());

			// Set the flash info
			$flashStatus = ($item) ? 'success' : 'danger';
			$flashMessage = ($item) 
				? lang('Short.alert.success.create', lang('rank_set'))
				: lang('Short.alert.failure.create', lang('rank_set'));
		}

		/**
		 * Install a rank set.
		 */
		if ($user->hasAccess('catalog.create') and $action == 'install')
		{
			// Install the rank set
			$item = RankCatalog::install(e(Input::get('location')));

			// Set the flash info
			$flashStatus = 'success';
			$flashMessage = lang('Short.alert.success.install', lang('rank_set'));
		}

		/**
		 * Edit a rank set.
		 */
		if ($user->hasAccess('catalog.update') and $action == 'update')
		{
			// Get the ID
			$id = e(Input::get('id'));
			$id = (is_numeric($id)) ? $id : false;

			// Get the rank set
			$rank = RankCatalog::find($id);

			// Update the rank set
			$item = $rank->update(Input::all());

			// Set the flash info
			$flashStatus = ($item) ? 'success' : 'danger';
			$flashMessage = ($item) 
				? lang('Short.alert.success.update', lang('rank_set'))
				: lang('Short.alert.failure.update', lang('rank_set'));
		}

		/**
		 * Delete the rank set.
		 */
		if ($user->hasAccess('catalog.delete') and $action == 'delete')
		{
			// Get the ID
			$id = e(Input::get('id'));
			$id = (is_numeric($id)) ? $id : false;

			// Get the rank set
			$rank = RankCatalog::find($id);

			// Get the new rank set
			$newRankSet = e(Input::get('new_rank_set'));

			// Get all users
			$users = User::all();

			foreach ($users as $user)
			{
				// Filter the preferences to just the rank
				$pref = $user->preferences->filter(function($p)
				{
					return $p->key == 'rank';
				})->first();

				// Update the preference
				$pref->update(['value' => $newRankSet]);
			}

			// If the rank default is what we're deleting, change that as well
			if ($this->settings->rank == $rank->location)
			{
				Settings::updateItems(['rank' => $newRankSet]);
			}

			// Delete the rank set
			$item = $rank->delete();

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
		Sentry::getUser()->allowed(['catalog.create', 'catalog.edit', 'catalog.delete'], true);

		// Set the JS view
		$this->_jsView = 'admin/catalog/skins_js';

		if ($id !== false)
		{
			// Set the view
			$this->_view = 'admin/catalog/skins_action';

			// Get the skin
			$skin = $this->_data->skin = SkinCatalog::find($id);

			// Set the action
			$this->_data->action = ((int) $id === 0) ? 'create' : 'update';

			if ((int) $id !== 0 and File::exists(APPPATH."views/{$skin->location}/options.json"))
			{
				$optionsContent = File::get(APPPATH."views/{$skin->location}/options.json");

				$this->_data->options = json_decode($optionsContent);
			}
		}
		else
		{
			// Set the view
			$this->_view = 'admin/catalog/skins';

			// Get all the skins
			$skins = $this->_data->skins = SkinCatalog::active()->get();

			// Get a simple array of skins
			$simpleSkins = $skins->toSimpleArray('id', 'location');

			// Get the listing of the skins
			$finder = Finder::create()->directories()->in(APPPATH."views")->depth('== 0')
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
				if (File::exists(APPPATH."views/{$relativePath}/skin.json"))
				{
					// Get the contents of the QuickInstall file
					$skinContents = File::get(APPPATH."views/{$relativePath}/skin.json");

					$this->_data->pending[$relativePath] = json_decode($skinContents);
				}
			}

			// Build the delete skin modal
			$this->_ajax[] = View::make(Location::partial('common/modal'))
				->with('modalId', 'deleteSkin')
				->with('modalHeader', lang('Short.delete', lang('Skin')))
				->with('modalBody', '')
				->with('modalFooter', false);

			// Build the install skin modal
			$this->_ajax[] = View::make(Location::partial('common/modal'))
				->with('modalId', 'installSkin')
				->with('modalHeader', lang('Short.install', lang('Skin')))
				->with('modalBody', '')
				->with('modalFooter', false);

			// Build the update version skin modal
			$this->_ajax[] = View::make(Location::partial('common/modal'))
				->with('modalId', 'updateSkin')
				->with('modalHeader', lang('Short.update', lang('Skin')))
				->with('modalBody', '')
				->with('modalFooter', false);
		}
	}
	public function postSkins()
	{
		// Get the action
		$action = e(Input::get('action'));

		// Get the current user
		$user = Sentry::getUser();

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
		if ($user->hasAccess('catalog.create') and $action == 'create')
		{
			// Create the skin
			$item = SkinCatalog::create(Input::all());

			// Set the flash info
			$flashStatus = ($item) ? 'success' : 'danger';
			$flashMessage = ($item) 
				? lang('Short.alert.success.create', lang('skin'))
				: lang('Short.alert.failure.create', lang('skin'));
		}

		/**
		 * Install a skin.
		 */
		if ($user->hasAccess('catalog.create') and $action == 'install')
		{
			// Install the rank set
			$item = SkinCatalog::install(e(Input::get('location')));

			// Set the flash info
			$flashStatus = 'success';
			$flashMessage = lang('Short.alert.success.install', lang('skin'));
		}

		/**
		 * Update to a newer version of a skin.
		 */
		if ($user->hasAccess('catalog.update') and $action == 'version')
		{
			// Get the ID
			$id = e(Input::get('id'));
			$id = (is_numeric($id)) ? $id : false;

			// Get the skin
			$skin = SkinCatalog::find($id);

			// Update the skin
			$skin->applyUpdate();

			// Set the flash info
			$flashStatus = 'success';
			$flashMessage = lang('Short.alert.success.install', lang('skin'));
		}

		/**
		 * Edit a skin.
		 */
		if ($user->hasAccess('catalog.update') and $action == 'update')
		{
			// Get the ID
			$id = e(Input::get('id'));
			$id = (is_numeric($id)) ? $id : false;

			// Get the skin
			$skin = SkinCatalog::find($id);

			// Update the skin
			$item = $skin->update(Input::all());

			// Set the flash info
			$flashStatus = ($item) ? 'success' : 'danger';
			$flashMessage = ($item) 
				? lang('Short.alert.success.update', lang('skin'))
				: lang('Short.alert.failure.update', lang('skin'));
		}

		/**
		 * Delete the skin.
		 */
		if ($user->hasAccess('catalog.delete') and $action == 'delete')
		{
			// Get the ID
			$id = e(Input::get('id'));
			$id = (is_numeric($id)) ? $id : false;

			// Get the skin
			$skin = SkinCatalog::find($id);

			// Get the new skin
			$newSkin = e(Input::get('new_skin'));

			// Get all users
			$users = User::all();

			foreach ($users as $user)
			{
				// Filter the preferences to just the main skin
				$prefSkinMain = $user->preferences->filter(function($p)
				{
					return $p->key == 'skin_main';
				})->first();

				// Filter the preferences to just the admin skin
				$prefSkinAdmin = $user->preferences->filter(function($p)
				{
					return $p->key == 'skin_admin';
				})->first();

				// Update the preference
				$prefSkinMain->update(['value' => $newSkin]);
				$prefSkinAdmin->update(['value' => $newSkin]);
			}

			// If the main skin default is what we're deleting, change that as well
			if ($this->settings->skin_main == $skin->location)
			{
				Settings::updateItems(['skin_main' => $newSkin]);
			}

			// If the admin skin default is what we're deleting, change that as well
			if ($this->settings->skin_admin == $skin->location)
			{
				Settings::updateItems(['skin_admin' => $newSkin]);
			}

			// If the login skin default is what we're deleting, change that as well
			if ($this->settings->skin_login == $skin->location)
			{
				Settings::updateItems(['skin_login' => $newSkin]);
			}

			// Delete the skin
			$item = $skin->delete();

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

	public function getWidgets()
	{
		# code...
	}
	public function postWidgets()
	{
		# code...
	}

}