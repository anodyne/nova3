<?php namespace Nova\Setup\Controllers;

use App;
use Date;
use File;
use Form;
use HTML;
use Cache;
use Input;
use Config;
use Status;
use Artisan;
use Location;
use Redirect;
use Exception;
use RankModel;
use UserModel;
use Validator;
use SettingsModel;
use CharacterModel;
use AccessRoleModel;
use SiteContentModel;
use SystemRouteModel;
use RankCatalogModel;
use SkinCatalogModel;
use SystemEventModel;
use ModuleCatalogModel;
use WidgetCatalogModel;
use SetupBaseController;

class Install extends SetupBaseController {

	public function getIndex()
	{
		return Redirect::to('setup');
	}
	public function postIndex()
	{
		// Make sure we don't time out
		set_time_limit(0);

		// Run the migrations
		Artisan::call('migrate', ['--path' => 'nova/src/Nova/Setup/database/migrations']);

		// Get the session generator file
		$fileContents = File::get(SRCPATH.'Setup/generators/session.php');

		// Make sure we have something
		if ($fileContents !== false)
		{
			// Replace the type placeholder
			$contentToWrite = str_replace('#TYPE#', 'database', $fileContents);

			// Write the contents of the file
			$write = File::put(APPPATH.'config/'.App::environment().'/session.php', $contentToWrite);

			// If for some reason we can't write the file, we need to throw
			// an exception and explain what to do in order to fix it.
			if ( ! $write)
			{
				throw new Exception("The session config file couldn't be written to the server. Please manually create this file and upload it to app/config/".App::environment()."/session.php. The file should contain the contents from nova/src/Nova/Setup/generators/session.php with the #TYPE# placeholder changed to 'database'.");
			}
		}

		// Do the quick installs
		ModuleCatalogModel::install();
		RankCatalogModel::install();
		SkinCatalogModel::install();
		WidgetCatalogModel::install();
		
		// Clear the entire cache
		Cache::flush();

		// Cache the settings
		SettingsModel::cache();

		// Cache the routes
		SystemRouteModel::cache();

		// Cache the headers
		SiteContentModel::getSectionContent('header', 'main');
		SiteContentModel::getSectionContent('header', 'sim');
		SiteContentModel::getSectionContent('header', 'personnel');
		SiteContentModel::getSectionContent('header', 'search');
		SiteContentModel::getSectionContent('header', 'login');
		
		// Cache the titles
		SiteContentModel::getSectionContent('title', 'main');
		SiteContentModel::getSectionContent('title', 'sim');
		SiteContentModel::getSectionContent('title', 'personnel');
		SiteContentModel::getSectionContent('title', 'search');
		SiteContentModel::getSectionContent('title', 'login');
		
		// Cache the messages
		SiteContentModel::getSectionContent('message', 'main');
		SiteContentModel::getSectionContent('message', 'sim');
		SiteContentModel::getSectionContent('message', 'personnel');
		SiteContentModel::getSectionContent('message', 'search');
		SiteContentModel::getSectionContent('message', 'login');

		// Get all the records from the system events table
		$events = SystemEventModel::get();

		// Loop through and remote all the events
		foreach ($events as $e)
		{
			$e->delete();
		}

		// Create the only item we need in the system events table
		SystemEventModel::create([
			'ip'		=> $this->request->getClientIp(),
			'content'	=> Config::get('nova.app.name')." was successfully installed.",
		]);

		// Register
		# TODO: need to figure out how we want to do registration

		return Redirect::to('setup/install/settings');
	}

	public function getSettings()
	{
		// Set the views
		$this->_view = 'setup/install/settings';
		$this->_jsView = 'setup/install/settings_js';

		// Set the title and header
		$this->_title = 'Setup Center';
		$this->_header = 'Nova Setup';

		// Set the steps
		$this->_steps = 'setup/steps_install';

		// Get the rank we're using by default
		$defaultRank = SettingsModel::getSettings('rank');

		// Get the default rank set
		$rankSetLocation = RankCatalogModel::location($defaultRank)->first()->location;

		// Get the rank item
		$rank = RankModel::find(1);

		// Build the rank image
		$this->_data->defaultRank = Location::rank($rank->base, $rank->pip, $rankSetLocation);

		// Set the controls
		$this->_controls = Form::button('Submit', [
			'class'	=> 'btn btn-primary',
			'id'	=> 'next',
			'type'	=> 'submit',
		]).
		Form::token();
		Form::close();
	}
	public function postSettings()
	{
		// Set the validation rules
		$rules = array(
			'sim_name'			=> 'required',
			'name'				=> 'required',
			'email'				=> 'required|email',
			'password'			=> 'required',
			'password_confirm'	=> 'required|same:password',
			'first_name'		=> 'required',
			'position'			=> 'required',
			'rank'				=> 'required',
		);

		// Set the validation messages
		$messages = array(
			'sim_name.required'			=> "Please enter your sim's name",
			'name.required'				=> "Please enter your name",
			'email.required'			=> "Please enter your email address",
			'email.email'				=> "Please enter a valid email address",
			'password.required'			=> "Please enter a password",
			'password_confirm.required'	=> "Please enter your password again",
			'password_confirm.same'		=> "Your passwords do not match, try again",
			'first_name.required'		=> "Please enter your character's first name",
			'position.required'			=> "Please select a position",
			'rank.required'				=> "Please select a rank",
		);

		// Setup the validator
		$validator = Validator::make(Input::all(), $rules, $messages);

		// If the validation fails, stop and go back
		if ($validator->fails())
		{
			return Redirect::to('setup/install/settings')->withErrors($validator)->withInput();
		}

		// Update the sim name
		$simName = SettingsModel::getSettings('sim_name', false);
		$simName->update(['value' => e(Input::get('sim_name'))]);

		// Create the user
		$user = UserModel::create([
			'status'		=> Status::ACTIVE,
			'name'			=> e(Input::get('name')),
			'email'			=> e(Input::get('email')),
			'password'		=> e(Input::get('password')),
			'role_id'		=> AccessRoleModel::SYSADMIN,
			'activated_at'	=> Date::now(),
		]);

		// Update the preferences
		$user->updateUserPreferences([
			'is_sysadmin'		=> (int) true,
			'is_game_master'	=> (int) true,
		]);

		// Create the character
		$character = CharacterModel::create([
			'user_id'		=> $user->id,
			'status'		=> Status::ACTIVE,
			'first_name'	=> e(Input::get('first_name')),
			'last_name'		=> e(Input::get('last_name')),
			'rank_id'		=> e(Input::get('rank')),
			'activated_at'	=> Date::now(),
		]);

		// Add the character's position
		$character->positions()->attach(e(Input::get('position')), ['primary' => (int) true]);

		// Update the user with the character ID
		$user->character_id = $character->id;
		$user->save();

		return Redirect::to('setup/install/finalize');
	}

	public function getFinalize()
	{
		// Set the views
		$this->_view = 'setup/install/finalize';
		$this->_jsView = 'setup/install/finalize_js';

		// Set the title and header
		$this->_title = 'Setup Center';
		$this->_header = 'Nova Setup';

		// Set the steps
		$this->_steps = 'setup/steps_install';

		// Set the controls
		$this->_controls = HTML::link('/', 'Go to Main Page', ['class' => 'btn btn-primary']);
	}

}