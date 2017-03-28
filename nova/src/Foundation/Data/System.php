<?php namespace Nova\Foundation\Data;

use Model;
use GuzzleHttp\Client;

class System extends Model
{
	protected $table = 'system_info';

	protected $fillable = ['uuid', 'version_major', 'version_minor',
		'version_patch', 'version_ignore'];

	protected $dates = ['created_at', 'updated_at'];

	//-------------------------------------------------------------------------
	// Model Methods
	//-------------------------------------------------------------------------

	public function hasUpdate()
	{
		if (app('env') == 'local') {
			$response = json_encode([
				'version' => '3.1'
			]);
		} else {
			$response = (new Client())
				->get('https://version.anodyne-productions.com')
				->getBody()
				->getContents();
		}

		$version = json_decode($response);

		return version_compare($version->version, $this->version('db'), '>');
	}

	public function version($type = false)
	{
		$versionInfo = collect([
			'db' => implode('.', [
				$this->version_major,
				$this->version_minor,
				$this->version_patch
			]),
			'files' => config('nova.app.version.full')
		]);

		if ($type) {
			return $versionInfo->get($type);
		}

		return $versionInfo;
	}
}
