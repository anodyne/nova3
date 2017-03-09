<?php namespace Nova\Foundation\Configuration;

use Date;
use GuzzleHttp\Client;

trait DoesVersionCheck {

	public $updateObject;
	public $updateVersion;

	public function getLatestVersion()
	{
		switch (app('env')) {
			case 'production':
			default:
				$response = (new Client)
					->get('https://version.anodyne-productions.com');

				$content = $response->getBody()->getContents();
			break;

			case 'local':
			case 'testing':
				$content = app('files')->get(setup_path('version.json'));
			break;
		}

		$this->updateObject = json_decode($content);
		$this->updateVersion = $this->updateObject->version;

		return $this->updateObject;
	}

	public function getReleaseNotes()
	{
		// Parse the releases JSON object and throw it into a collection
		$releases = collect(
			json_decode(app('files')->get(setup_path("releases.json")))->releases
		);

		$version = $this->version;

		// Filter out any version that is the current version or older, then
		// map the collection to get the pretty date and parse the Markdown
		// release notes, then finally sort everything so the newest version
		// is first
		return $releases->filter(function ($release) use ($version) {
			return version_compare($release->version, $version, '>');
		})->map(function ($release) {
			$date = Date::createFromFormat('Y-m-d', $release->date);

			$release->date = $date->format('d M Y');
			$release->prettyDate = $date->diffForHumans();
			$release->notes = app('nova.markdown')->parse($release->notes);

			return $release;
		})->sortByDesc('version');
	}

	public function hasUpdate() : bool
	{
		$update = $this->getLatestVersion();

		return version_compare($this->version, $update->version, '<');
	}
}
