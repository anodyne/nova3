<?php namespace Nova\Core\Lib;

use View;
use Status;
use Location;
use Settings;
use Exception;
use Mail as LaravelMailer;

class Email {

	public static function send($view, $data)
	{
		// Get the email preferences
		$options = Settings::getItems(array(
			'email_subject',
			'email_name',
			'email_address',
			'email_status'
		));

		if ($options->email_status == Status::ACTIVE)
		{
			// We have to have a TO index
			if ( ! array_key_exists('to', $data))
			{
				throw new Exception(lang('email.error.noToAddress'));
			}

			// We have to have a SUBJECT index
			if ( ! array_key_exists('subject', $data))
			{
				throw new Exception(lang('email.error.noSubject'));
			}

			// Do we have data for the email?
			$content = (array_key_exists('content', $data)) ? $data['content'] : false;

			// Build the message callback
			$message = function($m) use($data, $options)
			{
				// Set the TO
				$m->to(static::splitUsers($data['to']));

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
					$m->cc(static::splitUsers($data['cc']));
				}

				// If there's a BCC, add it
				if (array_key_exists('bcc', $data))
				{
					$m->cc(static::splitUsers($data['bcc']));
				}
			};

			// Build the HTML view
			$htmlView = View::make(Location::email($view, 'html'));

			// Build the TEXT view
			$textView = View::make(Location::email($view, 'text'));

			// Send the messages
			$send = array(
				'html' => LaravelMailer::send(array('html' => $htmlView), $data, $message),
				'text' => LaravelMailer::send(array('text' => $textView), $data, $message),
			);

			return $send;
		}

		return false;
	}

	/**
	 * Take the recipients and split them up based on their email format preference.
	 *
	 * @param	array	An array of user IDs
	 * @return	array
	 *
	 * @todo	This may be able to be re-written if a Collection is being passed through the data array
	 */
	protected static function splitUsers(array $users)
	{
		// Create an array for storing users
		$retval = array();

		// Loop through the users
		foreach ($users as $user)
		{
			// Get the user
			$u = User::find($user);

			// Break the users out based on mail format preference
			$retval[$u->getPreferences('email_format')][] = $u->email;
		}

		return $retval;
	}

}