<?php namespace Nova\Core\Lib;

use Str;
use View;
use Sentry;
use Utility;
use Location;
use NavModel;
use Settings;

class Nav {
	
	/**
	 * @var	array	An array of nav data.
	 */
	protected $data = array();

	/**
	 * @var	array	An array of user data.
	 */
	protected $userData = array();

	/**
	 * @var	string	The output of the final nav.
	 */
	protected $output;

	/**
	 * @var	string	The output of the final user nav.
	 */
	protected $userOutput;

	/**
	 * @var	string	The nav style.
	 */
	protected $style;

	/**
	 * @var	string	The nav type.
	 */
	protected $type;

	/**
	 * @var	string	The nav category.
	 */
	protected $category;

	/**
	 * @var	string	The nav section.
	 */
	protected $section;

	/**
	 * Create a new Nav.
	 *
	 * @param	string	The style of nav (classic or dropdown)
	 * @param	string	The type of nav (main, sub, admin or adminsub)
	 * @param	string	The category of the nav (main, admin, messages, write, etc.)
	 * @param	string	The section of the nav (main or admin)
	 * @return	void
	 */
	public function __construct($style = 'dropdown', $type = 'main', $category = 'main', $section = 'main')
	{
		$this->style	= $style;
		$this->type		= $type;
		$this->category	= $category;
		$this->section	= $section;

		// Set the nav data
		$this->setData();

		// Set the user data
		$this->setUserDataAndOutput();
	}

	/**
	 * Build the output of the specified nav.
	 *
	 * @return	string
	 */
	public function build()
	{
		switch ($this->style)
		{
			case 'classic':
				if ($this->type == 'main')
				{
					$output = View::make(Location::file('nav/classic', Utility::getSkin($this->section), 'partial'))
						->with('items', $this->data[$this->type]['mainNavItems'][$this->category])
						->with('name', Settings::getSettings('sim_name'));
				}
				else
				{
					$output = View::make(Location::file('nav/subnav', Utility::getSkin($this->section), 'partial'))
						->with('items', $this->data[$this->section][$this->category]);
				}
			break;
			
			case 'dropdown':
			default:
				$output = View::make(Location::file('nav/dropdown', Utility::getSkin($this->section), 'partial'))
					->with('items', $this->data)
					->with('name', Settings::getSettings('sim_name'))
					->with('userMenu', $this->userOutput)
					->with('section', $this->section)
					->with('category', $this->category);
			break;
		}

		return $output;
	}

	/**
	 * Get the nav data.
	 *
	 * @return	array
	 */
	public function getData()
	{
		return $this->data;
	}

	/**
	 * Set the nav data.
	 *
	 * @internal
	 * @return	void
	 */
	protected function setData()
	{
		$data = NavModel::get();

		foreach ($data as $item)
		{
			/**
			 * TYPE is about whether it's a main nav item, sub nav item,
			 * admin main nav items or admin sub nav item. We need to make
			 * sure we're taking into account whether something should be
			 * in the MAIN side of things or the ADMIN side of things.
			 */
			$type = $item->type;
			$type = ($type == 'sub') ? 'main' : $type;
			$type = ($type == 'adminsub') ? 'admin' : $type;

			/**
			 * If the TYPE is main or admin, we'll put it into the ITEMS
			 * section of the array because we'll be using it to build the
			 * main nav and admin main nav. If it has a TYPE other than
			 * main or admin, we're going to categorize them by the category
			 * that's listed in the database record.
			 */
			$cat = ($item->type == 'main' or $item->type == 'admin') ? 'mainNavItems' : $item->category;

			// Get the sub nav items under this section
			$sub = ($type == 'sub' or $type == 'adminsub') ? NavModel::getItems($type, $item->category) : false;

			// Put the item into the return array
			$retval[$type][$cat][$item->id] = $item;

			// Figure out if things needs to be removed from the return array
			if (($item->needs_login == 'y' and ! Sentry::check()) or ($item->needs_login == 'n' and Sentry::check()))
			{
				unset($retval[$type][$cat][$item->id]);
				unset($retval[$type][$cat][$item->category][$item->id]);
			}

			// Dive in to the access checks
			if ( ! empty($item->access))
			{
				// Check if we're dealing with multiple conditions or not
				if (Str::contains($item->access, '|'))
				{
					// Get the array of items to use
					$navAccessArray = explode('|', $item->access);

					// Loop through the various items
					foreach ($navAccessArray as $a)
					{
						// Create an array from
						$n = explode('.', $a);

						$navaccess[] = "{$n[0]}.{$n[1]}";
					}
				}
				else
				{
					// Get the array of items to use
					$navAccessArray = explode('.', $item->access);

					// Get the access info for the nav item
					$navaccess = "{$navAccessArray[0]}.{$navAccessArray[1]}";
				}

				// Get the user
				$user = Sentry::getUser();

				if ($user)
				{
					// Remove items from the return array if they shouldn't be there based on access
					if ( ! $user->allowed($navaccess))
					{
						unset($retval[$type][$cat][$item->id]);
						unset($retval[$type][$cat][$item->category][$item->id]);
					}
				}
			}
		}

		// Assign the data back to the class
		$this->data = $retval;
	}

