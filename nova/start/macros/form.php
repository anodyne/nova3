<?php

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
		$options = array_merge(array('id' => 'positionDrop', 'class' => 'span4'), $options);

		// Build the output
		$output = '<div class="control-group"><label class="control-label">'.ucfirst(lang('base.position')).'</label><div class="controls">';
		$output.= Form::select($name, $list, $selected, $options);
		$output.= '<div id="positionDesc" class="help-block">';

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
	$groups = RankGroup::getItems(Status::ACTIVE);

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
		$options = array_merge(array('id' => 'rankDrop', 'class' => 'span4'), $options);

		// Build the output
		$output = '<div class="control-group"><label class="control-label">'.ucfirst(lang('base.rank')).'</label><div class="controls">';
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