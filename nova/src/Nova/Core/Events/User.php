<?php namespace Nova\Core\Events;

use URL;
use Request;
use UserModel;
use UserMailer as Mailer;
use SettingsRepositoryInterface;

class User {

	protected $mailer;
	protected $settings;

	public function __construct(Mailer $mailer, SettingsRepositoryInterface $settings)
	{
		$this->mailer = $mailer;
		$this->settings = $settings;
	}

	public function onUserCreated(UserModel $user, $input)
	{
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
	}

	public function onUserResetPassword(UserModel $user)
	{
		$this->mailer->resetPassword([
			'to'		=> $user->email,
			'content'	=> "\r\n\r\n".URL::to("login/reset_confirm/{$user->id}/{$user->getResetPasswordCode()}"),
		]);
	}

}