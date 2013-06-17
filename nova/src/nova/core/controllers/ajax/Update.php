<?php namespace Nova\Core\Controllers\Ajax;

use View;
use Input;
use Sentry;
use Request;
use Utility;
use Location;
use Markdown;
use AjaxBaseController;

class Update extends AjaxBaseController {

	/**
	 * Updates the site content table when an admin uses jEditable to edit
	 * some site content outside of the control panel.
	 *
	 * @return	string
	 */
	public function action_content_save()
	{
		if (\Sentry::check() and \Sentry::user()->hasAccess('content.update'))
		{
			// get the POST information
			$key = \Security::xss_clean(\Input::post('key'));
			$value = \Security::xss_clean(\Input::post('value'));

			// break the key up into an array
			$pieces = explode('_', $key);

			// flip the array around
			$pieces = array_reverse($pieces);

			// make sure we don't have any tags in the headers
			$content = ($pieces[0] == 'header') ? strip_tags(\Markdown::parse($value)) : $value;

			// save the content
			\Model_SiteContent::updateSiteContent(array($key => $content));

			// if it's a header, show the content, otherwise we need to parse the Markdown
			if ($pieces[0] == 'header')
			{
				echo $content;
			}
			else
			{
				echo \Markdown::parse($content);
			}
		}
	}

	/**
	 * Updates the form field order when the sort function stops.
	 *
	 * @return	void
	 */
	public function action_formfield_order()
	{
		if (\Sentry::check() and \Sentry::user()->hasAccess('form.update'))
		{
			// get and sanitize the input
			$fields = \Security::xss_clean(\Input::post('field'));

			foreach ($fields as $key => $value)
			{
				// get the field record
				$record = \Model_Form_Field::find($value);

				// update the order
				$record->order = ($key + 1);

				// save the record
				$record->save();
			}

			\SystemEvent::add('user', '[[event.admin.form.field_update|{{'.$record->label.'}}|{{'.$key.'}}]]');
		}
	}

	/**
	 * Updates the value for a dropdown menu.
	 *
	 * @return	View/string
	 */
	public function action_formfield_value($id)
	{
		if (\Sentry::check() and \Sentry::user()->hasAccess('form.update'))
		{
			if (\Input::method() == 'POST')
			{
				// get the value
				$value = \Model_Form_Value::find($id);

				// remove the items we don't want
				unset($_POST['id']);

				// loop through and update the values
				foreach (\Input::post() as $k => $v)
				{
					$value->{$k} = \Security::xss_clean($v);
				}

				// save the record
				$value->save();

				\SystemEvent::add('user', '[[event.admin.form.field_update|{{'.$value->field->label.'}}|{{'.$key.'}}]]');

				echo '<h1>'.lang('action.edit value', 2).'</h1>';
				echo '<p class="alert alert-success">'.lang('short.flash.success|value|action.updated', 1).' '.lang('short.refresh').'</p>';
			}
			else
			{
				// get the value
				$value = \Model_Form_Value::find($id);

				if ($value !== false)
				{
					$data = array(
						'id' => $value->id,
						'field' => $value->field_id,
						'content' => $value->content,
						'value' => $value->value,
						'order' => $value->order,
					);

					// get the fields
					$fields = \Model_Form_Field::getFormItems($value->field->form_key);

					if (count($fields) > 0)
					{
						foreach ($fields as $f)
						{
							if ($f->type == 'select')
							{
								$data['fields'][$f->id] = $f->label;
							}
						}
					}

					echo \View::forge(\Location::file('update/form_value', 'default', 'ajax'), $data);
				}
			}
		}
	}

	/**
	 * Updates the form field value order when the sort function stops.
	 *
	 * @return	void
	 */
	public function action_formfieldvalue_order()
	{
		if (\Sentry::check() and \Sentry::user()->hasAccess('form.update'))
		{
			// get and sanitize the input
			$values = \Security::xss_clean(\Input::post('value'));

			foreach ($values as $key => $value)
			{
				// get the field record
				$record = \Model_Form_Value::find($value);

				// update the order
				$record->order = ($key + 1);

				// save the record
				$record->save();
			}

			\SystemEvent::add('user', '[[event.admin.form.field_update|{{'.$record->field->label.'}}|{{'.$key.'}}]]');
		}
	}

	/**
	 * Updates the form section order when the sort function stops.
	 *
	 * @return	void
	 */
	public function action_formsection_order()
	{
		if (\Sentry::check() and \Sentry::user()->hasAccess('form.update'))
		{
			// get and sanitize the input
			$sections = \Security::xss_clean(\Input::post('section'));

			foreach ($sections as $key => $value)
			{
				// get the field record
				$record = \Model_Form_Section::find($value);

				// update the order
				$record->order = ($key + 1);

				// save the record
				$record->save();
			}

			\SystemEvent::add('user', '[[event.admin.form.section_update|{{'.$record->name.'}}|{{'.$key.'}}]]');
		}
	}

