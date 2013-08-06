<?php namespace Nova\Core\Lib;

use User;
use Status;
use Settings;
use SiteContent;
use NotifierNoContentException;
use NotifierNoSubjectException;
use Nova\Extensions\Laralve\Application;
use Nova\Extensions\Laravel\Database\Eloquent\Collection;

class Notify {

	public function __construct(Application $app)
	{
		$this->app = $app;
	}

	/**
	 * Send the notification.
	 *
	 * @param	string	Name of the view to use
	 * @param	array	Data to use in the email
	 * @param	array	SiteContent keys
	 * @return	array
	 */
	public function send($view, array $data, array $keys)
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
					$data['content'] = SiteContent::getContentItem($keys['content']);
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
					$content = SiteContent::getContentItem($keys['content']) + $data['content'];
					$data['content'] = $content;
				}
			}

			// Build the HTML view
			$htmlView = $this->app['view']->make($this->app['location']->email($view, 'html'));

			// Build the TEXT view
			$textView = $this->app['view']->make($this->app['location']->email($view, 'text'));

			// Send the HTML emails
			$send['html'] = $this->app['mailer']->send(
				$htmlView,
				$data,
				$this->buildMessage($data, $options, $keys, 'html')
			);

			// Send the text emails
			$send['text'] = $this->app['mailer']->send(
				$textView,
				$data,
				$this->buildMessage($data, $options, $keys, 'text')
			);

			return $send;
		}

		return false;
	}

	/**
	 * Build the mailer callback.
	 *
	 * @internal
	 * @param	array	Data to use
	 * @param	object	Email settings
	 * @param	array	Site content keys
	 * @param	string	Type of message to build (html, text)
	 * @return	Closure
	 */
	protected function buildMessage(array $data, $options, array $keys, $type = 'html')
	{
		// Build the message callback
		$message = function($m) use($data, $options, $keys)
		{
			// Set the subject
			$subject = (array_key_exists('subject', $keys))
				? SiteContent::getContentItem($keys['subject'])
				: $data['subject'];

			// Get the recipient lists
			$recipients = $this->splitUsers($data['to']);
			$recipientsCC = $this->splitUsers($data['cc']);
			$recipientsBCC = $this->splitUsers($data['bcc']);

			// Set the TO
			$m->to($recipients[$type]);

			// Set the SUBJECT
			$m->subject("{$options->email_subject} {$subject}");

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
	 * @internal
	 * @param	mixed	Users (An array of IDs or a Collection of users)
	 * @return	array
	 */
	protected function splitUsers($users)
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
			foreach ($users as $user)
			{
				$u = (is_numeric($user)) 
					? User::find($user) 
					: User::email($user)->first();

				// Break the users out based on mail format preference
				$final[$u->getPreferences('email_format')][] = $u->email;
			}
		}

		return $final;
	}

}