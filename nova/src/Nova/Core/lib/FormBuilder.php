<?php namespace Nova\Core\Lib;

use Dept;
use Rank;
use Location;
use Position;
use Markdown;
use RankGroup;
use Symfony\Component\Finder\Finder;
use Illuminate\Html\FormBuilder as LaravelFormBuilder;

class FormBuilder extends LaravelFormBuilder {

	/**
	 * Builds a select menu that includes all of the positions from
	 * the database based on the parameters passed to the method.
	 *
	 * @param	string	The name of the select menu
	 * @param	mixed 	Selected items
	 * @param	array	Extra attributes to be added to the select menu
	 * @return	string
	 */
	public function department($name, $selected = null, $options = array())
	{
		// Grab the departments
		$depts = Dept::all();

		// Make sure we have items
		if ($depts->count() > 0)
		{
			$list[0] = '';
			
			foreach ($depts as $d)
			{
				if ($d->manifest)
				{
					$list[$d->manifest->name][$d->id] = $d->name;
				}
				else
				{
					$list[$d->id] = $d->name;
				}
			}

			return $this->select($name, $list, $selected, $options);
		}
		
		return false;
	}

	/**
	 * Builds a select menu of available languages.
	 *
	 * @param	string	Name of the select menu
	 * @param	int 	Selected items
	 * @param	array	Extra attributes to be added to the select menu
	 * @return	string
	 */
	public function languages($name, $selected = null, $options = array())
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
		$finder = new Finder();

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

