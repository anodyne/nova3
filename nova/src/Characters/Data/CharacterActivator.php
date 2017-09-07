<?php namespace Nova\Characters\Data;

use Str;
use Status;
use Nova\Users\User;
use Nova\Characters\Events;
use Nova\Characters\Character;
use Nova\Foundation\Data\BindsData;
use Nova\Foundation\Data\Activatable;

class CharacterActivator implements Activatable
{
	use BindsData;

	protected $character;

	public function activate(Character $character)
	{
		// Determine previous status
		$wasInactive = $character->isInactive();
		$wasPending = $character->isPending();

		// Update the character
		$character = $this->character = updater(Character::class)
			->with(['status' => Status::ACTIVE])
			->update($character);

		if ($wasPending) {
			// Handle stuff that needs to happen when a pending character is
			// activated
		}

		if ($wasInactive) {
			// Handle stuff that needs to happen when a character was inactive
			// and is being re-activated
		}

		// Handle anything related to positions with the character
		$character = $this->handlePositionUpdates($character);

		// Handle the user
		if (! $this->character->user->isActive()) {
			activator(User::class)->activate($this->character->user);
		}

		// Fire any events we need to
		$this->fireEvents();

		return $character;
	}

	protected function fireEvents()
	{
		//
	}

	protected function handlePositionUpdates(Character $character)
	{
		// Map the positions data to figure out what's the primary position
		$positionSync = collect($this->data['positions'])->mapWithKeys(function ($p, $index) {
			return [$p => ['primary' => ($index == 0) ? (int) true : (int) false]];
		})->all();

		// Sync the positions to the pivot table
		$character->positions()->sync($positionSync);

		// Update position availability
		$character->fresh()->positions->each->removeAvailableSlot();

		return $character->fresh();
	}

	protected function handleUserUpdates(Character $character)
	{
		// Get the assigned user
		$user = $character->user;

		// If the user doesn't have a primary character, set this one
		// as the primary character
		if ($user and ! $user->primaryCharacter) {
			$character->setAsPrimaryCharacter();
		}

		return $character->fresh();
	}
}
