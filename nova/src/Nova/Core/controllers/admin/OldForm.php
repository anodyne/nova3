<?php
/**
 * Nova's forms admin controller.
 *
 * @package		Nova
 * @category	Controller
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */

namespace Nova;

class Controller_Admin_Form extends Controller_Base_Admin
{
	public function before()
	{
		parent::before();
		
		$this->template->layout->navsub->menu = false;
	}
	
	/**
	 * Shows all of the dynamic forms available in the system. With the proper permissions,
	 * a user can also edit any of them from a dropdown menu.
	 */
	public function action_index()
	{
		\Sentry::allowed('form.read', true);

		$this->_view = 'admin/form/index';
		$this->_js_view = 'admin/form/index_js';

		if (\Sentry::user()->hasAccess('form.update') and \Input::method() == 'POST')
		{
			if (\Security::check_token())
			{
				// get the id
				$id = \Security::xss_clean(\Input::post('id'));

				// update the form
				$entry = \Model_Form::updateItem($id, \Input::post(), true);

				if (is_object($entry))
				{
					$this->_flash[] = array(
						'status' 	=> 'success',
						'message'	=> ucfirst(lang('short.alert.success.update', lang('form'))),
					);

					\SystemEvent::add('user', '[[event.form.update|{{'.$entry->name.'}}]]');
				}
				else
				{
					$this->_flash[] = array(
						'status'	=> 'danger',
						'message'	=> ucfirst(lang('short.alert.failure.update', lang('form'))),
					);
				}
			}
			else
			{
				$this->_flash[] = array(
					'status' 	=> 'danger',
					'message' 	=> lang('error.csrf'),
				);
			}
		}

		// grab all the forms from the database
		$this->_data->forms = \Model_Form::find('all');

		// set up the images
		$this->_data->images = array(
			'action' => \Location::image($this->images['settings'], $this->skin, 'admin'),
		);

		return;
	}

