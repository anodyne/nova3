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
use SplFileInfo;
use AdminBaseController;
use RankCatalogValidator;
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
			$finder = Finder::create()
				->directories()
				->in(APPPATH."assets/common/{$this->genre}/ranks")
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

	public function getSkins()
	{
		# code...
	}
	public function postSkins()
	{
		# code...
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