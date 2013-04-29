<?php namespace Nova\Core\Handlers;

use Status;
use Sentry;
use UserModel;
use SystemEvent;
use PositionModel;
use CharacterModel;
use NovaAppRuleModel;
use NovaAppReviewerModel;

class Application {

	/**
	 * After create event
	 *
	 * When an application is created, we need to kick off the the review
	 * process by adding the decision makers and then going through all of the
	 * active rules to dynamically add reviewers to the application.
	 *
	 * @param	$model	The current model
	 * @return	void
	 */
	public function afterCreate($model)
	{
		// Start the array for who will get emailed
		$emailUsers = array();

		/**
		 * Add the decision makers to the review.
		 *
		 * A decision maker is anyone who has a role with the character
		 * component level 2 create action task (character.create.2).
		 */
		
		// Get the decision makers
		$decisionMakers = Sentry::usersWithAccess('character.create.2');

		// Add the decision makers to the review
		foreach ($decisionMakers as $dm)
		{
			// Add the reviewer record
			NovaAppReviewerModel::add(array(
				'app_id'	=> $model->id,
				'user_id'	=> $dm->id,
			));

			// Add the user to the email array
			$emailUsers[$dm->id] = $dm->email;
		}

		/**
		 * Add reviewers to an application based on the rules.
		 */
		
		// Get all the active application rules
		$rules = NovaAppRuleModel::all();

		if (count($rules) > 0)
		{
			// Loop through the rules
			foreach ($rules as $r)
			{
				switch ($r->type)
				{
					case 'global':
						// Get the JSON object
						$data = json_decode($r->users);

						if (property_exists($data, 'user'))
						{
							foreach ($data->user as $user)
							{
								// Add the reviewer record
								NovaAppReviewerModel::add(array(
									'app_id'	=> $model->id,
									'user_id'	=> $user,
								));

								// Add the user to the email array
								$emailUsers[$user] = UserModel::find($user)->email;
							}
						}

						if (property_exists($data, 'position'))
						{
							foreach ($data->position as $position)
							{
								// Get the active character in the given position
								$p = PositionModel::find($position);

								// Loop through the characters for that position
								foreach ($p->getCharacters() as $character)
								{
									// Get the character
									$char = CharacterModel::find($character->character_id);

									if ($char->status == Status::ACTIVE and $char->user !== null)
									{
										// Add the reviewer record
										NovaAppReviewerModel::add(array(
											'app_id'	=> $model->id,
											'user_id'	=> $char->user->id,
										));

										// Add the user to the email array
										$emailUsers[$char->user->id] = $char->user->email;
									}
								}
							}
						}
					break;

					case 'dept':
						// If the application is for the department
						if ($model->position->dept->id == (int) $r->condition)
						{
							// Get the JSON object
							$data = json_decode($r->users);

							if (property_exists('user', $data))
							{
								foreach ($data->user as $user)
								{
									// Add the reviewer record
									NovaAppReviewerModel::add(array(
										'app_id'	=> $model->id,
										'user_id'	=> $user,
									));

									// Add the user to the email array
									$emailUsers[$user] = UserModel::find($user)->email;
								}
							}

							if (property_exists('position', $data))
							{
								foreach ($data->position as $position)
								{
									// Get the active character in the given position
									$p = PositionModel::find($position);

									// Loop through the characters for that position
									foreach ($p->getCharacters() as $character)
									{
										// Get the character
										$char = CharacterModel::find($character->character_id);

										if ($char->status == Status::ACTIVE and $char->user !== null)
										{
											// Add the reviewer record
											NovaAppReviewerModel::add(array(
												'app_id'	=> $model->id,
												'user_id'	=> $char->user->id,
											));

											// Add the user to the email array
											$emailUsers[$char->user->id] = $char->user->email;
										}
									}
								}
							}
						}
					break;
				}
			}
			
			// Send the email
			Mail::send('arc_review_start', function($m) use($emailUsers)
			{
				$m->subject(lang('email.subject.arc.reviewStart'));
				$m->to(array_keys($emailUsers));
			});
		}
		else
		{
			// what do we do if there aren't any active rules?
		}

		/**
		 * System Event
		 */
		SystemEvent::addUserEvent('event.main.join.application', $model->user->name, lang('position'), $model->position->name, lang('character'), $model->character->getName());
	}

}