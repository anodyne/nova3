<?php namespace Nova\Setup\Http\Requests;

use Nova\Foundation\Http\Requests\Request;

class CheckEmailSettingsRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'mail_driver' => 'required|in:smtp,sendmail,mail,log,sparkpost,mailgun',
			'mail_sendmail' => 'required_if:mail_driver,sendmail',
			'mail_host' => 'required_if:mail_driver,smtp',
			'mail_port' => 'required_if:mail_driver,smtp|integer',
			'mail_encryption' => 'required_if:mail_driver,smtp',
			'mail_username' => 'required_if:mail_driver,smtp',
			'mail_password' => 'required_if:mail_driver,smtp',
			'services_mailgun_domain' => 'required_if:mail_driver,mailgun',
			'services_mailgun_secret' => 'required_if:mail_driver,mailgun',
			'services_sparkpost_secret' => 'required_if:mail_driver,sparkpost',
		];
	}

	public function messages()
	{
		return [
			'mail_driver.required' => "Please select an email driver",
			'mail_driver.in' => "Please select a valid email driver",
			'mail_sendmail.required_if' => "Please enter the sendmail path for your server",
			'mail_host.required_if' => "Please enter your email host address",
			'mail_port.required_if' => "Please enter the port number",
			'mail_port.integer' => "Port numbers must be integers",
			'mail_encryption.required_if' => "Please enter the encryption type",
			'mail_username.required_if' => "Please enter your username",
			'mail_password.required_if' => "Please enter your password",
			'services_mailgun_domain.required_if' => "Please enter your Mailgun domain",
			'services_mailgun_secret.required_if' => "Please enter your Mailgun secret key",
			'services_sparkpost_secret.required_if' => "Please enter your SparkPost secret key",
		];
	}

}
