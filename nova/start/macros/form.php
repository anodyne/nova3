<?php

/**
 * Builds a select menu that includes all of the characters from
 * the database based on the parameters passed to the method.
 *
 * @param	string	Name of the select menu
 * @param	int 	Selected item
 * @param	array	Extra attributes to be added to the select menu
 * @param	string	Which characters to pull
 * @param	bool	Split characters up by whether they're linked or not (default: false)
 * @return	string
 */
Form::macro('characters', function($name, $selected = null, $options = array(), $status = Status::ACTIVE, $showLinked = false)
{
	switch ($status)
	{
		case Status::ACTIVE:
			$characters = Character::active()->get();
		break;

		case Status::INACTIVE:
			$characters = Character::inactive()->get();
		break;

		case Status::PENDING:
			$characters = Character::pending()->get();
		break;

		case Status::UNASSIGNED:
			$characters = Character::npc()->get();
		break;
		
		default:
			$characters = Character::get();
		break;
	}
	
	if (count($characters) > 0)
	{
		$characterList[0] = '';
		
		foreach ($characters as $c)
		{
			if ($showLinked)
			{
				$sub = ($c->hasUser()) ? langConcat('Linked Characters') : langConcat('Unlinked Characters');

				$characterList[$sub][$c->id] = $c->getNameWithRank();
			}
			else
			{
				$characterList[$c->id] = $c->getNameWithRank();
			}
		}

		return Form::select($name, $characterList, $selected, $options);
	}

	return partial('common/alert', [
		'class'		=> 'alert-danger',
		'content'	=> lang('error.notFound', lang('characters'))
	]);
});

/**
 * Builds a select menu that includes all of the positions from
 * the database based on the parameters passed to the method.
 *
 * @param	string	The name of the select menu
 * @param	mixed 	Selected items
 * @param	array	Extra attributes to be added to the select menu
 * @return	string
 */
Form::macro('department', function($name, $selected = null, $options = array())
{
	// Grab the departments
	$depts = Dept::all();

	// Make sure we have items
	if ($depts->count() > 0)
	{
		// Start with an empty item
		$list[0] = '';
		
		// Loop through the departments
		foreach ($depts as $d)
		{
			// Figure out if we should have optgroups or not
			if ($d->manifest)
			{
				$list[$d->manifest->name][$d->id] = $d->name;
			}
			else
			{
				$list[$d->id] = $d->name;
			}
		}

		return Form::select($name, $list, $selected, $options);
	}
	
	return false;
});

/**
 * Builds a select menu of available languages.
 *
 * @param	string	Name of the select menu
 * @param	int 	Selected items
 * @param	array	Extra attributes to be added to the select menu
 * @return	string
 */
Form::macro('languages', function($name, $selected = null, $options = array())
{
	// An array of languages
	$languages = array(
		'ar' => 'arabic',
		'az' => 'azeri',
		'bg' => 'bulgarian',
		'bn' => 'bengali',
		'cs' => 'czech',
		'cy' => 'welsh',
		'da' => 'danish',
		'de' => 'german',
		'en' => 'english',
		'es' => 'spanish',
		'et' => 'estonian',
		'fa' => 'farsi',
		'fi' => 'finnish',
		'fr' => 'french',
		'ha' => 'hausa',
		'hi' => 'hindi',
		'hr' => 'croatian',
		'hu' => 'hungarian',
		'id' => 'indonesian',
		'is' => 'icelandic',
		'it' => 'italian',
		'kk' => 'kazakh',
		'ky' => 'kyrgyz',
		'la' => 'latin',
		'lt' => 'lithuanian',
		'lv' => 'latvian',
		'mk' => 'macedonian',
		'mn' => 'mongolian',
		'ne' => 'nepali',
		'nl' => 'dutch',
		'no' => 'norwegian',
		'pl' => 'polish',
		'ps' => 'pashto',
		'pt' => 'portuguese',
		'ro' => 'romanian',
		'ru' => 'russian',
		'sk' => 'slovak',
		'sl' => 'slovene',
		'so' => 'somali',
		'sq' => 'albanian',
		'sr' => 'serbian',
		'sv' => 'swedish',
		'sw' => 'swahili',
		'tl' => 'tagalog',
		'tr' => 'turkish',
		'uk' => 'ukrainian',
		'ur' => 'urdu',
		'uz' => 'uzbek',
		'vi' => 'vietnamese',
	);

	// Create a new finder
	$finder = new Symfony\Component\Finder\Finder();

	// Set what we're looking for
	$finder->directories()->in(APPPATH.'lang');

	// Loop through the directories
	foreach ($finder as $f)
	{
		$code = $f->getRelativePathName();

		if (array_key_exists($code, $languages))
		{
			$list[$code] = ucfirst($languages[$code]);
		}
	}

	return Form::select($name, $list, $selected, $options);
});

