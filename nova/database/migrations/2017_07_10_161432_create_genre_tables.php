<?php

use Nova\Genres\Rank;
use Nova\Genres\RankInfo;
use Nova\Genres\RankGroup;
use Nova\Genres\Department;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGenreTables extends Migration
{
	public function up()
	{
		Schema::create('departments', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('parent_id')->nullable();
			$table->unsignedInteger('order')->default(99);
			$table->string('name');
			$table->text('description')->nullable();
			$table->timestamps();
		});

		Schema::create('positions', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('department_id')->nullable();
			$table->unsignedInteger('order')->default(99);
			$table->string('name');
			$table->text('description')->nullable();
			$table->unsignedTinyInteger('available')->default(1);
			$table->unsignedTinyInteger('display')->default((int) true);
			$table->timestamps();
		});

		Schema::create('ranks_groups', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('order')->default(99);
			$table->string('name');
			$table->unsignedTinyInteger('display')->default((int) true);
			$table->timestamps();
		});

		Schema::create('ranks_info', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('order')->default(99);
			$table->string('name');
			$table->string('short_name');
			$table->timestamps();
		});

		Schema::create('ranks', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('order')->default(99);
			$table->unsignedInteger('group_id');
			$table->unsignedInteger('info_id');
			$table->string('base')->nullable();
			$table->string('overlay')->nullable();
			$table->timestamps();
		});

		$this->departments();
		$this->ranks();
	}

	public function down()
	{
		Schema::dropIfExists('departments');
		Schema::dropIfExists('positions');
		Schema::dropIfExists('ranks_groups');
		Schema::dropIfExists('ranks_info');
		Schema::dropIfExists('ranks');
	}

	protected function departments()
	{
		$data = [
			[
				'name' => 'Command',
				'description' => "The Command department is ultimately responsible for the ship and its crew, and those within the department are responsible for commanding the vessel and representing the interests of Starfleet.",
				'order' => 0
			],
			[
				'name' => 'Flight Control',
				'description' => "Responsible for the navigation and flight control of a vessel and its auxiliary craft, the Flight Control department includes pilots trained in both starship and auxiliary craft piloting. Note that the Flight Control department does not include Fighter pilots.",
				'order' => 1
			],
			[
				'name' => 'Strategic Operations',
				'description' => "The Strategic Operations department acts as an advisory to the command staff, as well as a resource of knowledge and information concerning hostile races in the operational zone of the ship, as well as combat strategies and other such things.",
				'order' => 2
			],
			[
				'name' => 'Security & Tactical',
				'description' => "Merging the responsibilities of ship-to-ship and personnel combat into a single department, the security & tactical department is responsible for the tactical readiness of the vessel and the security of the ship.",
				'order' => 3
			],
			[
				'name' => 'Operations',
				'description' => "The operations department is responsible for keeping ship systems functioning properly, rerouting power, bypassing relays, and doing whatever else is necessary to keep the ship operating at peak efficiency.",
				'order' => 4
			],
			[
				'name' => 'Engineering',
				'description' => "The engineering department has the enormous task of keeping the ship working; they are responsible for making repairs, fixing problems, and making sure that the ship is ready for anything.",
				'order' => 5
			],
			[
				'name' => 'Science',
				'description' => "From sensor readings to figuring out a way to enter the strange spacial anomaly, the science department is responsible for recording data, testing new ideas out, and making discoveries.",
				'order' => 6
			],
			[
				'name' => 'Medical & Counseling',
				'description' => "The medical & counseling department is responsible for the mental and physical health of the crew, from running annual physicals to combatting a strange plague that is afflicting the crew to helping a crew member deal with the loss of a loved one.",
				'order' => 7
			],
			[
				'name' => 'Intelligence',
				'description' => "The Intelligence department is responsible for gathering and providing intelligence as it becomes possible during a mission; during covert missions, the intelligence department also takes a more active role, providing the necessary classified and other information.",
				'order' => 8
			],
			[
				'name' => 'Diplomatic Detachment',
				'description' => "Responsible for representing the Federation and its interest, members of the Diplomatic Corps are members of the civilian branch of the Federation.",
				'order' => 9
			],
			[
				'name' => 'Marine Detachment',
				'description' => "When the standard security detail is not enough, marines come in and clean up; the marine detachment is a powerful tactical addition to any ship, responsible for partaking in personal combat, from sniping to melee.",
				'order' => 10
			],
			[
				'name' => 'Starfighter Wing',
				'description' => "The best pilots in Starfleet, they are responsible for piloting the starfighters in ship-to-ship battles, as well as providing escort for shuttles, and runabouts.",
				'order' => 11
			],
			[
				'name' => 'Civilian Affairs',
				'description' => "Civilians play an important role in Starfleet. Many civilian specialists across a number of fields work on occasion with Starfleet personnel as a Mission Specialist. In other cases, extra ship and station duties, such as running the ship's lounge, are outsourced to a civilian contract.",
				'order' => 12
			],
		];

		foreach ($data as $department) {
			Department::create($department);
		}
	}

	protected function ranks()
	{
		$groups = [
			['name' => 'Admiralty', 'order' => 0],
			['name' => 'Command', 'order' => 1],
			['name' => 'Operations', 'order' => 2],
			['name' => 'Sciences', 'order' => 3],
			['name' => 'Marines', 'order' => 4],
		];

		$info = [
			['name' => 'Admiral', 'short_name' => 'ADM', 'order' => 0],
			['name' => 'Vice Admiral', 'short_name' => 'VADM', 'order' => 1],
			['name' => 'Rear Admiral', 'short_name' => 'RADM', 'order' => 2],
			['name' => 'Commodore', 'short_name' => 'COMO', 'order' => 3],
			['name' => 'Captain', 'short_name' => 'CAPT', 'order' => 4],
			['name' => 'Commander', 'short_name' => 'CMDR', 'order' => 5],
			['name' => 'Lieutenant Commander', 'short_name' => 'LT CMDR', 'order' => 6],
			['name' => 'Lieutenant', 'short_name' => 'LT', 'order' => 7],
			['name' => 'Lieutenant (JG)', 'short_name' => 'LT JG', 'order' => 8],
			['name' => 'Ensign', 'short_name' => 'ENS', 'order' => 9],
			['name' => 'Master Chief Petty Officer', 'short_name' => 'MCPO', 'order' => 10],
			['name' => 'Senior Chief Petty Officer', 'short_name' => 'SCPO', 'order' => 11],
			['name' => 'Chief Petty Officer', 'short_name' => 'CPO', 'order' => 12],
			['name' => 'Petty Officer 1st Class', 'short_name' => 'PO1', 'order' => 13],
			['name' => 'Petty Officer 2nd Class', 'short_name' => 'PO2', 'order' => 14],
			['name' => 'Petty Officer 3rd Class', 'short_name' => 'PO3', 'order' => 15],
			['name' => 'Crewman 1st Class', 'short_name' => 'CR1', 'order' => 16],
			['name' => 'Crewman 2nd Class', 'short_name' => 'CR2', 'order' => 17],
			['name' => 'Crewman 3rd Class', 'short_name' => 'CR3', 'order' => 18],

			['name' => 'General', 'short_name' => 'GEN', 'order' => 20],
			['name' => 'Lieutenant General', 'short_name' => 'LT GEN', 'order' => 21],
			['name' => 'Major General', 'short_name' => 'MAJ GEN', 'order' => 22],
			['name' => 'Brigadier General', 'short_name' => 'BRG GEN', 'order' => 23],
			['name' => 'Colonel', 'short_name' => 'COL', 'order' => 24],
			['name' => 'Lieutenant Colonel', 'short_name' => 'LT COL', 'order' => 25],
			['name' => 'Major', 'short_name' => 'MAJ', 'order' => 26],
			['name' => 'Captain', 'short_name' => 'MCAPT', 'order' => 27],
			['name' => '1st Lieutenant', 'short_name' => '1LT', 'order' => 28],
			['name' => '2nd Lieutenant', 'short_name' => '2LT', 'order' => 29],
			['name' => 'Sergeant Major', 'short_name' => 'SGT MAJ', 'order' => 30],
			['name' => 'Master Sergeant', 'short_name' => 'MSGT', 'order' => 31],
			['name' => 'Gunnery Sergeant', 'short_name' => 'GSGT', 'order' => 32],
			['name' => 'Staff Sergeant', 'short_name' => 'SSGT', 'order' => 33],
			['name' => 'Sergeant', 'short_name' => 'SGT', 'order' => 34],
			['name' => 'Corporal', 'short_name' => 'CPL', 'order' => 35],
			['name' => 'Private 1st Class', 'short_name' => 'PVT1', 'order' => 36],
			['name' => 'Private E-2', 'short_name' => 'PVT E2', 'order' => 37],
			['name' => 'Private E-1', 'short_name' => 'PVT E1', 'order' => 38],
		];

		collect($groups)->each(function ($group) {
			factory(RankGroup::class)->create($group);
		});

		collect($info)->each(function ($i) {
			factory(RankInfo::class)->create($i);
		});
	}
}
