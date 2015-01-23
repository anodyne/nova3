<?php namespace Nova\Setup\Http\Controllers;

use Flash,
	Input,
	Redirect;
use Illuminate\Filesystem\Filesystem;

class ConfigEmailController extends Controller {

	public function info()
	{
		return view('pages.setup.config.email.info');
	}

	public function write(Filesystem $files)
	{
		// Grab the content from the generator
		$content = $files->get(app_path('Setup/generators/mail.php'));

		// Setup the replacement dictionary
		$replacements = [
			"#MAIL_DRIVER#"			=> Input::get('mail_driver'),
			"#MAIL_HOST#"			=> Input::get('mail_host'),
			"#MAIL_PORT#"			=> Input::get('mail_port'),
			"#MAIL_ENCRYPTION#"		=> Input::get('mail_encryption'),
			"#MAIL_USERNAME#"		=> Input::get('mail_username'),
			"#MAIL_PASSWORD#"		=> Input::get('mail_password'),
			"#MAIL_SENDMAIL_PATH#"	=> Input::get('mail_sendmail'),
		];

		// Swap out the placeholders for the real content
		foreach ($replacements as $placeholder => $replacement)
		{
			$content = str_replace($placeholder, $replacement, $content);
		}

		// Create the file and store the content
		$files->put(app('path.config').'/mail.php', $content);

		if ($files->exists(app('path.config').'/mail.php'))
		{
			return Redirect::route("setup.{$this->setupType}.config.email.success");
		}

		// Set the flash message
		Flash::error("We couldn't write the email configuration file because of your server's settings. Please contact your web host to ensure PHP files can write to the server.");

		return Redirect::route("setup.{$this->setupType}.config.email");
	}

	public function success()
	{
		return view('pages.setup.config.email.success');
	}

}