	/**
	 * Updates the form tab order when the sort function stops.
	 *
	 * @return	void
	 */
	public function postFormTabOrder()
	{
		if (Sentry::check() and Sentry::getUser()->hasAccess('form.update'))
		{
			// Get the tabs
			$tabs = Input::get('tab');

			// Loop through the tabs
			foreach ($tabs as $key => $value)
			{
				// Get and update the tab record
				$record = \NovaFormTab::find($value);
				$record->order = ($key + 1);
				$record->save();
			}
		}
	}

	/**
	 * Create a user record.
	 *
	 * @return	void
	 */
	public function action_link_character()
	{
		if (\Sentry::check() and \Sentry::user()->hasLevel('user.update', 2))
		{
			echo \View::forge(\Location::file('update/link_character_to_user', \Utility::getSkin(), 'ajax'));
		}
	}

	/**
	 * Runs the migrations for a module.
	 *
	 * @return	void
	 */
	public function action_module($module)
	{
		if (\Sentry::check() and \Sentry::user()->hasAccess('catalog.update'))
		{
			// move up to the latest migration
			\Migrate::latest($module, 'module');

			\SystemEvent::add('user', '[[event.admin.catalog.module_update|{{'.$module.'}}]]');

			echo '<p class="alert alert-success">'.lang('[[short.flash.success|module|action.updated]]').'</p>';
			echo '<div class="form-actions"><button class="btn modal-close">'.lang('action.close', 1).'</button></div>';
		}
	}

	/**
	 * Duplicate a rank group.
	 *
	 * @param	int		the ID of the rank group being duplicated
	 * @return	void
	 */
	public function action_rankgroup($id)
	{
		if (\Sentry::check() and \Sentry::user()->hasAccess('rank.update'))
		{
			$id = \Security::xss_clean($id);

			// get the rank group
			$group = \Model_Rank_Group::find($id);

			// set the data
			$data['id'] = $id;

			if ($group !== false)
			{
				$data['name'] = $group->name;
				$data['order'] = $group->order;
				$data['status'] = (int) $group->status;
			}

			echo \View::forge(\Location::file('update/rankgroup', \Utility::getSkin(), 'ajax'), $data);
		}
	}

	/**
	 * Updates the rank group order when the sort function stops.
	 *
	 * @return	void
	 */
	public function action_rankgroup_order()
	{
		if (\Sentry::check() and \Sentry::user()->hasAccess('rank.update'))
		{
			// get and sanitize the input
			$sets = \Security::xss_clean(\Input::post('group'));

			foreach ($sets as $key => $value)
			{
				// get the group record
				$record = \Model_Rank_Group::find($value);

				// update the order
				$record->order = ($key + 1);

				// save the record
				$record->save();
			}
		}
	}

	/**
	 * Update a rank info record.
	 *
	 * @param	int		the ID of the rank info being edited
	 * @return	void
	 */
	public function action_rankinfo($id)
	{
		if (\Sentry::check() and \Sentry::user()->hasAccess('rank.update'))
		{
			$id = \Security::xss_clean($id);

			// get the rank group
			$info = \Model_Rank_Info::find($id);

			// set the data
			$data['id'] = $id;
			$data['action'] = 'update';

			if ($info !== false)
			{
				$data['name'] = $info->name;
				$data['short_name'] = $info->short_name;
				$data['order'] = $info->order;
				$data['group'] = $info->group;
				$data['status'] = (int) $info->status;
			}

			echo \View::forge(\Location::file('update/rankinfo', \Utility::getSkin(), 'ajax'), $data);
		}
	}

	/**
	 * Updates the rank info order when the sort function stops.
	 *
	 * @return	void
	 */
	public function action_rankinfo_order()
	{
		if (\Sentry::check() and \Sentry::user()->hasAccess('rank.update'))
		{
			// get and sanitize the input
			$info = \Security::xss_clean(\Input::post('info'));

			foreach ($info as $key => $value)
			{
				// get the group record
				$record = \Model_Rank_Info::find($value);

				// update the order
				$record->order = ($key + 1);

				// save the record
				$record->save();
			}
		}
	}

	/*****************************************/
	/*****************************************/
	/*****************************************/

	/**
	 * Handles the create and update modals for managing
	 * system page routes.
	 *
	 * @param	int		Page route ID
	 */
	public function getRoute($id = 0)
	{
		// Make sure the user is logged in
		if (Sentry::check())
		{
			// Get the user
			$user = Sentry::getUser();

			// Make sure the user is allowed to access this page
			if ($user->hasAccess('routes.create') or $user->hasAccess('routes.update'))
			{
				// Get the page route
				$route = \SystemRoute::find($id);

				// Set the action
				$action = ($id > 0) ? 'update' : 'create';

				echo View::make(Location::file('update/route', Utility::getSkin(), 'ajax'))
					->with('route', $route)
					->with('action', $action);
			}
		}
	}
	
}