	/**
	 * Shows all the fields associated with a specific form. In addition, if an ID is passed
	 * through the URI, that field can be edited, or new fields can be created.
	 */
	public function action_fields($key, $id = false)
	{
		\Sentry::allowed('form.update', true);

		$this->_view = 'admin/form/fields';
		$this->_js_view = 'admin/form/fields_js';

		if (\Input::method() == 'POST')
		{
			if (\Security::check_token())
			{
				// get the action
				$action = \Security::xss_clean(\Input::post('action'));

				// get the ID from the POST
				$field_id = \Security::xss_clean(\Input::post('id'));

				if (\Sentry::user()->hasAccess('form.delete') and $action == 'delete')
				{
					// delete the field
					$item = \Model_Form_Field::deleteItem($field_id);

					if ($item)
					{
						$this->_flash[] = array(
							'status' 	=> 'success',
							'message' 	=> ucfirst(lang('short.alert.success.delete', lang('field'))),
						);
					}
					else
					{
						$this->_flash[] = array(
							'status' 	=> 'danger',
							'message' 	=> ucfirst(lang('short.alert.failure.delete', lang('field'))),
						);
					}
				}

				if (\Sentry::user()->hasAccess('form.update') and $action == 'add')
				{
					// add the field
					$item = \Model_Form_Field::createItem(\Input::post());

					if ($item)
					{
						$this->_flash[] = array(
							'status' 	=> 'success',
							'message'	=> ucfirst(lang('short.alert.success.create', lang('field'))),
						);
					}
					else
					{
						$this->_flash[] = array(
							'status' 	=> 'danger',
							'message'	=> ucfirst(lang('short.alert.failure.create', lang('field'))),
						);
					}
				}

				if (\Sentry::user()->hasAccess('form.update') and $action == 'update')
				{
					// update the field
					$item = \Model_Form_Field::updateItem($field_id, \Input::post());

					if ($item)
					{
						$this->_flash[] = array(
							'status' 	=> 'success',
							'message' 	=> ucfirst(lang('short.alert.success.update', lang('field'))),
						);
					}
					else
					{
						$this->_flash[] = array(
							'status' 	=> 'danger',
							'message' 	=> ucfirst(lang('short.alert.failure.update', lang('field'))),
						);
					}
				}
			}
			else
			{
				$this->_flash[] = array(
					'status' 	=> 'danger',
					'message' 	=> lang('error.csrf'),
				);
			}
		}

		// no ID, show all the fields
		if ($id === false)
		{
			// set up the variables
			$this->_data->tabs = false;
			$this->_data->sections = false;
			$this->_data->fields = false;

			// get the form elements
			$tabs = \Model_Form_Tab::getFormItems($key);
			$sections = \Model_Form_Section::getFormItems($key);
			$fields = \Model_Form_Field::getFormItems($key);

			/**
			 * Tabs
			 */
			if (count($tabs) > 0)
			{
				foreach ($tabs as $tab)
				{
					$this->_data->tabs[] = $tab;
				}
			}

			/**
			 * Sections
			 */
			if (count($sections) > 0)
			{
				foreach ($sections as $section)
				{
					if (count($tabs) > 0)
					{
						$this->_data->sections[$section->tab_id][] = $section;
					}
					else
					{
						$this->_data->sections[] = $section;
					}
				}
			}

			/**
			 * Fields
			 */
			if (count($fields) > 0)
			{
				foreach ($fields as $field)
				{
					if (count($sections) > 0)
					{
						$this->_data->fields[$field->section_id][] = $field;
					}
					else
					{
						$this->_data->fields[] = $field;
					}
				}
			}

			// Manually set the header, footer, and message
			$title = ucwords(lang('manage', langConcat('form fields')));
			$this->_headers['fields'] = $this->_titles['fields'] = $title;
			$this->_messages['fields'] = lang('sitecontent.message.fieldsAll');
		}
		else
		{
			$this->_view = 'admin/form/fields_action';

			// get the sections
			$this->_data->sections = \Model_Form_Section::getItems($key);

			// set the types
			$this->_data->types = array(
				'text' => lang('text_field', 2),
				'textarea' => lang('text_area', 2),
				'select' => lang('dropdown', 2),
			);

			// set the roles
			$empty_role = array(0 => '');
			$this->_data->roles = array_merge($empty_role, \Model_Access_Role::getRoles());

			// ID 0 means a new field, anything else edits an existing field
			if ($id == 0)
			{
				// get the field
				$this->_data->field = false;

				// set the action
				$this->_data->action = 'add';

				// Manually set the header, footer, and message
				$title = ucwords(lang('short.create', langConcat('status.new form field')));
				$this->_headers['fields'] = $this->_titles['fields'] = $title;
				$this->_messages['fields'] = false;
			}
			else
			{
				// get the field
				$this->_data->field = \Model_Form_Field::find($id);

				// if we don't have a field, redirect to the creation screen
				if ($this->_data->field === null)
				{
					\Response::redirect('admin/form/fields/'.$key.'/0');
				}

				// if the field isn't part of this form, redirect them
				if ($this->_data->field->form_key != $key)
				{
					\Response::redirect('admin/form/fields/'.$this->_data->field->form_key.'/'.$id);
				}

				// get the field values
				$this->_data->values = \Model_Form_Value::getItems($id);

				// set the action
				$this->_data->action = 'update';

				// Manually set the header, footer, and message
				$title = ucwords(lang('short.update', langConcat('form field')));
				$this->_headers['fields'] = $this->_titles['fields'] = $title;
				$this->_messages['fields'] = lang('sitecontent.message.fieldsEdit');
			}
		}

		// set up the images
		$this->_data->images = array(
			'sections' => \Location::image($this->images['sections'], $this->skin, 'admin'),
			'tabs' => \Location::image($this->images['tabs'], $this->skin, 'admin'),
		);

		return;
	}

