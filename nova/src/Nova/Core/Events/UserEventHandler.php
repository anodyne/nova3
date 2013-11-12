<?php namespace Nova\Core\Events;

use URL;
use Request;
use FormModel;
use UserModel;
use FormDataModel;
use UserMailer as Mailer;
use SettingsRepositoryInterface;

class UserEventHandler extends \BaseEventHandler {

	protected $mailer;
	protected $settings;

	public function __construct(SettingsRepositoryInterface $settings, Mailer $mailer)
	{
		$this->mailer = $mailer;
		$this->settings = $settings;
	}

	public function onUserCreated(UserModel $user, $input)
	{
		// Create user preferences for the user
		$user->createUserPreferences();

		/**
		 * Fill the user rows for the dynamic form with blank data for editing later.
		 */
		$form = FormModel::key('user')->first();
		
		if ($form->fields->count() > 0)
		{
			foreach ($form->fields as $field)
			{
				FormDataModel::create([
					'form_id' 	=> $form->id,
					'field_id' 	=> $field->id,
					'data_id' 	=> $user->id,
					'value' 	=> '',
				]);
			}
		}

		// Send the email to the user
		$this->mailer->created([
			'to'		=> $user->email,
			'content'	=> lang('email.content.user.create', 
							lang('user'),
							$this->settings->findByKey('sim_name'),
							Request::root(),
							$input['name'],
							$input['password']),
			'subject'	=> lang('email.subject.user.create'),
		]);

		// Create a system event
	}

	public function onUserResetPassword(UserModel $user)
	{
		$this->mailer->resetPassword([
			'to'		=> $user->email,
			'content'	=> "\r\n\r\n".URL::to("login/reset_confirm/{$user->id}/{$user->getResetPasswordCode()}"),
		]);
	}

}