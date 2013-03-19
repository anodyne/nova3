<?php namespace Nova\Core\Model;

use Date;
use Model;
use Sentry;
use Status;
use User;
use NovaAppResponse;
use Position;
use Character;

class Application extends Model {

	protected $table = 'applications';
	
	protected static $properties = array(
		'id', 'user_id', 'character_id', 'position_id', 'status', 'sample_post',
		'created_at', 'updated_at',
	);

	/**
	 * Belongs To: Character
	 */
	public function character()
	{
		return $this->belongsTo('Character');
	}

	/**
	 * Belongs To: Position
	 */
	public function position()
	{
		return $this->belongsTo('Position');
	}

	/**
	 * Belongs To: User
	 */
	public function user()
	{
		return $this->belongsTo('User');
	}

	/**
	 * Has Many: Responses
	 */
	public function responses()
	{
		return $this->hasMany('NovaAppResponse');
	}

	/**
	 * Belongs To Many: Reviewers (through Application Reviewers)
	 */
	public function reviewers()
	{
		return $this->belongsToMany('User', 'application_reviewers');
	}

	/**
	 * Get all comment records for this application.
	 *
	 * @return	Application\Response
	 */
	public function getComments()
	{
		return \Model_Application_Response::query()
			->where('app_id', $this->id)
			->where('type', \Model_Application_Response::COMMENT)
			->order_by('created_at', 'desc')
			->get();
	}

	/**
	 * Gets the decision makers that are involved with this application.
	 *
	 * @return	array
	 */
	public function getDecisionMakers()
	{
		// get all decision makers
		$decision_makers = array_keys(Sentry::usersWithAccess('character.create.2'));

		// loop through the reviewers
		foreach ($this->reviewers as $r)
		{
			$review_users[] = $r->user_id;
		}

		// compare the two arrays
		return array_intersect($decision_makers, $review_users);
	}

	/**
	 * Get the application records.
	 *
	 * @param	bool	Should we get only active records?
	 * @return	Application
	 */
	public static function getItems($onlyActive = true)
	{
		$query = static::query();

		if ($onlyActive)
		{
			$query->where('status', Status::IN_PROGRESS);
		}

		return $query->get();
	}

	/**
	 * Get vote records for this application.
	 *
	 * @param	mixed	Which responses to get (yes/no/false for all)
	 * @return	Application\Response
	 */
	public function getVotes($response = false)
	{
		$items = \Model_Application_Response::query()
			->where('app_id', $this->id)
			->where('type', \Model_Application_Response::VOTE)
			->order_by('created_at', 'desc');

		if (is_numeric($response))
		{
			return $items->where('user_id', $response)->get_one();
		}

		if (is_string($response))
		{
			$items->where('content', $response);
		}
			
		return $items->get();
	}

	/**
	 * Substitute the keys for their actual values.
	 *
	 * @param	string	The untranslated message
	 * @return	string
	 */
	public function substituteMessageKeys($message)
	{
		// Build the list of possible substitutions
		$args = array(
			'name'		=> $this->user->name,
			'character'	=> $this->character->getName(false),
			'position'	=> $this->position->name,
			'rank'		=> $this->character->rank->info->name,
			'sim'		=> \Model_Settings::getItems('sim_name'),
		);

		// Loop through all the arguments and replace it if it's in the message
		foreach ($args as $key => $value)
		{
			if (strpos($message, '#'. $key .'#') !== false)
			{
				$message = str_replace('#'. $key .'#', $value, $message);
			}
		}

		return $message;
	}

	/**
	 * Update the reviewers associated with this review. This involves
	 * removing all reviewers and re-adding them.
	 *
	 * @param	mixed	The data to use for updating reviewers
	 * @param	bool	Should an email be sent to reviewers who are new?
	 * @return	mixed
	 * @todo	send the email to a new reviewer
	 */
	public function updateReviewers($data, $emailToNew = true)
	{
		// make sure we have an array
		$data = ( ! is_array($data)) ? array($data) : $data;

		// get the reviewers for this application
		$reviewers = \Model_Application_Reviewer::query()->where('app_id', $this->id)->get();

		// loop through the reviewers and remove them
		foreach ($reviewers as $r)
		{
			// keep a record of who was there before
			$oldReviewers[] = $r->user_id;

			// delete the reviewer
			$r->delete();
		}

		// track who needs to get an email
		$sendEmail = array();

		// now loop through the data we have
		foreach ($data as $d)
		{
			// add the reviewer
			\Model_Application_Reviewer::add(array(
				'app_id' => $this->id,
				'user_id' => $d
			));

			// if they weren't in the old list, add them to the list for sending an email
			if ( ! in_array($d, $oldReviewers))
			{
				// get the email information
				$sendEmail[] = $d;
			}
		}

		if ($emailToNew and count($sendEmail) > 0)
		{
			// send the email
			\NovaMail::send('arc_reviewer_add', array(
				'subject' => lang('email.subject.arc.addReviewer'),
				'to' => array_values($sendEmail),
				'content' => array('message' => lang('email.content.arc.addReviewer')),
			));
		}
	}

	/**
	 * Create a new vote record if the user doesn't have one, otherwise,
	 * update their existing record.
	 *
	 * @param	User	The Sentry user object
	 * @param	array	The POST array
	 * @return	bool
	 */
	public function updateVote($user, $data)
	{
		// get the user's vote
		$myVote = $this->votes( (int) $user->id);

		if ($myVote)
		{
			// update the response
			$myVote->content = (\Arr::get($data, 'vote.yes') !== false) ? 'yes' : 'no';
			$myVote->created_at = Date::now('UTC')->toDateTimeString();
			$myVote->save();
		}
		else
		{
			// add the response
			\Model_Application_Response::add(array(
				'app_id' => $this->id,
				'user_id' => $user->id,
				'type' => \Model_Application_Response::VOTE,
				'content' => (\Arr::get($data, 'vote.yes') !== false) ? 'yes' : 'no'
			));
		}

		return true;
	}

}