	/**
	 * Shows all the sections associated with a specific form. In addition, if an ID is passed
	 * through the URI, that section can be edited, or new sections can be created.
	 *
	 * Ideally, we would do the field update for a deleted section in the observer, but
	 * we can't pass arguments to the observer (the new section ID), so we have to do it
	 * in here.
	 */
	public function action_sections($key, $id = false)
	{
		\Sentry::allowed('form.update', true);

		$this->_view = 'admin/form/sections';
		$this->_js_view = 'admin/form/sections_js';

		if (\Input::method() == 'POST')
		{
			if (\Security::check_token())
			{
				// get the action
				$action = \Security::xss_clean(\Input::post('action'));

				// get the ID from the POST
				$section_id = \Security::xss_clean(\Input::post('id'));

				if (\Sentry::user()->hasAccess('form.delete') and $action == 'delete')
				{
					// get the new section ID
					$new_section = \Security::xss_clean(\Input::post('new_section_id'));

					// get the section we're deleting
					$section = \Model_Form_Section::find($section_id);

					// loop through the fields and update them
					foreach ($section->fields as $f)
					{
						// update the section ID
						$f->section_id = $new_section;

						// save the record
						$f->save();
					}

					// delete the section
					$item = \Model_Form_Section::deleteItem($section_id);

					if ($item)
					{
						$this->_flash[] = array(
							'status' 	=> 'success',
							'message'	=> ucfirst(lang('short.alert.success.delete', lang('section'))),
						);
					}
					else
					{
						$this->_flash[] = array(
							'status' 	=> 'danger',
							'message' 	=> ucfirst(lang('short.alert.failure.delete', lang('section'))),
						);
					}
				}

				if (\Sentry::user()->hasAccess('form.update') and $action == 'add')
				{
					// add the section
					$item = \Model_Form_Section::createItem(\Input::post());

					if ($item)
					{
						$this->_flash[] = array(
							'status' 	=> 'success',
							'message'	=> ucfirst(lang('short.alert.failure.create', lang('section'))),
						);
					}
					else
					{
						$this->_flash[] = array(
							'status' 	=> 'danger',
							'message'	=> ucfirst(lang('short.alert.failure.create', lang('section'))),
						);
					}
				}

				if (\Sentry::user()->hasAccess('form.update') and $action == 'update')
				{
					// update the section
					$item = \Model_Form_Section::updateItem($section_id, \Input::post());

					if ($item)
					{
						$this->_flash[] = array(
							'status' 	=> 'success',
							'message' 	=> ucfirst(lang('short.alert.failure.update', lang('section'))),
						);
					}
					else
					{
						$this->_flash[] = array(
							'status' 	=> 'danger',
							'message'	=> ucfirst(lang('short.alert.failure.update', lang('section'))),
						);
					}
				}
			}
			else
			{
				$this->_flash[] = array(
					'status' 	=> 'danger',
					'message' 	=> lang('error.csrf'),
				);
			}
		}

		// no ID, show all the sections
		if ($id === false)
		{
			// set up the variables
			$this->_data->tabs = false;
			$this->_data->sections = false;

			// get the form elements
			$tabs = \Model_Form_Tab::getFormItems($key);
			$sections = \Model_Form_Section::getFormItems($key);

			/**
			 * Tabs
			 */
			if (count($tabs) > 0)
			{
				foreach ($tabs as $tab)
				{
					$this->_data->tabs[] = $tab;
				}
			}

			/**
			 * Sections
			 */
			if (count($sections) > 0)
			{
				foreach ($sections as $section)
				{
					if (count($tabs) > 0)
					{
						$this->_data->sections[$section->tab_id][] = $section;
					}
					else
					{
						$this->_data->sections[] = $section;
					}
				}
			}

			// Manually set the header, footer, and message
			$title = ucwords(lang('short.manage', langConcat('form sections')));
			$this->_headers['sections'] = $this->_titles['sections'] = $title;
			$this->_messages['sections'] = lang('sitecontent.message.sectionsAll');
		}
		else
		{
			$this->_view = 'admin/form/sections_action';

			// get the forms
			$this->_data->forms = \Model_Form::getForms();

			// get the tabs
			$this->_data->tabs = \Model_Form_Tab::getItems($key);

			// ID 0 means a new section, anything else edits an existing section
			if ($id == 0)
			{
				// get the section
				$this->_data->section = false;

				// set the action
				$this->_data->action = 'add';

				// Manually set the header, footer, and message
				$title = ucwords(lang('short.create', langConcat('form section')));
				$this->_headers['sections'] = $this->_titles['sections'] = $title;
				$this->_messages['sections'] = false;
			}
			else
			{
				// get the section
				$this->_data->section = \Model_Form_Section::find($id);

				// if we don't have a section, redirect to the creation screen
				if ($this->_data->section === null)
				{
					\Response::redirect('admin/form/sections/'.$key.'/0');
				}

				// if the section isn't part of this form, redirect them
				if ($this->_data->section->form_key != $key)
				{
					\Response::redirect('admin/form/sections/'.$this->_data->section->form_key.'/'.$id);
				}

				// set the action
				$this->_data->action = 'update';

				// Manually set the header, footer, and message
				$title = ucwords(lang('short.update', langConcat('form section')));
				$this->_headers['sections'] = $this->_titles['sections'] = $title;
				$this->_messages['sections'] = false;
			}
		}

		// set up the images
		$this->_data->images = array(
			'fields' => \Location::image($this->images['fields'], $this->skin, 'admin'),
			'tabs' => \Location::image($this->images['tabs'], $this->skin, 'admin'),
		);

		return;
	}