/**
 * Builds a select menu that includes all of the positions from
 * the database based on the parameters passed to the method.
 *
 * @param	string	name of the select menu
 * @param	int 	Selected items
 * @param	array	Extra attributes to be added to the select menu
 * @param	string	The positions to pull (all, open, or a department ID)
 * @param	bool	Just the select menu? (default: false)
 * @return	string
 */
Form::macro('position', function($name, $selected = null, $options = array(), $type = 'all', $selectOnly = false)
{
	if (is_numeric($type))
	{
		$positions = Position::getItems('all', $type);
	}
	elseif (is_string($type))
	{
		$positions = Position::getItems($type);
	}
	else
	{
		$positions = Position::getItems();
	}

	if ($positions->count() > 0)
	{
		// The first element should be blank
		$list[''] = '';
		
		// Loop through the positions and put them in a format we can use
		foreach ($positions as $p)
		{
			if ( ! is_numeric($type))
			{
				$list[$p->dept->name][$p->id] = $p->name;
			}
			else
			{
				$list[$p->id] = $p->name;
			}
		}

		if ($selectOnly)
		{
			return Form::select($name, $list, $selected, $options);
		}

		// Merge the user options into what should be there
		$options = array_merge(['id' => 'positionDrop', 'class' => 'form-control'], $options);

		// Build the output
		$output = '<div class="row"><div class="col-sm-6 col-lg-4">';
		$output.= '<div class="form-group"><label class="control-label">'.lang('Position').'</label>';
		$output.= Form::select($name, $list, $selected, $options);
		$output.= '</div></div><div class="col-sm-6 col-lg-8">';
		$output.= '<div id="positionDesc" class="help-block"><label class="control-label">&nbsp;</label>';
		$output.= '<div id="positionDescInner"></div>';
		$output.= '<div class="hide" id="positionLoader">'.HTML::image('nova/views/design/images/loading.gif').'</div>';

		if (is_numeric($selected))
		{
			$output.= Markdown::parse(Position::find($selected)->desc);
		}

		$output.= '</div></div></div>';

		return $output;
	}
	
	return false;
});

/**
 * Builds a select menu that includes all of the ranks from
 * the database based on the parameters passed to the method.
 *
 * @param	string	Name of the select menu
 * @param	int 	Selected item
 * @param	array	Extra attributes to add to the select menu
 * @param	bool	Just show the select menu? (default: false)
 * @return	string
 */
Form::macro('rank', function($name, $selected = null, $options = array(), $selectOnly = false)
{
	// Grab the rank groups
	$groups = RankGroup::active()->orderAsc('order')->get();

	if ($groups->count() > 0)
	{
		foreach ($groups as $g)
		{
			foreach ($g->ranks as $r)
			{
				$list[$g->name][$r->id] = $r->info->name;
			}
		}

		if ($selectOnly)
		{
			return Form::select($name, $list, $selected, $options);
		}

		// Merge the user options into what should be there
		$options = array_merge(array('id' => 'rankDrop', 'class' => 'col-lg-4'), $options);

		// Build the output
		$output = '<div class="form-group"><label class="control-label">'.ucfirst(lang('base.rank')).'</label><div class="controls">';
		$output.= Form::select($name, $list, $selected, $options);
		$output.= '<div id="rankImg" class="help-block"></div>';

		if (is_numeric($selected))
		{
			// Get the rank
			$rank = Rank::find($selected);

			$output.= Location::rank($rank->base, $rank->pip);
		}

		$output.= '</div></div>';

		return $output;
	}
	
	return false;
});