	/**
	 * Get the user data.
	 *
	 * @return	array
	 */
	public function getUserData()
	{
		return $this->userData;
	}

	/**
	 * Get the user nav output.
	 *
	 * @return	string
	 */
	public function getUserOutput()
	{
		return $this->userOutput;
	}

	/**
	 * Set the user data and output.
	 *
	 * @internal
	 * @return	void
	 */
	protected function setUserDataAndOutput()
	{
		// Start to build the output
		$output = View::make(Location::file('nav/user', Utility::getSkin($this->section), 'partial'));

		if (Sentry::check())
		{
			// Get the user
			$user = Sentry::getUser();

			// Get the message count
			$messageCount = 0;

			// Get the writing count
			$writingCount = 0;
			
			// Create a total count
			$total = $writingCount + $messageCount;

			// Figure out what the classes should be
			$totalClass = ($total == 0) ? '' : ' label-warning';
			$writingClass = ($writingCount == 0) ? '' : ' label-warning';
			$messageClass = ($messageCount == 0) ? '' : ' label-important';

			// Figure out the outputs
			$writingOutput = ($writingCount > 0) 
				? View::make(Location::file('common/label', Utility::getSkin($this->section), 'partial'))
					->with('class', $writingClass)
					->with('value', $writingCount)
				: false;
			$messageOutput = ($messageCount > 0) 
				? View::make(Location::file('common/label', Utility::getSkin($this->section), 'partial'))
					->with('class', $messageClass)
					->with('value', $messageCount)
				: false;

			// Build the list of items that should be in the user nav
			$this->userData = array(
				0 => array(
					array(
						'name' => ucwords(lang('cp')),
						'url' => 'admin/index',
						'extra' => array(),
						'additional' => ''),
					array(
						'name' => ucfirst(Str::plural(lang('notification'))),
						'url' => 'admin/notifications',
						'extra' => array(),
						'additional' => ''),
				),
				1 => array(
					array(
						'name' => ucwords(lang('my', lang('account'))),
						'url' => 'admin/user/edit/'.Sentry::getUser()->id,
						'extra' => array(),
						'additional' => ''),
					array(
						'name' => ucwords(lang('my', Str::plural(lang('character')))),
						'url' => 'admin/character/edit',
						'extra' => array(),
						'additional' => ''),
				),
				2 => array(
					array(
						'name' => $messageOutput.ucfirst(Str::plural(lang('message'))),
						'url' => 'admin/messages/index',
						'extra' => array(),
						'additional' => ''),
					array(
						'name' => $writingOutput.lang('writing', 1),
						'url' => 'admin/writing/index',
						'extra' => array(),
						'additional' => ''),
				),
				3 => array(
					array(
						'name' => ucfirst(langConcat('action.request loa')),
						'url' => 'admin/user/loa',
						'extra' => array(),
						'additional' => ''),
					array(
						'name' => ucfirst(langConcat('action.nominate for award')),
						'url' => 'admin/user/nominate',
						'extra' => array(),
						'additional' => ''),
				),
				4 => array(
					array(
						'name' => ucfirst(lang('action.logout')),
						'url' => 'logout',
						'extra' => array(),
						'additional' => ''),
				),
			);

			// Set the data for the output
			$output->with('data', $this->userData)
				->with('name', Sentry::getUser()->name)
				->with('notifyClass', $totalClass)
				->with('notifyTotal', $total)
				->with('loggedIn', true);
		}
		else
		{
			// Set the data for the output
			$output->with('loggedIn', false)
			 ->with('loginText', ucwords(lang('action.login')));
		}

		// Set the output render to the class variable
		$this->userOutput = $output;
	}

	/**
	 * Get the nav style.
	 *
	 * @return	string
	 */
	public function getStyle()
	{
		return $this->style;
	}

	/**
	 * Set the nav style.
	 *
	 * @param	string	The style
	 * @return	Nav
	 */
	public function setStyle($value)
	{
		$this->style = $value;

		return $this;
	}

	/**
	 * Get the nav type.
	 *
	 * @return	string
	 */
	public function getType()
	{
		return $this->type;
	}

	/**
	 * Set the nav type.
	 *
	 * @param	string	The type
	 * @return	Nav
	 */
	public function setType($value)
	{
		$this->type = $value;

		return $this;
	}

	/**
	 * Get the nav category.
	 *
	 * @return	string
	 */
	public function getCategory()
	{
		return $this->category;
	}

	/**
	 * Set the nav category.
	 *
	 * @param	string	The category
	 * @return	Nav
	 */
	public function setCategory($value)
	{
		$this->category = $value;

		return $this;
	}

	/**
	 * Get the nav section.
	 *
	 * @return	string
	 */
	public function getSection()
	{
		return $this->section;
	}

	/**
	 * Set the nav section.
	 *
	 * @param	string	The section
	 * @return	Nav
	 */
	public function setSection($value)
	{
		$this->section = $value;

		return $this;
	}
}
