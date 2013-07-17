<?php namespace Nova\Core\Lib;

use User;
use View;
use Status;
use Location;
use Settings;
use Exception;
use Mail as LaravelMailer;

class Email {

	public function send($view, array $data)
	{
		// Get the email preferences
		$options = Settings::getItems([
			'email_subject',
			'email_name',
			'email_address',
			'email_status'
		]);

		if ($options->email_status == Status::ACTIVE)
		{
			// We have to have a TO index
			if ( ! array_key_exists('to', $data))
			{
				$data['to'] = User::active()->get();
			}

			// We have to have a SUBJECT index
			if ( ! array_key_exists('subject', $data))
			{
				throw new Exception(lang('email.error.noSubject'));
			}

			// Build the HTML view
			$htmlView = View::make(Location::email($view, 'html'));

			// Build the TEXT view
			$textView = View::make(Location::email($view, 'text'));

			// Send the HTML emails
			$send['html'] = LaravelMailer::send($htmlView, $data, $this->buildMessage($data, $options, 'html'));

			// Send the text emails
			$send['text'] = LaravelMailer::send($textView, $data, $this->buildMessage($data, $options, 'text'));

			return $send;
		}

		return false;
	}

	protected function buildMessage($data, $options, $type = 'html')
	{
		// Build the message callback
		$message = function($m) use($data, $options)
		{
			// Get the recipient lists
			$recipients = $this->splitUsers($data['to']);
			$recipientsCC = $this->splitUsers($data['cc']);
			$recipientsBCC = $this->splitUsers($data['bcc']);

			// Set the TO
			$m->to($recipients[$type]);

			// Set the SUBJECT
			$m->subject($options->email_subject.' '.$data['subject']);

			// Set who it's coming FROM
			$m->from($options->email_address, $options->email_name);

			// If there's a reply to, add it
			if (array_key_exists('replyTo', $data))
			{
				$m->replyTo($data['replyTo']);
			}

			// If there's a CC, add it
			if (array_key_exists('cc', $data))
			{
				$m->cc($recipientsCC[$type]);
			}

			// If there's a BCC, add it
			if (array_key_exists('bcc', $data))
			{
				$m->bcc($recipientsBCC[$type]);
			}
		};

		return $message;
	}

	/**
	 * Take the recipients and split them up based on their email format preference.
	 *
	 * @param	mixed	Users (can be an array of IDs or a Collection)
	 * @return	array
	 *
	 * @todo	This may be able to be re-written if a Collection is being passed through the data array
	 */
	protected function splitUsers($users)
	{
		// Create an array for storing users
		$final = [];

		if ($users instanceof \Collection)
		{
			$final = $users->each(function($u)
			{
				return $u->getPreferenceItem('email_format');
			})->toSimpleArray('id', 'email');
		}
		else
		{
			foreach ($users as $user)
			{
				// Get the user
				$u = User::find($user);

				// Break the users out based on mail format preference
				$final[$u->getPreferences('email_format')][] = $u->email;
			}
		}

		return $final;
	}

}