<?php namespace Nova\Foundation\Configuration;

use Date;
use GuzzleHttp\Client;

trait DoesVersionCheck {

	public static $updateVersion;

	public function getLatestVersion()
	{
		if (app('env') != 'production')
		{
			static::$updateVersion = '3.1';

			return true;
		}

		// Build a new client
		$client = new Client();

		// Make the request to the Nova version service
		$response = $client->get('https://version.anodyne-productions.com');

		return json_decode($response->getBody()->getContents());
	}

	public static function getReleaseNotes()
	{
		// Parse the releases JSON object and throw it into a collection
		$releases = collect(
			json_decode(
				app('files')->get(app_path("Setup/releases.json"))
			)->releases
		);

		$version = static::$version;

		// Filter out any version that is the current version or older, then
		// map the collection to get the pretty date and parse the Markdown
		// release notes, then finally sort everything so the newest version
		// is first
		return $releases->filter(function ($release) use ($version)
		{
			return version_compare($release->version, $version, '>');
		})->map(function ($release)
		{
			$date = Date::createFromFormat('Y-m-d', $release->date);

			$release->date = $date->format('d M Y');
			$release->prettyDate = $date->diffForHumans();
			$release->notes = app('nova.markdown')->parse($release->notes);

			return $release;
		})->sortByDesc('version');
	}

	public static function hasUpdate() : bool
	{
		if (app('env') != 'production')
		{
			static::$updateVersion = '3.1';

			return true;
		}

		// Build a new client
		$client = new Client();

		// Make the request to the Nova version service
		$response = $client->get('https://version.anodyne-productions.com');

		// Get the response body's content
		$version = json_decode($response->getBody()->getContents());

		if (version_compare(static::$version, static::$updateVersion, '<'))
		{
			return true;
		}

		return false;
	}
}
