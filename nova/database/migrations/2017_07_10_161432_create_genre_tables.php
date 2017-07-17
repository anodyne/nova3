<?php

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

		$this->departments();
	}

	public function down()
	{
		Schema::dropIfExists('departments');
		Schema::dropIfExists('positions');
		Schema::dropIfExists('ranks_groups');
		Schema::dropIfExists('ranks_info');
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
}
