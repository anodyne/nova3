<?php namespace Nova\Core\Controllers\Ajax;

use Str;
use File;
use Nova;
use View;
use Input;
use Config;
use Request;
use Location;
use AjaxBaseController;

class Add extends AjaxBaseController {

	/**
	 * Ban a user.
	 *
	 * @return	void
	 */
	public function getArc_banuser($id)
	{
		if ($this->auth->check() and $this->currentUser->hasAccess('ban.create'))
		{
			// get the user
			$user = \Model_User::find(\Security::xss_clean($id));

			// create the ban
			\Model_Ban::createItem(array(
				'level' => 1,
				'email' => $user->email,
			));

			\SystemEvent::add('user', '[[event.admin.arc.ban_user|{{1}}|{{'.$user->email.'}}]]');

			echo '<p class="alert alert-success">'.lang('[[short.flash.success|action.ban|action.created]]', 1).'</p>';
			echo '<div class="form-actions"><button class="btn close-dialog">'.lang('action.close', 1).'</button></div>';
		}
	}

	/**
	 * Add a field value to the database.
	 *
	 * @return	string
	 */
	public function postFormValue()
	{
		if ($this->auth->check() and $this->currentUser->hasAccess('form.update'))
		{
			$item = \NovaFormValue::create([
				'value'		=> Str::lower(e(Input::get('content'))),
				'content'	=> e(Input::get('content')),
				'field_id'	=> e(Input::get('field')),
				'order'		=> e(Input::get('order')),
			]);

			if ($item)
			{
				return partial('forms/field_value', [
					'value'	=> $item->value,
					'id'	=> $item->id,
					'icons'	=> Nova::getIconIndex(Nova::getSkin()),
				]);
			}
		}
	}

	/**
	 * Runs the QuickInstall for a module.
	 *
	 * @return	void
	 */
	public function getModule($module)
	{
		if ($this->auth->check() and $this->currentUser->hasAccess('catalog.create'))
		{
			// Do the quick install
			\Model_Catalog_Module::install($module);

			\SystemEvent::add('user', '[[event.admin.catalog.module_create|{{'.$module.'}}]]');

			echo '<p class="alert alert-success">'.lang('[[short.flash.success|module|action.installed]]').'</p>';
			echo '<div class="form-actions"><button class="btn close-dialog">'.lang('action.close', 1).'</button></div>';
		}
	}

	/**
	 * Confirm installing a rank set.
	 *
	 * @param	string	$location	The location of the rank set
	 * @return	void
	 */
	public function getRankSet($location)
	{
		if ($this->auth->check() and $this->currentUser->hasAccess('catalog.create'))
		{
			// Get the genre
			$genre = Config::get('nova.genre');

			// Get the contents of the QuickInstall file
			$rankContents = File::get(APPPATH."assets/common/{$genre}/ranks/{$location}/rank.json");

			return partial('common/modal_content', [
				'modalHeader'	=> lang('Short.install', ucwords(lang('rank_set'))),
				'modalBody'		=> View::make(Location::ajax('add/rankset'))
									->with('rank', json_decode($rankContents)),
				'modalFooter'	=> false,
			]);
		}
	}

	/**
	 * Show the confirmation modal for duplicating a route.
	 *
	 * @param	int		$id		The ID of the route being duplicated
	 * @return	View
	 */
	public function getRouteDuplicate($id)
	{
		if ($this->auth->check() and $this->currentUser->hasAccess('routes.create'))
		{
			// Resolve the class out of the IoC
			$class = Nova::resolveBinding('SystemRouteRepositoryInterface');
			
			// Get the original route
			$route = $class->find($id);

			if ($route)
			{
				return partial('common/modal_content', [
					'modalHeader'	=> lang('Short.duplicate', langConcat('Core Route')),
					'modalBody'		=> View::make(Location::ajax('add/route_duplicate'))->with('route', $route),
					'modalFooter'	=> false,
				]);
			}
		}
	}

