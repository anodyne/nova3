<?php namespace Nova\Core\Users\Listeners;

use UserPreferenceRepositoryContract,
	PreferenceDefaultRepositoryContract;

class BuildUserPreferences {

	protected $userPrefsRepo;
	protected $prefDefaultsRepo;

	public function __construct(UserPreferenceRepositoryContract $prefs,
			PreferenceDefaultRepositoryContract $defaults)
	{
		$this->userPrefsRepo = $prefs;
		$this->prefDefaultsRepo = $defaults;
	}

	public function handle($event)
	{
		$defaults = $this->prefDefaultsRepo->all();

		foreach ($defaults as $default)
		{
			$this->userPrefsRepo->create([
				'user_id' => $event->user->id,
				'key' => $default->key,
				'value' => $default->default,
			]);
		}
	}
}