/**
 * Builds a select menu that includes all of the access roles from
 * the database based on the parameters passed to the method.
 *
 * @param	string	Name of the select menu
 * @param	int 	Selected item
 * @param	array	Extra attributes to add to the select menu
 * @param	bool	Just show the select menu? (default: false)
 * @return	string
 */
Form::macro('roles', function($name, $selected = null, $options = array(), $selectOnly = false)
{
	// Get the access roles
	$roles = AccessRole::get()->toSimpleArray('id', 'name');

	if (count($roles) > 0)
	{
		if ($selectOnly)
		{
			return Form::select($name, $roles, $selected, $options);
		}

		// Merge the user options into what should be there
		$options = array_merge(array('id' => 'roleDrop', 'class' => 'col-lg-4'), (array) $options);

		// Build the output
		$output = '<div class="form-group"><label class="control-label">'.ucwords(lang('base.access_role')).'</label><div class="controls">';
		$output.= Form::select($name, $roles, $selected, $options);
		$output.= '<div id="roleDesc" class="help-block">';

		if (is_numeric($selected))
		{
			$output.= Markdown::parse(AccessRole::find($selected)->desc);
		}

		$output.= '</div></div></div>';

		return $output;
	}

	return false;
});

/**
 * Builds a select menu that includes all timezones supported in PHP.
 *
 * @param	string	Name of the select menu
 * @param	int 	Selected item
 * @param	array	Extra attributes to be added to the select menu
 * @return	string
 */
Form::macro('timezones', function($name, $selected = null, $options = array())
{
	// Get the timezone information
	$zones = timezone_identifiers_list();

	// Make sure UTC is in the list
	$locations['UTC'] = 'UTC';

	foreach ($zones as $zone)
	{
		// Break out the zones into contintent and city
		$zone = explode('/', $zone);

		// Only use "friendly" continent names
		if ($zone[0] == 'Africa' or $zone[0] == 'America' or $zone[0] == 'Antarctica' or $zone[0] == 'Arctic' or 
				$zone[0] == 'Asia' or $zone[0] == 'Atlantic' or $zone[0] == 'Australia' or $zone[0] == 'Europe' or 
				$zone[0] == 'Indian' or $zone[0] == 'Pacific')
		{
			if (isset($zone[1]) != '')
			{
				// Create an array with the zone and the friendly name
				$locations[$zone[0]][$zone[0].'/'.$zone[1]] = str_replace('_', ' ', $zone[1]);
			}
		}
	}

	// Merge the user options into what should be there
	$options = array_merge(array('class' => 'col-lg-4'), (array) $options);

	return Form::select($name, $locations, $selected, $options);
});

/**
 * Builds a select menu that includes all of the users from
 * the database based on the parameters passed to the method.
 *
 * @param	string	Name of the select menu
 * @param	int 	Selected item
 * @param	array	Extra attributes to be added to the select menu
 * @param	int		The status of the users to retrieve
 * @return	string
 */
Form::macro('users', function($name, $selected = null, $options = array(), $status = Status::ACTIVE)
{
	switch ($status)
	{
		case Status::ACTIVE:
			$users = User::active()->get()->toSimpleArray('id', 'name');
		break;

		case Status::INACTIVE:
			$users = User::inactive()->get()->toSimpleArray('id', 'name');
		break;

		case Status::PENDING:
			$users = User::pending()->get()->toSimpleArray('id', 'name');
		break;
		
		default:
			$users = User::get()->toSimpleArray('id', 'name');
		break;
	}

	s($users);
	
	if (count($users) > 0)
	{
		// Build the list of users
		$usersList = array(0 => '') + $users;
		
		return Form::select($name, $usersList, $selected, $options);
	}

	return partial('common/alert', [
		'class'		=> 'alert-danger',
		'content'	=> lang('error.notFound', lang('base.users')),
	]);
});

Form::macro('suggest', function($name, $data, $selected, $options)
{
	// Set the attributes
	$attributes = HTML::attributes(array(
		'id' => (isset($options['id'])) ? $options['id'] : '',
		'class' => (isset($options['class'])) ? $options['class'] : '',
		'data' => $data,
		'value' => $selected,
	));

	return View::make(Location::partial('common/magicsuggest'))
		->with('attributes', $attributes);
});