	/**
	 * Duplicate a rank set.
	 *
	 * @param	int		the ID of the rank set being duplicated
	 * @return	void
	 */
	public function getRankgroup_duplicate($id)
	{
		if ($this->auth->check() and $this->currentUser->hasAccess('rank.create'))
		{
			$data['id'] = $id;
			$data['rank'] = \Model_Settings::getItems('rank');
			$data['genre'] = \Config::get('nova.genre');

			// read the directory for the dropdown
			$bases = \File::read_dir(APPPATH.'assets/common/'.$data['genre'].'/ranks/'.$data['rank'].'/base');

			if (is_array($bases) and count($bases) > 0)
			{
				// the first item should be empty
				$data['bases'][''] = '';

				// loop through the images
				foreach ($bases as $key => $location)
				{
					if (is_array($location))
					{
						// make sure the directory separators are right
						$key = str_replace('\\', '/', $key);

						// loop through the sub directory
						foreach ($location as $l)
						{
							// strip the image extension
							$image = substr_replace($l, '', strpos($l, '.'));

							// the image without extension is the value, with extension is displayed
							$data['bases'][$key.$image] = $key.$l;
						}
					}
					else
					{
						// strip the image extension
						$image = substr_replace($location, '', strpos($location, '.'));

						// the image without extension is the value, with extension is displayed
						$data['bases'][$image] = $location;
					}
				}
			}

			echo \View::forge(\Location::ajax('add/rankgroup_duplicate'), $data);
		}
	}

	/**
	 * Create a rank info record.
	 *
	 * @return	void
	 */
	public function getRankinfo()
	{
		if ($this->auth->check() and $this->currentUser->hasAccess('rank.create'))
		{
			// set the data
			$data['id'] = 0;
			$data['action'] = 'create';

			$data['name'] = '';
			$data['short_name'] = '';
			$data['order'] = '';
			$data['group'] = '';
			$data['display'] = 1;

			echo \View::forge(\Location::ajax('update/rankinfo'), $data);
		}
	}

	/**
	 * Duplicate an access role.
	 *
	 * @param	int		The ID of the role being duplicated
	 * @return	void
	 */
	public function getRole_duplicate()
	{
		if ($this->auth->check() and $this->currentUser->hasAccess('role.create'))
		{
			// Clean the variable
			$id = e(Request::segment(4, false));

			// Get the original role
			$role = \AccessRole::find($id);

			echo View::make(Location::ajax('add/role_duplicate'))
				->with('role', $role);
		}
	}

	/**
	 * Confirm installing a skin.
	 *
	 * @param	string	$location	The location of the skin
	 * @return	View
	 */
	public function getSkin($location)
	{
		if ($this->auth->check() and $this->currentUser->hasAccess('catalog.create'))
		{
			// Get the contents of the QuickInstall file
			$skinContents = File::get(APPPATH."views/{$location}/skin.json");

			return partial('common/modal_content', [
				'modalHeader'	=> lang('Short.install', lang('Skin')),
				'modalBody'		=> View::make(Location::ajax('add/skin'))
									->with('skin', json_decode($skinContents)),
				'modalFooter'	=> false,
			]);
		}
	}

	public function getSkinOptionImageUpload()
	{
		if ($this->auth->check() and ($this->currentUser->hasAccess('catalog.create')
				or $this->currentUser->hasAccess('catalog.update')))
		{
			if (Input::has('file'))
			{
				// Get the file
				$file = Input::file('file');

				// Move the file to the proper location
				$file->move(APPPATH."views/{skin}/{destination}", "{filename}");
			}
		}
	}

	/**
	 * Create a user record.
	 *
	 * @return	void
	 */
	public function getUser()
	{
		if ($this->auth->check() and $this->currentUser->hasAccess('user.create'))
		{
			echo \View::forge(\Location::ajax('add/user'));
		}
	}

}