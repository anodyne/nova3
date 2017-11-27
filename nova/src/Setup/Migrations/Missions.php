<?php namespace Nova\Setup\Migrations;

use DB;
use Status;

class Missions implements Migratable
{
	protected $incomingData = [];
	protected $outgoingData = [];

	public function migrate()
	{
		if (! $this->check()) {
			$db = DB::connection('nova2');

			// Get all missions from Nova 2
			$missions = $db->table('missions')->get();

			// Get all mission posts from Nova 2
			$posts = $db->table('posts')->get();

			// Get all personal logs from Nova 2
			$logs = $db->table('personallogs')->get();

			foreach ($missions as $mission) {
				$story = creator(Story::class)->with([
					'title' => $mission->mission_title,
					'description' => $mission->mission_desc,
					'summary' => $mission->mission_summary,
					'status' => Status::toInt($mission->mission_status),
				])->create();

				// Get all mission posts from Nova 2 for that mission
				$missionPosts = $posts->where('post_mission', $mission->mission_id);

				// Get all personal logs from Nova 2 that fall between the start
				// and end dates of the mission
				$personalLog = $logs->filter(function ($l) use ($mission) {
					return $l->log_date >= $mission->mission_start
						and $l->log_date < $mission->mission_end;
				});

				// Put all mission content into an array that's sorted by the
				// published date of the content
				$missionContent = $missionPosts;
				$missionContent->merge($personalLogs);
				#TODO: Figure out how to sort when there are different fields to sort on

				// Loop through the content and create story entries for each
				$missionContent->each(function ($m) {
					$type = (property_exists('post_id', $m)) ? 'post' : 'log';

					if ($type == 'post') {
						$data = [];
					} else {
						$data = [];
					}

					create(StoryEntry::class)->with($data)->create();
				});
			}
		}
	}

	public function check()
	{
		return true;
	}

	public function getData()
	{
		return $this->outgoingData;
	}

	public function setData($data)
	{
		//
	}
}
