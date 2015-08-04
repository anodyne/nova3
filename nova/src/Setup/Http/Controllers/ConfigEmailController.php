<?php namespace Nova\Setup\Http\Controllers;

use Flash, Input;
use Illuminate\Filesystem\Filesystem;
use Nova\Setup\Http\Requests\CheckEmailSettingsRequest;

class ConfigEmailController extends BaseController {

	public function info()
	{
		return view('pages.setup.config.email.info');
	}

	public function write(CheckEmailSettingsRequest $request, Filesystem $files)
	{
		// Grab the config writer
		$writer = app('nova.setup.configWriter');

		// Write the mail config
		$writer->write('mail', [
			"#MAIL_DRIVER#"			=> trim(Input::get('mail_driver')),
			"#MAIL_HOST#"			=> trim(Input::get('mail_host')),
			"#MAIL_PORT#"			=> trim(Input::get('mail_port')),
			"#MAIL_ENCRYPTION#"		=> trim(Input::get('mail_encryption')),
			"#MAIL_USERNAME#"		=> trim(Input::get('mail_username')),
			"#MAIL_PASSWORD#"		=> trim(Input::get('mail_password')),
			"#MAIL_SENDMAIL_PATH#"	=> trim(Input::get('mail_sendmail')),
		]);

		if ($files->exists(app('path.config').'/mail.php'))
		{
			return redirect()->route("setup.{$this->setupType}.config.email.success");
		}

		// Set the flash message
		flash()->error(null, "We couldn't write the email configuration file because of your server's settings. Please contact your web host to ensure PHP files can write to the server.");

		return redirect()->route("setup.{$this->setupType}.config.email");
	}

	public function success()
	{
		return view('pages.setup.config.email.success');
	}

}