	/**
	 * Shows all the tabs associated with a specific form. In addition, if an ID is passed
	 * through the URI, that tab can be edited, or new tabs can be created.
	 *
	 * Ideally, we would do the section update for a deleted tab in the observer, but
	 * we can't pass arguments to the observer (the new tab ID), so we have to do it
	 * in here.
	 */
	public function action_tabs($key, $id = false)
	{
		\Sentry::allowed('form.update', true);

		$this->_view = 'admin/form/tabs';
		$this->_js_view = 'admin/form/tabs_js';

		if (\Input::method() == 'POST')
		{
			if (\Security::check_token())
			{
				// get the action
				$action = \Security::xss_clean(\Input::post('action'));

				// get the ID from the POST
				$tab_id = \Security::xss_clean(\Input::post('id'));

				if (\Sentry::user()->hasAccess('form.delete') and $action == 'delete')
				{
					// get the new tab ID
					$new_tab = \Security::xss_clean(\Input::post('new_tab_id'));

					// get the tab we're deleting
					$tab = \Model_Form_Tab::find($tab_id);

					// loop through the sections and update them
					foreach ($tab->sections as $sec)
					{
						// update the tab ID
						$sec->tab_id = $new_tab;

						// save the record
						$sec->save();
					}

					// delete the tab
					$item = \Model_Form_Tab::deleteItem($tab_id);

					if ($item)
					{
						$this->_flash[] = array(
							'status' 	=> 'success',
							'message' 	=> ucfirst(lang('short.alert.success.delete', lang('tab'))),
						);
					}
					else
					{
						$this->_flash[] = array(
							'status' 	=> 'danger',
							'message' 	=> ucfirst(lang('short.alert.failure.delete', lang('tab'))),
						);
					}
				}

				if (\Sentry::user()->hasAccess('form.update') and $action == 'add')
				{
					// add the tab
					$item = \Model_Form_Tab::createItem(\Input::post());

					if ($item)
					{
						$this->_flash[] = array(
							'status' 	=> 'success',
							'message' 	=> ucfirst(lang('short.alert.success.create', lang('tab'))),
						);
					}
					else
					{
						$this->_flash[] = array(
							'status' 	=> 'danger',
							'message' 	=> ucfirst(lang('short.alert.failure.create', lang('tab'))),
						);
					}
				}

				if (\Sentry::user()->hasAccess('form.update') and $action == 'update')
				{
					// update the tab
					$item = \Model_Form_Tab::updateItem($tab_id, \Input::post());

					if ($item)
					{
						$this->_flash[] = array(
							'status' 	=> 'success',
							'message' 	=> ucfirst(lang('short.alert.success.update', lang('tab'))),
						);
					}
					else
					{
						$this->_flash[] = array(
							'status' 	=> 'danger',
							'message' 	=> ucfirst(lang('short.alert.failure.update', lang('tab'))),
						);
					}
				}
			}
			else
			{
				$this->_flash[] = array(
					'status' 	=> 'danger',
					'message' 	=> lang('error.csrf'),
				);
			}
		}

		// no ID, show all the tabs
		if ($id === false)
		{
			// set up the variables
			$this->_data->tabs = false;

			// get the form elements
			$tabs = \Model_Form_Tab::getFormItems($key);

			/**
			 * Tabs
			 */
			if (count($tabs) > 0)
			{
				foreach ($tabs as $tab)
				{
					$this->_data->tabs[] = $tab;
				}
			}

			// Manually set the header, footer, and message
			$title = ucwords(lang('short.manage', langConcat('form tabs')));
			$this->_headers['tabs'] = $this->_titles['tabs'] = $title;
			$this->_messages['tabs'] = lang('sitecontent.message.tabsAll');
		}
		else
		{
			$this->_view = 'admin/form/tabs_action';

			// get the tabs
			$this->_data->tabs = \Model_Form_Tab::getItems($key);

			// ID 0 means a new tab, anything else edits an existing tab
			if ($id == 0)
			{
				// get the tab
				$this->_data->tab = false;

				// set the action
				$this->_data->action = 'add';

				// Manually set the header, footer, and message
				$title = ucwords(lang('short.create', langConcat('form tab')));
				$this->_headers['tabs'] = $this->_titles['tabs'] = $title;
				$this->_messages['tabs'] = false;
			}
			else
			{
				// get the tab
				$this->_data->tab = \Model_Form_Tab::find($id);

				// if we don't have a tab, redirect to the creation screen
				if ($this->_data->tab === null)
				{
					\Response::redirect('admin/form/tabs/'.$key.'/0');
				}

				// if the tab isn't part of this form, redirect them
				if ($this->_data->tab->form_key != $key)
				{
					\Response::redirect('admin/form/tabs/'.$this->_data->tab->form_key.'/'.$id);
				}

				// set the action
				$this->_data->action = 'update';

				// Manually set the header, footer, and message
				$title = ucwords(lang('short.update', langConcat('form tab')));
				$this->_headers['tabs'] = $this->_titles['tabs'] = $title;
				$this->_messages['tabs'] = false;
			}
		}

		// set up the images
		$this->_data->images = array(
			'sections' => \Location::image($this->images['sections'], $this->skin, 'admin'),
			'fields' => \Location::image($this->images['fields'], $this->skin, 'admin'),
		);

		return;
	}
}