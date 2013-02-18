<?php
/**
 * The Nav class provides an interface for generating navigation
 * menus out of the database, including managing the caching of
 * the navigation for faster load speeds.
 *
 * @package		Nova
 * @subpackage	Core
 * @category	Class
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */

namespace Nova\Core\Lib;

use View;
use Sentry;
use Utility;
use NavModel;
use SettingsModel;
use Fuel\Util\Inflector;

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

	protected $app;

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
		$this->app		= \app();

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
					$output = View::make($this->app['location']->file('nav/classic', Utility::getSkin($this->section), 'partial'))
						->with('items', $this->data[$this->type]['items'][$this->category])
						->with('name', SettingsModel::getItems('sim_name'));
				}
				else
				{
					$output = View::make($this->app['location']->file('nav/subnav', Utility::getSkin($this->section), 'partial'))
						->with('items', $this->data[$this->section][$this->category]);
				}
			break;
			
			case 'dropdown':
			default:
				$output = View::make($this->app['location']->file('nav/dropdown', Utility::getSkin($this->section), 'partial'))
					->with('items', $this->data)
					->with('name', SettingsModel::getItems('sim_name'))
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
		$data = NavModel::all();

		foreach ($data as $key => $item)
		{
			// Set the proper type based on the item type
			$type = $item->type;
			$type = ($type == 'sub') ? 'main' : $type;
			$type = ($type == 'adminsub') ? 'admin' : $type;

			// Set the proper category based on the item category
			$cat = ($item->type == 'main' or $item->type == 'admin') ? 'items' : $item->category;

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
				// Get the access info for the nav item
				$navaccess = explode('.', $item->access);

				// Find if the user has access
				$access = Sentry::getUser()->hasAccess("$navaccess[0].$navaccess[1]");

				// Find if the user has the proper level
				$level = Sentry::getUser()->atLeastLevel("$navaccess[0].$navaccess[1]", $navaccess[2]);

				// Remove items from the return array if they shouldn't be there based on access
				if ( ! $access or ($access and ! $level))
				{
					unset($retval[$type][$cat][$item->id]);
					unset($retval[$type][$cat][$item->category][$item->id]);
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
		$output = View::make($this->app['location']->file('nav/user', Utility::getSkin($this->section), 'partial'));

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
				? View::make($this->app['location']->file('common/label', Utility::getSkin($this->section), 'partial'))
					->with('class', $writingClass)
					->with('value', $writingCount)
				: false;
			$messageOutput = ($messageCount > 0) 
				? View::make($this->app['location']->file('common/label', Utility::getSkin($this->section), 'partial'))
					->with('class', $messageClass)
					->with('value', $messageCount)
				: false;

			// Build the list of items that should be in the user nav
			$this->userData = array(
				0 => array(
					array(
						'name' => ucwords(\lang('cp')),
						'url' => 'admin/index',
						'extra' => array(),
						'additional' => ''),
					array(
						'name' => ucfirst(Inflector::pluralize(\lang('notification'))),
						'url' => 'admin/notifications',
						'extra' => array(),
						'additional' => ''),
				),
				1 => array(
					array(
						'name' => ucwords(\lang('my', array('thing' => \lang('account')))),
						'url' => 'admin/user/edit/'.Sentry::getUser()->id,
						'extra' => array(),
						'additional' => ' <span class="icn icn-50 tooltip-left" data-icon="?" title="'.\lang('short.help.user_account').'"></span>'),
					array(
						'name' => ucwords(\lang('my', array('thing' => Inflector::pluralize(\lang('character'))))),
						'url' => 'admin/character/edit',
						'extra' => array(),
						'additional' => ''),
				),
				2 => array(
					array(
						'name' => $messageOutput.ucfirst(Inflector::pluralize(\lang('message'))),
						'url' => 'admin/messages',
						'extra' => array(),
						'additional' => ''),
					array(
						'name' => $writingOutput.\lang('writing', 1),
						'url' => 'admin/writing',
						'extra' => array(),
						'additional' => ''),
				),
				3 => array(
					array(
						'name' => ucfirst(\langConcat('action.request loa')),
						'url' => 'admin/user/loa',
						'extra' => array(),
						'additional' => ''),
					array(
						'name' => ucfirst(\langConcat('action.nominate for award')),
						'url' => 'admin/user/nominate',
						'extra' => array(),
						'additional' => ''),
				),
				4 => array(
					array(
						'name' => ucfirst(\lang('action.logout')),
						'url' => 'login/logout',
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
			 ->with('loginText', ucwords(\lang('action.login')));
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
