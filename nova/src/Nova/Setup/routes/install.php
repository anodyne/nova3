<?php

Route::group(array('prefix' => 'setup/install', 'before' => 'configFileCheck|setupAuthorization|csrf'), function()
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
		Artisan::call('migrate', array('--path' => 'nova/src/Nova/Setup/database/migrations'));

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
		$data->controls = Form::button('Submit', array(
			'class'	=> 'btn btn-primary',
			'id'	=> 'next',
			'type'	=> 'submit',
		)).
		Form::hidden('_token', csrf_token()).
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
			'sim_name.required' => "Please enter your sim's name",
			'name.required' => "Please enter your name",
			'email.required' => "Please enter your email address",
			'email.email' => "Please enter a valid email address",
			'password.required' => "Please enter a password",
			'password_confirm.required' => "Please enter your password again",
			'password_confirm.same' => "Your passwords do not match, try again",
			'first_name.required' => "Please enter your character's first name",
			'position.required' => "Please select a position",
			'rank.required' => "Please select a rank",
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
		$simName->value = Input::get('sim_name');
		$simName->save();

		// Create the user
		$user = User::add(array(
			'status'	=> Status::ACTIVE,
			'name'		=> Input::get('name'),
			'email'		=> Input::get('email'),
			'password'	=> Input::get('password'),
			'role_id'	=> AccessRole::SYSADMIN,
		), true);

		// Create the character
		$character = Character::add(array(
			'user_id'		=> $user->id,
			'status'		=> Status::ACTIVE,
			'first_name'	=> Input::get('first_name'),
			'last_name'		=> Input::get('last_name'),
			'rank_id'		=> Input::get('rank'),
			'activated'		=> Date::now()->toDateTimeString(),
		), true);

		// Add the character's position
		$character->positions()->attach(Input::get('position'), array('primary' => (int) true));

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
		$data->controls = Html::link('main/index', 'Go to Main Page', array('class' => 'btn btn-primary'));

		return setupTemplate($data);
	});
});