		return $this->select($name, $list, $selected, $options);
	}

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
	public function position($name, $selected = null, $options = array(), $type = 'all', $selectOnly = false)
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
				return $this->select($name, $list, $selected, $options);
			}

			// Merge the user options into what should be there
			$options = array_merge(array('id' => 'positionDrop', 'class' => 'span4'), $options);

			// Build the output
			$output = '<div class="control-group"><label class="control-label">'.ucfirst(lang('base.position')).'</label><div class="controls">';
			$output.= $this->select($name, $list, $selected, $options);
			$output.= '<div id="positionDesc" class="help-block">';

			if (is_numeric($selected))
			{
				$output.= Markdown::parse(Position::find($selected)->desc);
			}

			$output.= '</div></div></div>';

			return $output;
		}
		
		return false;
	}
	
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
	public function rank($name, $selected = null, $options = array(), $selectOnly = false)
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
				return $this->select($name, $list, $selected, $options);
			}

			// Merge the user options into what should be there
			$extra = array_merge(array('id' => 'rankDrop', 'class' => 'span4'), $extra);

			// Build the output
			$output = '<div class="control-group"><label class="control-label">'.ucfirst(lang('base.rank')).'</label><div class="controls">';
			$output.= $this->select($name, $list, $selected, $options);
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
	}

	/**
	 * Builds a select menu that includes all of the access roles from
	 * the database based on the parameters passed to the method.
	 *
	 * @api
	 * @param	string	The name of the select menu
	 * @param	mixed 	An array of selected items
	 * @param	array	Extra attributes to add to the select menu
	 * @param	bool	Just show the select menu? (default: false)
	 * @return	string
	 */
	public static function roles($name, $selected = array(), $extra = array(), $selectOnly = false)
	{
		// get the access roles
		$roles = \Model_Access_Role::getRoles();

		if (count($roles) > 0)
		{
			if ($selectOnly)
			{
				return \Form::select($name, $selected, $roles, (array) $extra);
			}

			// merge the user options into what should be there
			$extra = array_merge(array('id' => 'roleDrop', 'class' => 'span4'), (array) $extra);

			// build the output
			$output = '<div class="control-group"><label class="control-label">'.ucwords(lang('access_role')).'</label><div class="controls">';
			$output.= \Form::select($name, $selected, $roles, $extra);
			$output.= '<div id="roleDesc" class="help-block">';

			if (is_numeric($selected))
			{
				$output.= \Markdown::parse(\Model_Access_Role::find($selected)->desc);
			}

			$output.= '</div></div></div>';

			return $output;
		}

		return false;
	}

	/**
	 * Builds a select menu that includes all timezones supported in PHP.
	 *
	 * @api
	 * @param	string	The name of the select menu
	 * @param	array 	An array of selected items
	 * @param	array	Extra attributes to be added to the select menu
	 * @return	string
	 */
	public static function timezones($name, $selected = array(), $extra = array())
	{
		// get the timezone information
		$zones = timezone_identifiers_list();

		// make sure UTC is in the list
		$locations['UTC'] = 'UTC';

		foreach ($zones as $zone)
		{
			// break out the zones into contintent and city
			$zone = explode('/', $zone);

			// only use "friendly" continent names
			if ($zone[0] == 'Africa' or $zone[0] == 'America' or $zone[0] == 'Antarctica' or $zone[0] == 'Arctic' or 
					$zone[0] == 'Asia' or $zone[0] == 'Atlantic' or $zone[0] == 'Australia' or $zone[0] == 'Europe' or 
					$zone[0] == 'Indian' or $zone[0] == 'Pacific')
			{
				if (isset($zone[1]) != '')
				{
					// create an array with the zone and the friendly name
					$locations[$zone[0]][$zone[0].'/'.$zone[1]] = str_replace('_', ' ', $zone[1]);
				}
			}
		}

		return \Form::select($name, $selected, $locations, $extra);
	}

	/**
	 * Builds a select menu that includes all of the users from
	 * the database based on the parameters passed to the method.
	 *
	 * @api
	 * @param	string	The name of the select menu
	 * @param	array 	An array of selected items
	 * @param	array	Extra attributes to be added to the select menu
	 * @param	int		The status of the users to retrieve
	 * @return	string
	 */
	public static function users($name, $selected = array(), $extra = array(), $status = \Status::ACTIVE)
	{
		// Get the users
		$users = ( ! empty($status)) ? \Model_User::getItems($status) : \Model_User::find('all');
		
		if (count($users) > 0)
		{
			$options[0] = '';
			
			foreach ($users as $u)
			{
				$options[$u->id] = $u->name;
			}

			return \Form::select($name, $selected, $options, (array) $extra);
		}

		// Figure out the section
		$section = (\Uri::segment(1) == 'admin') ? 'admin' : 'main';
		
		return \View::forge(\Location::file('flash', \Utility::getSkin($section), 'partial'))
			->set('status', 'danger')
			->set('message', lang('error.notFound', lang('users')))
			->render();
	}

	/**
	 * Builds a select menu that includes all of the characters from
	 * the database based on the parameters passed to the method.
	 *
	 * @api
	 * @param	string	The name of the select menu
	 * @param	array 	An array of selected items
	 * @param	array	Extra attributes to be added to the select menu
	 * @param	string	Which characters to pull
	 * @param	bool	Split characters up by whether they're linked or not (default: false)
	 * @return	string
	 */
	public static function characters($name, $selected = array(), $extra = array(), $status = 'active', $showLinked = false)
	{
		// Get the characters
		$characters = \Model_Character::getCharacters($status);
		
		if (count($characters) > 0)
		{
			$options[0] = '';
			
			foreach ($characters as $c)
			{
				if ($showLinked)
				{
					$sub = ($c->hasUser()) 
						? ucwords(langConcat('linked characters')) 
						: ucwords(langConcat('unlinked characters'));

					$options[$sub][$c->id] = $c->getName();
				}
				else
				{
					$options[$c->id] = $c->getName();
				}
			}

			return \Form::select($name, $selected, $options, (array) $extra);
		}

		// Figure out the section
		$section = (\Uri::segment(1) == 'admin') ? 'admin' : 'main';
		
		return \View::forge(\Location::file('flash', \Utility::getSkin($section), 'partial'))
			->set('status', 'danger')
			->set('message', lang('error.notFound', lang('characters')))
			->render();
	}

}