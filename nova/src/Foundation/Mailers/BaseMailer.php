<?php namespace Nova\Core\Mailers;

use Mail;
use View;
use Status;
use Location;
use UserModel;
use SettingsModel;
use SiteContentModel;
use NotifierNoContentException;
use NotifierNoSubjectException;
use Nova\Extensions\Laravel\Database\Eloquent\Collection;

abstract class BaseMailer {

	protected $settings;

	public function send($view, array $data, array $keys)
	{
		// Get the email preferences
		$options = SettingsModel::getSettings([
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
				$data['to'] = UserModel::active()->get();
			}

			// We have to have a SUBJECT index
			if ( ! array_key_exists('subject', $data) and ! array_key_exists('subject', $keys))
			{
				throw new NotifierNoSubjectException;
			}

			// Set the content
			if ( ! array_key_exists('content', $data))
			{
				// If we have a content key, use that
				if (array_key_exists('content', $keys))
				{
					$data['content'] = SiteContentModel::getContentItem($keys['content']);
				}
				else
				{
					throw new NotifierNoContentException;
				}
			}
			else
			{
				// If we have a content key, prepend it
				if (array_key_exists('content', $keys))
				{
					$content = SiteContentModel::getContentItem($keys['content']) + $data['content'];
					$data['content'] = $content;
				}
			}

			// Build the HTML view
			$htmlView = Location::email($view, 'html');

			// Build the TEXT view
			$textView = Location::email($view, 'text');

			// Send the HTML emails
			$send['html'] = Mail::queue($htmlView, $data, $this->buildMessage($data, $options, $keys, 'html'));

			// Send the text emails
			$send['text'] = Mail::queue($textView, $data, $this->buildMessage($data, $options, $keys, 'text'));

			return $send;
		}

		return false;
	}

	/**
	 * Build the mailer callback.
	 *
	 * @internal
	 * @param	array	$data		Data to use
	 * @param	object	$options	Email settings
	 * @param	array	$keys		Site content keys
	 * @param	string	$type		Type of message to build (html, text)
	 * @return	Closure
	 */
	protected function buildMessage(array $data, $options, array $keys, $type = 'html')
	{
		// Get a copy of the object
		$me = $this;

		// Build the message callback
		$message = function($msg) use ($data, $options, $keys, $type, $me)
		{
			// Set the subject
			$subject = (array_key_exists('subject', $keys))
				? SiteContentModel::getContentItem($keys['subject'])
				: $data['subject'];

			// Split the recipients
			$recipients = $me->splitUsers($data['to']);

			// Set the TO
			if (array_key_exists($type, $recipients))
			{
				$msg->to($recipients[$type]);
			}

			// Set the SUBJECT
			$msg->subject("{$options->email_subject} {$subject}");

			// Set who it's coming FROM
			$msg->from($options->email_address, $options->email_name);

			// If there's a reply to, add it
			if (array_key_exists('replyTo', $data))
			{
				$msg->replyTo($data['replyTo']);
			}

			// If there's a CC, add it
			if (array_key_exists('cc', $data))
			{
				// Split the recipients
				$recipientsCC = $me->splitUsers($data['cc']);

				// Add the CC
				if (array_key_exists($type, $recipientsCC))
				{
					$msg->cc($recipientsCC[$type]);
				}
			}

			// If there's a BCC, add it
			if (array_key_exists('bcc', $data))
			{
				// Split the recipients
				$recipientsBCC = $me->splitUsers($data['bcc']);

				// Add the BCC
				if (array_key_exists($type, $recipientsBCC))
				{
					$msg->bcc($recipientsBCC[$type]);
				}
			}
		};

		return $message;
	}

	/**
	 * Take the recipients and split them up based on their email format preference.
	 *
	 * @param	mixed	$users	Users (An array of IDs or a Collection of users)
	 * @return	array
	 */
	public function splitUsers($users)
	{
		// Create an array for storing users
		$final = [];

		if ($users instanceof Collection)
		{
			// Get users with HTML email preference
			$final['html'] = $users->each(function($u)
			{
				return ($u->getPreferenceItem('email_format') == 'html');
			})->toSimpleArray('id', 'email');

			// Get users with text email preference
			$final['text'] = $users->each(function($u)
			{
				return ($u->getPreferenceItem('email_format') == 'text');
			})->toSimpleArray('id', 'email');
		}
		else
		{
			if (is_array($users))
			{
				foreach ($users as $user)
				{
					$u = (is_numeric($user)) 
						? UserModel::find($user) 
						: UserModel::email($user)->first();

					// Break the users out based on mail format preference
					$final[$u->getPreferences('email_format')][] = $u->email;
				}
			}
		}

		return $final;
	}

}