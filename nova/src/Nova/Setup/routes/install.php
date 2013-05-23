<?php

Route::group(['prefix' => 'setup/install', 'before' => 'configFileCheck|setupAuthorization|csrf'], function()
{
	/**
	 * Nothing here, redirect to the start page.
	 */
	Route::get('/', function()
	{
		return Redirect::to('setup/start');
	});

	/**
	 * Do the install and cache some of the content.
	 */
	Route::post('/', function()
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
		ModuleCatalog::install();
		RankCatalog::install();
		SkinCatalog::install();
		WidgetCatalog::install();

		// Seed the database with dev data if necessary
		if (Config::get('nova.use_dev_data'))
		{
			//Artisan::call('db:seed');
		}
		
		// Clear the entire cache
		Cache::flush();

		// Cache the settings
		Cache::forever('nova.settings', Settings::get()->toSimpleObject('key', 'value'));

		// Cache the routes
		SystemRoute::cache();

		// Cache the headers
		SiteContent::getSectionContent('header', 'main');
		SiteContent::getSectionContent('header', 'sim');
		SiteContent::getSectionContent('header', 'personnel');
		SiteContent::getSectionContent('header', 'search');
		SiteContent::getSectionContent('header', 'login');
		
		// Cache the titles
		SiteContent::getSectionContent('title', 'main');
		SiteContent::getSectionContent('title', 'sim');
		SiteContent::getSectionContent('title', 'personnel');
		SiteContent::getSectionContent('title', 'search');
		SiteContent::getSectionContent('title', 'login');
		
		// Cache the messages
		SiteContent::getSectionContent('message', 'main');
		SiteContent::getSectionContent('message', 'sim');
		SiteContent::getSectionContent('message', 'personnel');
		SiteContent::getSectionContent('message', 'search');
		SiteContent::getSectionContent('message', 'login');

		// Register
		# TODO: need to figure out how we want to do registration

		return Redirect::to('setup/install/settings');
	});
	
	/**
	 * Provide the fields for setting up the sim.
	 */
	Route::get('settings', function()
	{
		$data = new stdClass;
		$data->view = 'install/settings';
		$data->jsView = 'install/settings_js';
		$data->title = 'Setup Center';
		$data->layout = new stdClass;
		$data->layout->label = 'Nova Setup';
		$data->controls = false;
		$data->steps = 'steps_install';
		$data->content = new stdClass;

		// Get the default rank set
		$rankSetLocation = RankCatalog::getDefault(true);

		// Get the rank item
		$rank = Rank::find(1);

		// Build the rank image
		$data->content->defaultRank = Location::rank($rank->base, $rank->pip, $rankSetLocation);

		// Set the controls
		$data->controls = Form::button('Submit', [
			'class'	=> 'btn btn-primary',
			'id'	=> 'next',
			'type'	=> 'submit',
		]).
		Form::token();
		Form::close();

		return setupTemplate($data);
	});

	/**
	 * Validate the data and if it passes, update the database.
	 */
	Route::post('settings', function()
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
		$simName = Settings::getItems('sim_name', false);
		$simName->value = e(Input::get('sim_name'));
		$simName->save();

		// Create the user
		$user = User::add([
			'status'		=> Status::ACTIVE,
			'name'			=> e(Input::get('name')),
			'email'			=> e(Input::get('email')),
			'password'		=> e(Input::get('password')),
			'role_id'		=> AccessRole::SYSADMIN,
			'activated_at'	=> Date::now(),
		], true);

		// Create the character
		$character = Character::add([
			'user_id'		=> $user->id,
			'status'		=> Status::ACTIVE,
			'first_name'	=> e(Input::get('first_name')),
			'last_name'		=> e(Input::get('last_name')),
			'rank_id'		=> e(Input::get('rank')),
			'activated_at'	=> Date::now(),
		], true);

		// Add the character's position
		$character->positions()->attach(e(Input::get('position')), ['primary' => (int) true]);

		// Update the user with the character ID
		$user->character_id = $character->id;
		$user->save();

		return Redirect::to('setup/install/finalize');
	});
	
	/**
	 * Confirm everything finished.
	 */
	Route::get('finalize', function()
	{
		$data = new stdClass;
		$data->view = 'install/finalize';
		$data->jsView = 'install/finalize_js';
		$data->title = 'Setup Center';
		$data->layout = new stdClass;
		$data->layout->label = 'Nova Setup';
		$data->controls = false;
		$data->steps = 'steps_install';
		$data->content = new stdClass;

		// Set the controls
		$data->controls = HTML::link('/', 'Go to Main Page', ['class' => 'btn btn-primary']);

		return setupTemplate($data);
	});
});