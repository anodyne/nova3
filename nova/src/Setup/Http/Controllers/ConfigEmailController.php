<?php namespace Nova\Setup\Http\Controllers;

use Nova\Setup\ConfigFileWriter;
use Illuminate\Filesystem\Filesystem;
use Nova\Setup\Http\Requests\CheckEmailSettingsRequest;

class ConfigEmailController extends Controller
{
	public function info()
	{
		return view('setup.config.email-info');
	}

	public function write(CheckEmailSettingsRequest $request, ConfigFileWriter $writer, Filesystem $files)
	{
		// Write the mail config
		$writer->write('mail', [
			"#MAIL_DRIVER#" => trim($request->get('mail_driver')),
			"#MAIL_HOST#" => trim($request->get('mail_host')),
			"#MAIL_PORT#" => trim($request->get('mail_port')),
			"#MAIL_ENCRYPTION#" => trim($request->get('mail_encryption')),
			"#MAIL_USERNAME#" => trim($request->get('mail_username')),
			"#MAIL_PASSWORD#" => trim($request->get('mail_password')),
			"#MAIL_SENDMAIL_PATH#" => trim($request->get('mail_sendmail')),
		]);

		// Grab the mail driver so we can do additional setup if necessary
		$mailDriver = $request->get('mail_driver');

		// Setup the services config file
		switch ($mailDriver) {
			case 'mailgun':
				$writer->write('services', [
					"#MAILGUN_DOMAIN#" => trim($request->get('services_mailgun_domain')),
					"#MAILGUN_SECRET#" => trim($request->get('services_mailgun_secret')),

					"#SPARKPOST_SECRET#" => '',
				]);
				break;

			case 'sparkpost':
				$writer->write('services', [
					"#SPARKPOST_SECRET#" => trim($request->get('services_sparkpost_secret')),

					"#MAILGUN_DOMAIN#" => '',
					"#MAILGUN_SECRET#" => '',
				]);
				break;
		}

		if ($files->exists(app('path.config').'/mail.php')) {
			return redirect()->route("setup.{$this->setupType}.config.email.success");
		}

		// Set the flash message
		flash()
			->message("We couldn't write the email configuration file because of your server's settings. Please contact your web host to ensure PHP files can write to the server.")
			->error();

		return redirect()->route("setup.{$this->setupType}.config.email");
	}

	public function success()
	{
		return view('setup.config.email-success');
	}
}
