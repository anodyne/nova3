<?php
/**
 * Genre Install Data (ST:24)
 *
 * @package		Install
 * @category	Assets
 * @author		Anodyne Productions
 */

$g = 'st24';

$data = array(
	'departments_'.$g 	=> 'depts',
	'rank_info_'.$g		=> 'info',
	'rank_groups_'.$g	=> 'groups',
	'ranks_'.$g			=> 'ranks',
	'positions_'.$g		=> 'positions',
	'catalog_ranks'		=> 'catalog_ranks',
);

$depts = array(
	array(
		'name' => 'Command',
		'desc' => "The Command department is ultimately responsible for the ship and its crew, and those within the department are responsible for commanding the vessel and representing the interests of Starfleet.",
		'order' => 0),
	array(
		'name' => 'Flight Control',
		'desc' => "Responsible for the navigation and flight control of a vessel and its auxiliary craft, the Flight Control department includes pilots trained in both starship and auxiliary craft piloting. Note that the Flight Control department does not include Fighter pilots.",
		'order' => 1),
	array(
		'name' => 'Strategic Operations',
		'desc' => "The Strategic Operations department acts as an advisory to the command staff, as well as a resource of knowledge and information concerning hostile races in the operational zone of the ship, as well as combat strategies and other such things.",
		'order' => 2),
	array(
		'name' => 'Security &amp; Tactical',
		'desc' => "Merging the responsibilities of ship-to-ship and personnel combat into a single department, the security & tactical department is responsible for the tactical readiness of the vessel and the security of the ship.",
		'order' => 3),
	array(
		'name' => 'Operations',
		'desc' => "The operations department is responsible for keeping ship systems functioning properly, rerouting power, bypassing relays, and doing whatever else is necessary to keep the ship operating at peak efficiency.",
		'order' => 4),
	array(
		'name' => 'Engineering',
		'desc' => "The engineering department has the enormous task of keeping the ship working; they are responsible for making repairs, fixing problems, and making sure that the ship is ready for anything.",
		'order' => 5),
	array(
		'name' => 'Science',
		'desc' => "From sensor readings to figuring out a way to enter the strange spacial anomaly, the science department is responsible for recording data, testing new ideas out, and making discoveries.",
		'order' => 6),
	array(
		'name' => 'Medical &amp; Counseling',
		'desc' => "The medical & counseling department is responsible for the mental and physical health of the crew, from running annual physicals to combatting a strange plague that is afflicting the crew to helping a crew member deal with the loss of a loved one.",
		'order' => 7),
	array(
		'name' => 'Intelligence',
		'desc' => "The Intelligence department is responsible for gathering and providing intelligence as it becomes possible during a mission; during covert missions, the intelligence department also takes a more active role, providing the necessary classified and other information.",
		'order' => 8),
	array(
		'name' => 'Diplomatic Detachment',
		'desc' => "Responsible for representing the Federation and its interest, members of the Diplomatic Corps are members of the civilian branch of the Federation.",
		'order' => 9),
	array(
		'name' => 'Marine Detachment',
		'desc' => "When the standard security detail is not enough, marines come in and clean up; the marine detachment is a powerful tactical addition to any ship, responsible for partaking in personal combat, from sniping to melee.",
		'order' => 10),
	array(
		'name' => 'Starfighter Wing',
		'desc' => "The best pilots in Starfleet, they are responsible for piloting the starfighters in ship-to-ship battles, as well as providing escort for shuttles, and runabouts.",
		'order' => 11),
	array(
		'name' => 'Civilian Affairs',
		'desc' => "Civilians play an important role in Starfleet. Many civilian specialists across a number of fields work on occasion with Starfleet personnel as a Mission Specialist. In other cases, extra ship and station duties, such as running the ship's lounge, are outsourced to a civilian contract.",
		'order' => 12)
);

$groups = array(
	array(
		'name' => 'Naval Admiralty',
		'order' => 0),
	array(
		'name' => 'Marine Admiralty',
		'order' => 1),
	array(
		'name' => 'Command',
		'order' => 2),
	array(
		'name' => 'Operations',
		'order' => 3),
	array(
		'name' => 'Sciences',
		'order' => 4),
	array(
		'name' => 'Aerospace Operations',
		'order' => 5),
	array(
		'name' => 'Intelligence',
		'order' => 6),
	array(
		'name' => 'Diplomatic Corps',
		'order' => 7),
	array(
		'name' => 'Marine',
		'order' => 8),
);

$info = array(
	array(
		'name' => "Fleet Admiral",
		'short_name' => "FADM",
		'order' => 0,
		'group' => 1),
	array(
		'name' => "Admiral",
		'short_name' => "ADM",
		'order' => 1,
		'group' => 1),
	array(
		'name' => "Vice Admiral",
		'short_name' => "VADM",
		'order' => 2,
		'group' => 1),
	array(
		'name' => "Rear Admiral",
		'short_name' => "RADM",
		'order' => 3,
		'group' => 1),
	array(
		'name' => "Commodore",
		'short_name' => "COM",
		'order' => 4,
		'group' => 1),

	array(
		'name' => "Field Marshal",
		'short_name' => "FMSL",
		'order' => 0,
		'group' => 2),
	array(
		'name' => "General",
		'short_name' => "GEN",
		'order' => 1,
		'group' => 2),
	array(
		'name' => "Lieutenant General",
		'short_name' => "LTGEN",
		'order' => 2,
		'group' => 2),
	array(
		'name' => "Major General",
		'short_name' => "MGEN",
		'order' => 3,
		'group' => 2),
	array(
		'name' => "Brigadier General",
		'short_name' => "BGEN",
		'order' => 4,
		'group' => 2),

	array(
		'name' => "Captain",
		'short_name' => "CAPT",
		'order' => 10,
		'group' => 3),
	array(
		'name' => "Commander",
		'short_name' => "CMDR",
		'order' => 11,
		'group' => 3),
	array(
		'name' => "Lieutenant Commander",
		'short_name' => "LTCMDR",
		'order' => 12,
		'group' => 3),
	array(
		'name' => "Lieutenant",
		'short_name' => "LT",
		'order' => 13,
		'group' => 3),
	array(
		'name' => "Lieutenant JG",
		'short_name' => "LT(JG)",
		'order' => 14,
		'group' => 3),
	array(
		'name' => "Ensign",
		'short_name' => "ENS",
		'order' => 15,
		'group' => 3),

	array(
		'name' => "Colonel",
		'short_name' => "COL",
		'order' => 10,
		'group' => 4),
	array(
		'name' => "Lieutenant Colonel",
		'short_name' => "LTCOL",
		'order' => 11,
		'group' => 4),
	array(
		'name' => "Major",
		'short_name' => "MAJ",
		'order' => 12,
		'group' => 4),
	array(
		'name' => "Captain",
		'short_name' => "CAPT",
		'order' => 13,
		'group' => 4),
	array(
		'name' => "1st Lieutenant",
		'short_name' => "1LT",
		'order' => 14,
		'group' => 4),
	array(
		'name' => "2nd Lieutenant",
		'short_name' => "2LT",
		'order' => 15,
		'group' => 4),

	array(
		'name' => "Master Chief Warrant Officer",
		'short_name' => "MCWO",
		'order' => 20,
		'group' => 5),
	array(
		'name' => "Senior Chief Warrant Officer",
		'short_name' => "SCWO",
		'order' => 21,
		'group' => 5),
	array(
		'name' => "Chief Warrant Officer",
		'short_name' => "CWO",
		'order' => 22,
		'group' => 5),
	array(
		'name' => "Senior Warrant Officer",
		'short_name' => "SWO",
		'order' => 23,
		'group' => 5),
	array(
		'name' => "Warrant Officer",
		'short_name' => "WO",
		'order' => 24,
		'group' => 5),

	array(
		'name' => "Master Chief Petty Officer",
		'short_name' => "MCPO",
		'order' => 30,
		'group' => 6),
	array(
		'name' => "Senior Chief Petty Officer",
		'short_name' => "SCPO",
		'order' => 31,
		'group' => 6),
	array(
		'name' => "Chief Petty Officer",
		'short_name' => "CPO",
		'order' => 32,
		'group' => 6),
	array(
		'name' => "Petty Officer 1st Class",
		'short_name' => "PO1",
		'order' => 33,
		'group' => 6),
	array(
		'name' => "Petty Officer 2nd Class",
		'short_name' => "PO2",
		'order' => 34,
		'group' => 6),
	array(
		'name' => "Petty Officer 3rd Class",
		'short_name' => "PO3",
		'order' => 35,
		'group' => 6),
	array(
		'name' => "Crewman",
		'short_name' => "CN",
		'order' => 36,
		'group' => 6),
	array(
		'name' => "Crewman Apprentice",
		'short_name' => "CA",
		'order' => 37,
		'group' => 6),
	array(
		'name' => "Crewman Recruit",
		'short_name' => "CR",
		'order' => 38,
		'group' => 6),
	
	array(
		'name' => "Sergeant Major",
		'short_name' => "SGTMAJ",
		'order' => 30,
		'group' => 7),
	array(
		'name' => "Master Sergeant",
		'short_name' => "MSGT",
		'order' => 31,
		'group' => 7),
	array(
		'name' => "Gunnery Sergeant",
		'short_name' => "GSGT",
		'order' => 32,
		'group' => 7),
	array(
		'name' => "Staff Sergeant",
		'short_name' => "SSGT",
		'order' => 33,
		'group' => 7),
	array(
		'name' => "Sergeant",
		'short_name' => "SGT",
		'order' => 34,
		'group' => 7),
	array(
		'name' => "Corporal",
		'short_name' => "CPL",
		'order' => 35,
		'group' => 7),
	array(
		'name' => "Lance Corporal",
		'short_name' => "LCPL",
		'order' => 36,
		'group' => 7),
	array(
		'name' => "Private 1st Class",
		'short_name' => "PVT1",
		'order' => 37,
		'group' => 7),
	array(
		'name' => "Private",
		'short_name' => "PVT",
		'order' => 38,
		'group' => 7),

	array(
		'name' => "Chief Master Sergeant",
		'short_name' => "CMSGT",
		'order' => 30,
		'group' => 8),
	array(
		'name' => "Senior Master Sergeant",
		'short_name' => "SMSGT",
		'order' => 31,
		'group' => 8),
	array(
		'name' => "Master Sergeant",
		'short_name' => "MSGT",
		'order' => 32,
		'group' => 8),
	array(
		'name' => "Technical Sergeant",
		'short_name' => "TSGT",
		'order' => 33,
		'group' => 8),
	array(
		'name' => "Staff Sergeant",
		'short_name' => "SSGT",
		'order' => 34,
		'group' => 8),
	array(
		'name' => "Senior Airman",
		'short_name' => "SRA",
		'order' => 35,
		'group' => 8),
	array(
		'name' => "Airman 1st Class",
		'short_name' => "A1C",
		'order' => 36,
		'group' => 8),
	array(
		'name' => "Airman",
		'short_name' => "AMN",
		'order' => 37,
		'group' => 8),
	array(
		'name' => "Airman Basic",
		'short_name' => "AB",
		'order' => 38,
		'group' => 8),

	array(
		'name' => "Cadet Senior Grade",
		'short_name' => "CDT(SR)",
		'order' => 50,
		'group' => 9),
	array(
		'name' => "Cadet Junior Grade",
		'short_name' => "CDT(JR)",
		'order' => 51,
		'group' => 9),
	array(
		'name' => "Cadet Sophomore Grade",
		'short_name' => "CDT(SO)",
		'order' => 52,
		'group' => 9),
	array(
		'name' => "Cadet Freshman Grade",
		'short_name' => "CDT(FR)",
		'order' => 53,
		'group' => 9),
	array(
		'name' => "Enlisted Cadet",
		'short_name' => "CDT(EN)",
		'order' => 54,
		'group' => 9),
);

$ranks = array(
	/**
	 * Naval Admiralty
	 */
	array(
		'info_id' => 1,
		'group_id' => 1,
		'base' => 'red',
		'pip' => 'a5'),
	array(
		'info_id' => 2,
		'group_id' => 1,
		'base' => 'red',
		'pip' => 'a4'),
	array(
		'info_id' => 3,
		'group_id' => 1,
		'base' => 'red',
		'pip' => 'a3'),
	array(
		'info_id' => 4,
		'group_id' => 1,
		'base' => 'red',
		'pip' => 'a2'),
	array(
		'info_id' => 5,
		'group_id' => 1,
		'base' => 'red',
		'pip' => 'a1'),

	/**
	 * Marine Admiralty
	 */
	array(
		'info_id' => 6,
		'group_id' => 2,
		'base' => 'green',
		'pip' => 'marine/a5'),
	array(
		'info_id' => 7,
		'group_id' => 2,
		'base' => 'green',
		'pip' => 'marine/a4'),
	array(
		'info_id' => 8,
		'group_id' => 2,
		'base' => 'green',
		'pip' => 'marine/a3'),
	array(
		'info_id' => 9,
		'group_id' => 2,
		'base' => 'green',
		'pip' => 'marine/a2'),
	array(
		'info_id' => 10,
		'group_id' => 2,
		'base' => 'green',
		'pip' => 'marine/a1'),

	/**
	 * Command
	 */
	array(
		'info_id' => 11,
		'group_id' => 3,
		'base' => 'red',
		'pip' => 'o6'),
	array(
		'info_id' => 12,
		'group_id' => 3,
		'base' => 'red',
		'pip' => 'o5'),
	array(
		'info_id' => 13,
		'group_id' => 3,
		'base' => 'red',
		'pip' => 'o4'),
	array(
		'info_id' => 14,
		'group_id' => 3,
		'base' => 'red',
		'pip' => 'o3'),
	array(
		'info_id' => 15,
		'group_id' => 3,
		'base' => 'red',
		'pip' => 'o2'),
	array(
		'info_id' => 16,
		'group_id' => 3,
		'base' => 'red',
		'pip' => 'o1'),
	array(
		'info_id' => 23,
		'group_id' => 3,
		'base' => 'red',
		'pip' => 'w5'),
	array(
		'info_id' => 24,
		'group_id' => 3,
		'base' => 'red',
		'pip' => 'w4'),
	array(
		'info_id' => 25,
		'group_id' => 3,
		'base' => 'red',
		'pip' => 'w3'),
	array(
		'info_id' => 26,
		'group_id' => 3,
		'base' => 'red',
		'pip' => 'w2'),
	array(
		'info_id' => 27,
		'group_id' => 3,
		'base' => 'red',
		'pip' => 'w1'),
	array(
		'info_id' => 28,
		'group_id' => 3,
		'base' => 'red',
		'pip' => 'e9'),
	array(
		'info_id' => 29,
		'group_id' => 3,
		'base' => 'red',
		'pip' => 'e8'),
	array(
		'info_id' => 30,
		'group_id' => 3,
		'base' => 'red',
		'pip' => 'e7'),
	array(
		'info_id' => 31,
		'group_id' => 3,
		'base' => 'red',
		'pip' => 'e6'),
	array(
		'info_id' => 32,
		'group_id' => 3,
		'base' => 'red',
		'pip' => 'e5'),
	array(
		'info_id' => 33,
		'group_id' => 3,
		'base' => 'red',
		'pip' => 'e4'),
	array(
		'info_id' => 34,
		'group_id' => 3,
		'base' => 'red',
		'pip' => 'e3'),
	array(
		'info_id' => 35,
		'group_id' => 3,
		'base' => 'red',
		'pip' => 'e2'),
	array(
		'info_id' => 36,
		'group_id' => 3,
		'base' => 'red',
		'pip' => 'e1'),

	/**
	 * Operations
	 */
	array(
		'info_id' => 11,
		'group_id' => 4,
		'base' => 'yellow',
		'pip' => 'o6'),
	array(
		'info_id' => 12,
		'group_id' => 4,
		'base' => 'yellow',
		'pip' => 'o5'),
	array(
		'info_id' => 13,
		'group_id' => 4,
		'base' => 'yellow',
		'pip' => 'o4'),
	array(
		'info_id' => 14,
		'group_id' => 4,
		'base' => 'yellow',
		'pip' => 'o3'),
	array(
		'info_id' => 15,
		'group_id' => 4,
		'base' => 'yellow',
		'pip' => 'o2'),
	array(
		'info_id' => 16,
		'group_id' => 4,
		'base' => 'yellow',
		'pip' => 'o1'),
	array(
		'info_id' => 23,
		'group_id' => 4,
		'base' => 'yellow',
		'pip' => 'w5'),
	array(
		'info_id' => 24,
		'group_id' => 4,
		'base' => 'yellow',
		'pip' => 'w4'),
	array(
		'info_id' => 25,
		'group_id' => 4,
		'base' => 'yellow',
		'pip' => 'w3'),
	array(
		'info_id' => 26,
		'group_id' => 4,
		'base' => 'yellow',
		'pip' => 'w2'),
	array(
		'info_id' => 27,
		'group_id' => 4,
		'base' => 'yellow',
		'pip' => 'w1'),
	array(
		'info_id' => 28,
		'group_id' => 4,
		'base' => 'yellow',
		'pip' => 'e9'),
	array(
		'info_id' => 29,
		'group_id' => 4,
		'base' => 'yellow',
		'pip' => 'e8'),
	array(
		'info_id' => 30,
		'group_id' => 4,
		'base' => 'yellow',
		'pip' => 'e7'),
	array(
		'info_id' => 31,
		'group_id' => 4,
		'base' => 'yellow',
		'pip' => 'e6'),
	array(
		'info_id' => 32,
		'group_id' => 4,
		'base' => 'yellow',
		'pip' => 'e5'),
	array(
		'info_id' => 33,
		'group_id' => 4,
		'base' => 'yellow',
		'pip' => 'e4'),
	array(
		'info_id' => 34,
		'group_id' => 4,
		'base' => 'yellow',
		'pip' => 'e3'),
	array(
		'info_id' => 35,
		'group_id' => 4,
		'base' => 'yellow',
		'pip' => 'e2'),
	array(
		'info_id' => 36,
		'group_id' => 4,
		'base' => 'yellow',
		'pip' => 'e1'),

	/**
	 * Sciences
	 */
	array(
		'info_id' => 11,
		'group_id' => 5,
		'base' => 'teal',
		'pip' => 'o6'),
	array(
		'info_id' => 12,
		'group_id' => 5,
		'base' => 'teal',
		'pip' => 'o5'),
	array(
		'info_id' => 13,
		'group_id' => 5,
		'base' => 'teal',
		'pip' => 'o4'),
	array(
		'info_id' => 14,
		'group_id' => 5,
		'base' => 'teal',
		'pip' => 'o3'),
	array(
		'info_id' => 15,
		'group_id' => 5,
		'base' => 'teal',
		'pip' => 'o2'),
	array(
		'info_id' => 16,
		'group_id' => 5,
		'base' => 'teal',
		'pip' => 'o1'),
	array(
		'info_id' => 23,
		'group_id' => 5,
		'base' => 'teal',
		'pip' => 'w5'),
	array(
		'info_id' => 24,
		'group_id' => 5,
		'base' => 'teal',
		'pip' => 'w4'),
	array(
		'info_id' => 25,
		'group_id' => 5,
		'base' => 'teal',
		'pip' => 'w3'),
	array(
		'info_id' => 26,
		'group_id' => 5,
		'base' => 'teal',
		'pip' => 'w2'),
	array(
		'info_id' => 27,
		'group_id' => 5,
		'base' => 'teal',
		'pip' => 'w1'),
	array(
		'info_id' => 28,
		'group_id' => 5,
		'base' => 'teal',
		'pip' => 'e9'),
	array(
		'info_id' => 29,
		'group_id' => 5,
		'base' => 'teal',
		'pip' => 'e8'),
	array(
		'info_id' => 30,
		'group_id' => 5,
		'base' => 'teal',
		'pip' => 'e7'),
	array(
		'info_id' => 31,
		'group_id' => 5,
		'base' => 'teal',
		'pip' => 'e6'),
	array(
		'info_id' => 32,
		'group_id' => 5,
		'base' => 'teal',
		'pip' => 'e5'),
	array(
		'info_id' => 33,
		'group_id' => 5,
		'base' => 'teal',
		'pip' => 'e4'),
	array(
		'info_id' => 34,
		'group_id' => 5,
		'base' => 'teal',
		'pip' => 'e3'),
	array(
		'info_id' => 35,
		'group_id' => 5,
		'base' => 'teal',
		'pip' => 'e2'),
	array(
		'info_id' => 36,
		'group_id' => 5,
		'base' => 'teal',
		'pip' => 'e1'),

	/**
	 * Aerospace
	 */
	array(
		'info_id' => 11,
		'group_id' => 6,
		'base' => 'blue',
		'pip' => 'o6'),
	array(
		'info_id' => 12,
		'group_id' => 6,
		'base' => 'blue',
		'pip' => 'o5'),
	array(
		'info_id' => 13,
		'group_id' => 6,
		'base' => 'blue',
		'pip' => 'o4'),
	array(
		'info_id' => 14,
		'group_id' => 6,
		'base' => 'blue',
		'pip' => 'o3'),
	array(
		'info_id' => 15,
		'group_id' => 6,
		'base' => 'blue',
		'pip' => 'o2'),
	array(
		'info_id' => 16,
		'group_id' => 6,
		'base' => 'blue',
		'pip' => 'o1'),
	array(
		'info_id' => 23,
		'group_id' => 6,
		'base' => 'blue',
		'pip' => 'w5'),
	array(
		'info_id' => 24,
		'group_id' => 6,
		'base' => 'blue',
		'pip' => 'w4'),
	array(
		'info_id' => 25,
		'group_id' => 6,
		'base' => 'blue',
		'pip' => 'w3'),
	array(
		'info_id' => 26,
		'group_id' => 6,
		'base' => 'blue',
		'pip' => 'w2'),
	array(
		'info_id' => 27,
		'group_id' => 6,
		'base' => 'blue',
		'pip' => 'w1'),
	array(
		'info_id' => 46,
		'group_id' => 6,
		'base' => 'blue',
		'pip' => 'airforce/e9'),
	array(
		'info_id' => 47,
		'group_id' => 6,
		'base' => 'blue',
		'pip' => 'airforce/e8'),
	array(
		'info_id' => 48,
		'group_id' => 6,
		'base' => 'blue',
		'pip' => 'airforce/e7'),
	array(
		'info_id' => 49,
		'group_id' => 6,
		'base' => 'blue',
		'pip' => 'airforce/e6'),
	array(
		'info_id' => 50,
		'group_id' => 6,
		'base' => 'blue',
		'pip' => 'airforce/e5'),
	array(
		'info_id' => 51,
		'group_id' => 6,
		'base' => 'blue',
		'pip' => 'airforce/e4'),
	array(
		'info_id' => 52,
		'group_id' => 6,
		'base' => 'blue',
		'pip' => 'airforce/e3'),
	array(
		'info_id' => 53,
		'group_id' => 6,
		'base' => 'blue',
		'pip' => 'airforce/e2'),
	array(
		'info_id' => 54,
		'group_id' => 6,
		'base' => 'blue',
		'pip' => 'airforce/e1'),

	/**
	 * Intelligence
	 */
	array(
		'info_id' => 11,
		'group_id' => 7,
		'base' => 'grey',
		'pip' => 'o6'),
	array(
		'info_id' => 12,
		'group_id' => 7,
		'base' => 'grey',
		'pip' => 'o5'),
	array(
		'info_id' => 13,
		'group_id' => 7,
		'base' => 'grey',
		'pip' => 'o4'),
	array(
		'info_id' => 14,
		'group_id' => 7,
		'base' => 'grey',
		'pip' => 'o3'),
	array(
		'info_id' => 15,
		'group_id' => 7,
		'base' => 'grey',
		'pip' => 'o2'),
	array(
		'info_id' => 16,
		'group_id' => 7,
		'base' => 'grey',
		'pip' => 'o1'),
	array(
		'info_id' => 23,
		'group_id' => 7,
		'base' => 'grey',
		'pip' => 'w5'),
	array(
		'info_id' => 24,
		'group_id' => 7,
		'base' => 'grey',
		'pip' => 'w4'),
	array(
		'info_id' => 25,
		'group_id' => 7,
		'base' => 'grey',
		'pip' => 'w3'),
	array(
		'info_id' => 26,
		'group_id' => 7,
		'base' => 'grey',
		'pip' => 'w2'),
	array(
		'info_id' => 27,
		'group_id' => 7,
		'base' => 'grey',
		'pip' => 'w1'),
	array(
		'info_id' => 28,
		'group_id' => 7,
		'base' => 'grey',
		'pip' => 'e9'),
	array(
		'info_id' => 29,
		'group_id' => 7,
		'base' => 'grey',
		'pip' => 'e8'),
	array(
		'info_id' => 30,
		'group_id' => 7,
		'base' => 'grey',
		'pip' => 'e7'),
	array(
		'info_id' => 31,
		'group_id' => 7,
		'base' => 'grey',
		'pip' => 'e6'),
	array(
		'info_id' => 32,
		'group_id' => 7,
		'base' => 'grey',
		'pip' => 'e5'),
	array(
		'info_id' => 33,
		'group_id' => 7,
		'base' => 'grey',
		'pip' => 'e4'),
	array(
		'info_id' => 34,
		'group_id' => 7,
		'base' => 'grey',
		'pip' => 'e3'),
	array(
		'info_id' => 35,
		'group_id' => 7,
		'base' => 'grey',
		'pip' => 'e2'),
	array(
		'info_id' => 36,
		'group_id' => 7,
		'base' => 'grey',
		'pip' => 'e1'),

	/**
	 * Diplomatic
	 */
	array(
		'info_id' => 11,
		'group_id' => 8,
		'base' => 'violet',
		'pip' => 'o6'),
	array(
		'info_id' => 12,
		'group_id' => 8,
		'base' => 'violet',
		'pip' => 'o5'),
	array(
		'info_id' => 13,
		'group_id' => 8,
		'base' => 'violet',
		'pip' => 'o4'),
	array(
		'info_id' => 14,
		'group_id' => 8,
		'base' => 'violet',
		'pip' => 'o3'),
	array(
		'info_id' => 15,
		'group_id' => 8,
		'base' => 'violet',
		'pip' => 'o2'),
	array(
		'info_id' => 16,
		'group_id' => 8,
		'base' => 'violet',
		'pip' => 'o1'),
	array(
		'info_id' => 23,
		'group_id' => 8,
		'base' => 'violet',
		'pip' => 'w5'),
	array(
		'info_id' => 24,
		'group_id' => 8,
		'base' => 'violet',
		'pip' => 'w4'),
	array(
		'info_id' => 25,
		'group_id' => 8,
		'base' => 'violet',
		'pip' => 'w3'),
	array(
		'info_id' => 26,
		'group_id' => 8,
		'base' => 'violet',
		'pip' => 'w2'),
	array(
		'info_id' => 27,
		'group_id' => 8,
		'base' => 'violet',
		'pip' => 'w1'),
	array(
		'info_id' => 28,
		'group_id' => 8,
		'base' => 'violet',
		'pip' => 'e9'),
	array(
		'info_id' => 29,
		'group_id' => 8,
		'base' => 'violet',
		'pip' => 'e8'),
	array(
		'info_id' => 30,
		'group_id' => 8,
		'base' => 'violet',
		'pip' => 'e7'),
	array(
		'info_id' => 31,
		'group_id' => 8,
		'base' => 'violet',
		'pip' => 'e6'),
	array(
		'info_id' => 32,
		'group_id' => 8,
		'base' => 'violet',
		'pip' => 'e5'),
	array(
		'info_id' => 33,
		'group_id' => 8,
		'base' => 'violet',
		'pip' => 'e4'),
	array(
		'info_id' => 34,
		'group_id' => 8,
		'base' => 'violet',
		'pip' => 'e3'),
	array(
		'info_id' => 35,
		'group_id' => 8,
		'base' => 'violet',
		'pip' => 'e2'),
	array(
		'info_id' => 36,
		'group_id' => 8,
		'base' => 'violet',
		'pip' => 'e1'),

	/**
	 * Marine
	 */
	array(
		'info_id' => 17,
		'group_id' => 9,
		'base' => 'green',
		'pip' => 'marine/o6'),
	array(
		'info_id' => 18,
		'group_id' => 9,
		'base' => 'green',
		'pip' => 'marine/o5'),
	array(
		'info_id' => 19,
		'group_id' => 9,
		'base' => 'green',
		'pip' => 'marine/o4'),
	array(
		'info_id' => 20,
		'group_id' => 9,
		'base' => 'green',
		'pip' => 'marine/o3'),
	array(
		'info_id' => 21,
		'group_id' => 9,
		'base' => 'green',
		'pip' => 'marine/o2'),
	array(
		'info_id' => 22,
		'group_id' => 9,
		'base' => 'green',
		'pip' => 'marine/o1'),
	array(
		'info_id' => 23,
		'group_id' => 9,
		'base' => 'green',
		'pip' => 'marine/w5'),
	array(
		'info_id' => 24,
		'group_id' => 9,
		'base' => 'green',
		'pip' => 'marine/w4'),
	array(
		'info_id' => 25,
		'group_id' => 9,
		'base' => 'green',
		'pip' => 'marine/w3'),
	array(
		'info_id' => 26,
		'group_id' => 9,
		'base' => 'green',
		'pip' => 'marine/w2'),
	array(
		'info_id' => 27,
		'group_id' => 9,
		'base' => 'green',
		'pip' => 'marine/w1'),
	array(
		'info_id' => 37,
		'group_id' => 9,
		'base' => 'green',
		'pip' => 'marine/e9'),
	array(
		'info_id' => 38,
		'group_id' => 9,
		'base' => 'green',
		'pip' => 'marine/e8'),
	array(
		'info_id' => 39,
		'group_id' => 9,
		'base' => 'green',
		'pip' => 'marine/e7'),
	array(
		'info_id' => 40,
		'group_id' => 9,
		'base' => 'green',
		'pip' => 'marine/e6'),
	array(
		'info_id' => 41,
		'group_id' => 9,
		'base' => 'green',
		'pip' => 'marine/e5'),
	array(
		'info_id' => 42,
		'group_id' => 9,
		'base' => 'green',
		'pip' => 'marine/e4'),
	array(
		'info_id' => 43,
		'group_id' => 9,
		'base' => 'green',
		'pip' => 'marine/e3'),
	array(
		'info_id' => 44,
		'group_id' => 9,
		'base' => 'green',
		'pip' => 'marine/e2'),
	array(
		'info_id' => 45,
		'group_id' => 9,
		'base' => 'green',
		'pip' => 'marine/e1'),
);

$positions = array(
	array(
		'name' => 'Commanding Officer',
		'desc' => "Ultimately responsible for the ship and crew, the Commanding Officer is the most senior officer aboard a vessel. S/he is responsible for carrying out the orders of Starfleet, and for representing both Starfleet and the Federation.",
		'dept_id' => 1,
		'order' => 0,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => 'Executive Officer',
		'desc' => "The liaison between captain and crew, the Executive Officer acts as the disciplinarian, personnel manager, advisor to the captain, and much more. S/he is also one of only two officers, along with the Chief Medical Officer, that can remove a Commanding Officer from duty.",
		'dept_id' => 1,
		'order' => 1,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => 'Second Officer',
		'desc' => "At times the XO must assume command of a Starship or base, when this happens the XO needs the help of another officer to assume his/her role as XO. The second officer is not a stand alone position, but a role given to the highest ranked and trusted officer aboard. When required the Second Officer will assume the role of XO, or if needed CO, and performs their duties as listed, for as long as required.",
		'dept_id' => 1,
		'order' => 2,
		'open' => 1,
		'type' => 'officer'),
	array(
		'name' => 'Chief of the Boat',
		'desc' => "The seniormost Chief Petty Officer (including Senior and Master Chiefs), regardless of rating, is designated by the Commanding Officer as the Chief of the Boat (for vessels) or Command Chief (for starbases). In addition to his or her departmental responsibilities, the COB/CC performs the following duties: serves as a liaison between the Commanding Officer (or Executive Officer) and the enlisted crewmen; ensures enlisted crews understand Command policies; advises the Commanding Officer and Executive Officer regarding enlisted morale, and evaluates the quality of noncommissioned officer leadership, management, and supervisory training.\r\n\r\nThe COB/CC works with the other department heads, Chiefs, supervisors, and crewmen to insure discipline is equitably maintained, and the welfare, morale, and health needs of the enlisted personnel are met. The COB/CC is qualified to temporarily act as Commanding or Executive Officer if so ordered.",
		'dept_id' => 1,
		'order' => 3,
		'open' => 1,
		'type' => 'enlisted'),
	array(
		'name' => 'Mission Advisor',
		'desc' => "Advises the Commanding Officer and Executive Officer on mission-specific areas of importance. Many times, the Mission Advisor knows just as much about the mission as the CO and XO do, if not even more. He or she also performs mission-specific tasks, and can take on any roles that a mission requires him or her to do. Concurrently holds another position, except in rare circumstances.",
		'dept_id' => 1,
		'order' => 4,
		'open' => 1,
		'type' => 'officer'),
	array(
		'name' => 'Yeoman',
		'desc' => "The Captain's Yeoman is for Petty Officers who wish to continue as administrators. It is technically a non-Mate position. Use of this position is completely at the discretion of the Commanding Officer. File work, and sensitive message transport are but two examples of the Yeoman's possible duties. The Yeoman assists the CO in day-to-day duties that the CO would otherwise not have the time to do.",
		'dept_id' => 1,
		'order' => 5,
		'open' => 1,
		'type' => 'enlisted'),
	
	array(
		'name' => 'Chief Flight Control Officer',
		'desc' => "Originally known as helm, or Flight Control Officer, CONN incorporates two job, Navigation and flight control. A Flight Control Officer must always be present on the bridge of a starship. S/he plots courses, supervises the computers piloting, corrects any flight deviations and pilots the ship manually when needed. The Chief Flight Control Officer is the senior most CONN Officer aboard, serving as a Senior Officer, and chief of the personnel under him/her.",
		'dept_id' => 2,
		'order' => 0,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => 'Assistant Chief Flight Control Officer',
		'desc' => "Originally known as helm, or Flight Control Officer, CONN incorporates two job, Navigation and flight control. A Flight Control Officer must always be present on the bridge of a starship. S/he plots courses, supervises the computers piloting, corrects any flight deviations and pilots the ship manually when needed. The Assistant Chief Flight Control Officer is the second senior most CONN Officer aboard and reports directly to the Chief Flight Control Officer.",
		'dept_id' => 2,
		'order' => 1,
		'open' => 1,
		'type' => 'officer'),
	array(
		'name' => 'Flight Control Officer',
		'desc' => "Originally know as helm, or Flight Control Officer, CONN incorporates two job, navigation and flight control. A Flight Control Officer must always be present on the bridge of a starship, and every vessel has a number of Flight Control Officers to allow shift rotations. S/he plots courses, supervises the computers piloting, corrects any flight deviations and pilots the ship manually when needed. Flight Control Officers report to the Chief Flight Control Officer.",
		'dept_id' => 2,
		'order' => 2,
		'open' => 3,
		'type' => 'officer'),
	array(
		'name' => 'Shuttlebay Manager',
		'desc' => "The Shuttlebay Manager is responsible for pre and post flight checks of all support craft involved in away missions. Once a support craft has been brought to the flight line, it is his/her duty to ensure that it is mission capable. Upon returning from a mission, he/she must inspect the support craft and prepare a report on any maintenance that is required.\r\n\r\nHe/she is also responsible for the placement of support craft in order to allow for maximum efficiency of the shuttlebay.",
		'dept_id' => 2,
		'order' => 3,
		'open' => 1,
		'type' => 'officer'),
	array(
		'name' => 'Chief Support Craft Pilot',
		'desc' => "All small spacecrafts aboard a starship, starbase or a facility (Shuttles, Runabouts, Transports, Captain's yacht, Patrol Vessels etc.) but excluding fighters are flown by Support Craft Pilots. This is often the proving ground for pilots until they earn a berth on a starship as a Flight Control Officer.\r\n\r\nThe Chief Support Craft Pilot reports to the Chief Flight Control Officer.",
		'dept_id' => 2,
		'order' => 4,
		'open' => 1,
		'type' => 'officer'),
	array(
		'name' => 'Support Craft Pilot',
		'desc' => "All small spacecrafts aboard a starship, starbase or a facility (Shuttles, Runabouts, Transports, Captain's yacht, Patrol Vessels etc.) but excluding fighters are flown by Support Craft Pilots. This is often the proving ground for pilots until they earn a berth on a starship as a Flight Control Officer. They report to the Chief Support Craft Pilot.",
		'dept_id' => 2,
		'order' => 5,
		'open' => 4,
		'type' => 'officer'),
		
	array(
		'name' => 'Chief Strategic Operations Officer',
		'desc' => "The Chief Strategic Operations Officer is responsible for coordinating all Starfleet and allied assets in within their designated area of space, as well as tactical analysis (in the absence of a dedicated tactical department) and intelligence gathering (in the absence of a dedicated intelligence department).",
		'dept_id' => 3,
		'order' => 0,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => 'Assistant Chief Strategic Operations Officer',
		'desc' => "The Assistant Chief Strategic Operations Officer is the second ranked officer in the Strategic Operations department. He or she answers to the Chief Strategic Operations Officer. He or she is responsible for coordinating Starfleet and allied assets within a designated area of space, as well as tactical analysis and intelligence gathering.",
		'dept_id' => 3,
		'order' => 1,
		'open' => 1,
		'type' => 'officer'),
	array(
		'name' => 'Strategic Operations Officer',
		'desc' => "The Strategic Operations Officer is part of the Strategic Operations department. He or she answers to the Chief Strategic Operations Officer. He or she is responsible for coordinating Starfleet and allied assets within a designated area of space, as well as tactical analysis and intelligence gathering.",
		'dept_id' => 3,
		'order' => 2,
		'open' => 3,
		'type' => 'officer'),
	
	array(
		'name' => 'Chief Security/Tactial Officer',
		'desc' => "The Chief Security Officer is called Chief of Security. Her/his duty is to ensure the safety of ship and crew. Some take it as their personal duty to protect the Commanding Officer/Executive Officer on away teams. She/he is also responsible for people under arrest and the safety of guests, liked or not.  S/he also is a department head and a member of the senior staff, responsible for all the crew members in her/his department and duty rosters. Security could be called the 24th century police force.\r\n\r\nThe Chief of Security role can also be combined with the Chief Tactical Officer position.",
		'dept_id' => 4,
		'order' => 0,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => 'Assistant Chief Security/Tactial Officer',
		'desc' => "The Assistant Chief Security Officer is sometimes called Deputy of Security. S/he assists the Chief of Security in the daily work; in issues regarding Security and any administrative matters.  If required the Deputy must be able to take command of the Security department.",
		'dept_id' => 4,
		'order' => 1,
		'open' => 1,
		'type' => 'officer'),
	array(
		'name' => 'Security Officer',
		'desc' => "There are several Security Officers aboard each vessel. They are assigned to their duties by the Chief of Security and his/her Deputy and mostly guard sensitive areas, protect people, patrol, and handle other threats to the Federation.",
		'dept_id' => 4,
		'order' => 10,
		'open' => 3,
		'type' => 'officer'),
	array(
		'name' => 'Tactical Officer',
		'desc' => "The Tactical Officers are the vessels gunmen. They assist the Chief Tactical Officer by running and maintaining the numerous weapons systems aboard the ship/starbase, and analysis and tactical planning of current missions. Very often Tactical Officers are also trained in ground combat and small unit tactics.",
		'dept_id' => 4,
		'order' => 15,
		'open' => 3,
		'type' => 'officer'),
	array(
		'name' => 'Security Investigations Officer',
		'desc' => "The Security Investigations Officer is an Enlisted Officer. S/He fulfills the role of a special investigator or detective when dealing with Starfleet matters aboard ship or on a planet. Coordinates with the Chief Security Officer on all investigations as needed. The Security Investigations Officer reports to the Chief of Security.",
		'dept_id' => 4,
		'order' => 20,
		'open' => 1,
		'type' => 'officer'),
	array(
		'name' => 'Brig Officer',
		'desc' => "The Brig Officer is a Security Officer who has chosen to specialize in a specific role. S/he guards the brig and its cells. But there are other duties associated with this post as well. S/he is responsible for any prisoner transport, and the questioning of prisoners. Often Brig Officers have a good knowledge of forcefield technology, and are experts in escaping such confinements.",
		'dept_id' => 4,
		'order' => 25,
		'open' => 3,
		'type' => 'enlisted'),
	array(
		'name' => 'Master-at-Arms',
		'desc' => "The Master-at-Arms trains and supervises Security crewmen in departmental operations, repairs, and protocols; maintains duty assignments for all Security personnel; supervises weapons locker access and firearm deployment; and is qualified to temporarily act as Chief of Security if so ordered. The Master-at-Arms reports to the Chief of Security.",
		'dept_id' => 4,
		'order' => 30,
		'open' => 1,
		'type' => 'enlisted'),
		
	array(
		'name' => 'Chief Operations Officer',
		'desc' => "The Chief Operations Officer has the primary responsibility of ensuring that ship functions, such as the use of the lateral sensor array, do not interfere with one and another. S/he must prioritize resource allocations, so that the most critical activities can have every chance of success. If so required, s/he can curtail shipboard functions if s/he thinks they will interfere with the ship's current mission or routine operations.\r\n\r\nThe Chief Operations Officer oversees the Operations department, and is a member of the senior staff.",
		'dept_id' => 5,
		'order' => 0,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => 'Assistant Chief Operations Officer',
		'desc' => "The Chief Operations Officer cannot man the bridge at all times. Extra personnel are needed to relive and maintain ship operations. The Operations Officers are thus assistants to the Chief, fulfilling his/her duties when required, and assuming the Operations consoles if required at any time.\r\n\r\nThe Assistant Chief Operations Officer is the second-in-command of the Operations Department, and can assume the role of Chief Operations Officer on a temporary or permanent basis if so needed.",
		'dept_id' => 5,
		'order' => 1,
		'open' => 1,
		'type' => 'officer'),
	array(
		'name' => 'Operations Officer',
		'desc' => "The Chief Operations Officer cannot man the bridge at all times. Extra personnel are needed to relive and maintain ship operations. The Operations Officers are thus assistants to the Chief, fulfilling his/her duties when required, and assuming the Operations consoles if required at any time.\r\n\r\nThe Operations Officer reports to the Chief Operations Officer.",
		'dept_id' => 5,
		'order' => 5,
		'open' => 3,
		'type' => 'officer'),
	array(
		'name' => 'Quartermaster',
		'desc' => "The Quartermaster specializes in distributing supplies and provisions to personnel aboard the vessel. In addition, the Quartermaster controls all physical assignments to quarters throughout the vessel.",
		'dept_id' => 5,
		'order' => 6,
		'open' => 1,
		'type' => 'enlisted'),
	array(
		'name' => 'Boatswain',
		'desc' => "Each vessel and base has one Warrant Officer (or Chief Warrant Officer) who holds the position of Boatswain. The Boatswain (pronounced and also written \"Bosun\" or \"Bos'n\") trains and supervises personnel (including both the ship's company or base personnel as well as passengers or vessels) in general ship and base operations, repairs, and protocols; maintains duty assignments for all Operations personnel; sets the agenda for instruction in general ship and base operations; supervises auxiliary and utility service personnel and daily ship or base maintenance; coordinates all personnel cross-trained in damage control operations and supervises damage control and emergency operations; may assume any Bridge or Operations role as required; and is qualified to temporarily act at Operations if so ordered.\r\n\r\nThe Boatswain reports to the Chief Operations Officer.",
		'dept_id' => 5,
		'order' => 10,
		'open' => 1,
		'type' => 'enlisted'),
	array(
		'name' => 'Transporter Specialist',
		'desc' => "The Transporter Chief is responsible for all transports to and from other ships and any planetary bodies. When transporting is not going on, the Transporter Chief is responsible for keeping the transporters running at peak efficiency.\r\n\r\nThe team assigned to the Transporter Chief is made up from NCO personnel, assigned by the Assistant and Chief Engineer. The Transporter Chief reports to the Assistant and Chief Engineer.",
		'dept_id' => 5,
		'order' => 11,
		'open' => 3,
		'type' => 'enlisted'),
		
	array(
		'name' => 'Chief Engineering Officer',
		'desc' => "The Chief Engineer is responsible for the condition of all systems and equipment on board a Starfleet ship or facility. S/he oversees maintenance, repairs and upgrades of all equipment. S/he is also responsible for the many repair teams during crisis situations.\r\n\r\nThe Chief Engineer is not only the department head but also a senior officer, responsible for all the crew members in her/his department and maintenance of the duty rosters.",
		'dept_id' => 6,
		'order' => 0,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => 'Assistant Chief Engineering Officer',
		'desc' => "The Assistant Chief Engineer assists the Chief Engineer in the daily work; in issues regarding mechanical, administrative matters and coordinating repairs with other departments.\r\n\r\nIf so required, the Assistant Chief Engineer must be able to take over as Chief Engineer, and thus must be versed in current information regarding the ship or facility.",
		'dept_id' => 6,
		'order' => 1,
		'open' => 1,
		'type' => 'officer'),
	array(
		'name' => 'Engineering Officer',
		'desc' => "Engineers are the backbone of the Engineering Corps and are responsible for, under the guidance of the Chief Engineer, maintaining and repairing the vessel.",
		'dept_id' => 6,
		'order' => 2,
		'open' => 5,
		'type' => 'officer'),
	array(
		'name' => 'Communications Specialist',
		'desc' => "The Communications Specialist is a specialized engineer. Communication aboard a ship or facility takes two basic forms, voice and data. Both are handled by the onboard computer system and dedicated hardware. The vastness and complexity of this system requires a dedicated team to maintain the system.\r\n\r\nThe Communications Specialist is the officer in charge of this team, which is made up from NCO personnel, assigned to the team by the Assistant and Chief Engineer. The Communications Specialist reports to the Asst. and Chief Engineer.",
		'dept_id' => 6,
		'order' => 5,
		'open' => 1,
		'type' => 'enlisted'),
	array(
		'name' => 'Computer Systems Specialist',
		'desc' => "The Computer Systems Specialist is a specialized Engineer. The new generation of Computer systems are highly developed. This system needs much maintenance and the Computer Systems Specialist was introduced to relieve the Science Officer, whose duty this was in the very early days.\r\n\r\nA small team is assigned to the Computer Systems Specialist, which is made up from NCO personnel assigned by the Assistant and Chief Engineer. The Computer Systems Specialist reports to the Assistant and Chief Engineer.",
		'dept_id' => 6,
		'order' => 6,
		'open' => 1,
		'type' => 'enlisted'),
	array(
		'name' => 'Damage Control Specialist',
		'desc' => "The Damage Control Specialist is a specialized Engineer. The Damage Control Specialist controls all damage control aboard the ship when it gets damaged in battle. S/he oversees all damage repair aboard the ship, and coordinates repair teams on the smaller jobs so the Chief Engineer can worry about other matters.\r\n\r\nA small team is assigned to the Damage Control Specialist which is made up from NCO personnel assigned by the Assistant and Chief Engineer. The Damage Control Specialist reports to the Assistant and Chief Engineer.",
		'dept_id' => 6,
		'order' => 7,
		'open' => 1,
		'type' => 'enlisted'),
	array(
		'name' => 'Matter/Energy Systems Specialist',
		'desc' => "The Matter / Energy Systems Specialist is a specialized Engineer. All aspect of matter energy transfers with the sole exception of the warp drive systems are handled by the Matter/Energy Systems Specialist. Such areas involved are transporter and replicator systems. The Matter/Energy Systems Specialist is the Officer in charge of a small team, which is made up from NCO personnel, assigned by the Assistant and Chief Engineer. The Matter/Energy Systems Specialist reports to the Assistant and Chief Engineer.",
		'dept_id' => 6,
		'order' => 8,
		'open' => 1,
		'type' => 'enlisted'),
	array(
		'name' => 'Propulsion Specialist',
		'desc' => "Specializing in impulse and warp propulsion, these specialists are often specific to even a single class of ship due to the complexity of warp and impulse systems.",
		'dept_id' => 6,
		'order' => 9,
		'open' => 1,
		'type' => 'enlisted'),
	array(
		'name' => 'Structural/Environmental Specialist',
		'desc' => "The Structural and Environmental Systems Specialist is a specialized Engineer. From a small ship/facility to a large one, all requires constant monitoring. The hull, bulkheads, walls, Jeffrey's tubes, turbolifts, structural integrity field, internal dampening field, and environmental systems are all monitored and maintained by this officer and his/her team.\r\n\r\nThe team assigned to the Structural and Environmental Systems Specialist is made up from NCO personnel, assigned by the Assistant and Chief Engineer. The Structural and Environmental Systems Specialist reports to the Asst and Chief Engineer.",
		'dept_id' => 6,
		'order' => 10,
		'open' => 1,
		'type' => 'enlisted'),
		
	array(
		'name' => 'Chief Science Officer',
		'desc' => "The Chief Science Officer is responsible for all the scientific data the ship/facility collects, and the distribution of such data to specific section within the department for analysis. S/he is also responsible with providing the ship's captain with scientific information needed for command decisions.\r\n\r\nS/he also is a department head and a member of the Senior Staff and responsible for all the crew members in her/his department and duty rosters.",
		'dept_id' => 7,
		'order' => 0,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => 'Assistant Chief Science Officer',
		'desc' => "The Assistant Chief Science Officer assists Chief Science Officer in all areas, such as administration, and analysis of scientific data. The Assistant often take part in specific analysis of important data along with the Chief Science Officer, however spends most time overseeing current project and their section heads.",
		'dept_id' => 7,
		'order' => 1,
		'open' => 1,
		'type' => 'officer'),
	array(
		'name' => 'Science Officer',
		'desc' => "There are several general Science Officers aboard each vessel. They are assigned to their duties by the Chief Science Officer and his Assistant. Assignments include work for the Specialized Section heads, as well as duties for work being carried out by the Chief and Assistant.",
		'dept_id' => 7,
		'order' => 2,
		'open' => 3,
		'type' => 'officer'),
	array(
		'name' => 'Astrometrics Officer',
		'desc' => "Specialized Science Officer in charge of the Astrometrics Section. This role entails the maintaining, correction and production of new stellar maps. Has close ties with the the Physicist and Stellar Cartographers.",
		'dept_id' => 7,
		'order' => 3,
		'open' => 2,
		'type' => 'officer'),
	array(
		'name' => 'Alien Archaeologist/Anthropologist',
		'desc' => "Specialized Science Officer in charge of the Alien Culture Section. This role involves the study of all newly discovered alien species and life forms, from the long dead to thriving. Their knowledge also involves current known alien species. Has close ties to the Historian.\r\n\r\nAnswers to the Chief Science Officer and Assistant Chief Science Officer.",
		'dept_id' => 7,
		'order' => 5,
		'open' => 1,
		'type' => 'officer'),
	array(
		'name' => 'Biologist',
		'desc' => "Specialized Science Officer in charge of the Biology Section. This role entails the study of biology, botany, zoology and many more Life Sciences. On larger ships there many be a number of Science Officers within this section, under the lead of the Biologist.",
		'dept_id' => 7,
		'order' => 6,
		'open' => 1,
		'type' => 'officer'),
	array(
		'name' => 'Language Specialist',
		'desc' => "Specialized Communications Officer in charge of the Linguistics section. This role involves the study of new and old languages and text in an attempt to better understand and interpret their meaning.\r\n\r\nAnswers to the Chief and Assistant Chief Communications Officer (if present) or the Chief and Assistant Chief Science Officer.",
		'dept_id' => 7,
		'order' => 7,
		'open' => 1,
		'type' => 'officer'),
	array(
		'name' => 'Stellar Cartographer',
		'desc' => "Specialized Science Officer in charge of the Stellar Cartography bay. This role entails the mapping of all spatial phenomenon, and the implications of such phenomenon. Has close ties with the Physicist and Astrometrics Officer.",
		'dept_id' => 7,
		'order' => 8,
		'open' => 1,
		'type' => 'officer'),
		
	array(
		'name' => 'Chief Medical Officer',
		'desc' => "The Chief Medical Officer is responsible for the physical health of the entire crew, but does more than patch up injured crew members. His/her function is to ensure that they do not get sick or injured to begin with, and to this end monitors their health and conditioning with regular check ups. If necessary, the Chief Medical Officer can remove anyone from duty, even a Commanding Officer. Besides this s/he is available to provide medical advice to any individual who requests it.\r\n\r\nAdditionally the Chief is also responsible for all aspect of the medical deck, such as the Medical labs, Surgical suites and Dentistry labs.\r\n\r\nS/he also is a department head and a member of the Senior Staff and responsible for all the crew members in her/his department and duty rosters.",
		'dept_id' => 8,
		'order' => 0,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => 'Chief Counselor',
		'desc' => "Because of their training in psychology, technically the ship's/facility's Counselor is considered part of Starfleet medical. The Counselor is responsible both for advising the Commanding Officer in dealing with other people and races, and in helping crew members with personal, psychological, and emotional problems.\r\n\r\nThe Chief Counselor is considered a member of the Senior Staff. S/he is responsible for the crew in his/her department. The Chief Counselor is the Counselor with the highest rank and most experience.",
		'dept_id' => 8,
		'order' => 1,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => 'Assistant Chief Medical Officer',
		'desc' => "A starship or facility has numerous personnel aboard, and thus the Chief Medical Officer cannot be expect to do all the work required. The Asst. Chief Medical Officer assists Chief in all areas, such as administration, and application of medical care.",
		'dept_id' => 8,
		'order' => 2,
		'open' => 1,
		'type' => 'officer'),
	array(
		'name' => 'Medical Officer',
		'desc' => "Medical Officer undertake the majority of the work aboard the ship/facility, examining the crew, and administering medical care under the instruction of the Chief Medical Officer and Assistant Chief Medical Officer also run the other Medical areas not directly overseen by the Chief Medical Officer.",
		'dept_id' => 8,
		'order' => 3,
		'open' => 3,
		'type' => 'officer'),
	array(
		'name' => 'Surgeon',
		'desc' => "Doctors of the federation still specialize and mostly, the Chief Medical Officer position is usually held by a general practitioner. While simple surgery is part of their training, some doctors on larger vessels and starbases prefer to have a surgeon on staff.",
		'dept_id' => 8,
		'order' => 4,
		'open' => 3,
		'type' => 'officer'),
	array(
		'name' => 'Counselor',
		'desc' => "Because of their training in psychology, technically the ship's/facility's Counselor is considered part of Starfleet medical. The Counselor is responsible both for advising the Commanding Officer in dealing with other people and races, and in helping crew members with personal, psychological, and emotional problems.",
		'dept_id' => 8,
		'order' => 5,
		'open' => 2,
		'type' => 'officer'),
	array(
		'name' => "Counselor's Aide",
		'desc' => "The Counselor's Aide helps keep all the matters of the Counseling Department in order. S/he assigns appointments for anyone needing them, and assists the Counselors with anything that they may need.",
		'dept_id' => 8,
		'order' => 6,
		'open' => 2,
		'type' => 'officer'),
	array(
		'name' => 'Head Nurse',
		'desc' => "The Head Nurse oversees all the Nurses currently aboard, ensuring they are assigned to tasks and working as required in their area. Additionally the Head nurse performs the normal duties of the nurse, assisting the Duty Medical Officer in sickbay.",
		'dept_id' => 8,
		'order' => 7,
		'open' => 3,
		'type' => 'enlisted'),
	array(
		'name' => 'Nurse',
		'desc' => "Nurses are trained in basic medical care, and are capable of dealing with less serious medical cases. In more serious matters the nurse assists the medical officer in the examination and administration of medical care, be this injecting required drugs, or simply assuring the injured party that they will be ok. The Nurses also maintain the medical wards, overseeing the patients and ensuring they are receiving medication and care as instructed by the Medical Officer.",
		'dept_id' => 8,
		'order' => 8,
		'open' => 3,
		'type' => 'enlisted'),
	array(
		'name' => 'Morale Officer',
		'desc' => "Responsible for keeping the morale of the crew high. Delivers regular reports on morale to the Executive Officer. The Morale Officer plans activities that will keep the crew's morale and demeanor up. If any crew member is having problems, the Morale Officer can assist that crew member.",
		'dept_id' => 8,
		'order' => 9,
		'open' => 1,
		'type' => 'enlisted'),
	
	array(
		'name' => 'Chief Intelligence Officer',
		'desc' => "Responsible for managing the intelligence department in its various facets, the Chief Intelligence officer often assists the Strategic Operations officer with information gathering and analysis, and then acts as a channel of information to the CO and bridge crew during combat situations.",
		'dept_id' => 9,
		'order' => 0,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => 'Assistant Chief Intelligence Officer',
		'desc' => "Responsible for aiding the Chief Intelligence Officer in managing the intelligence department in its various facets, often assisting the Strategic Operations officer with information gathering and analysis.",
		'dept_id' => 9,
		'order' => 1,
		'open' => 1,
		'type' => 'officer'),
	array(
		'name' => 'Intelligence Officer',
		'desc' => "Responsible for gathering intelligence, an Intelligence officer has the patience to read through a database for hours on end, and the cunning to coax information from an unwilling giver. S/he must provide this information to the Chief Intelligence officer as it becomes needed.",
		'dept_id' => 9,
		'order' => 2,
		'open' => 2,
		'type' => 'officer'),
	array(
		'name' => 'Infiltration Specialist',
		'desc' => "The Infiltration Specialist is trained the arts of covert operations and infiltration. They are trained to get into and out of enemy instillations, territory, etc. Once in, they can gather intel, or if needed plant explosives, and even in times of war capture of enemy personnel. The Infiltration Specialist reports to the Chief Intelligence Officer.",
		'dept_id' => 9,
		'order' => 3,
		'open' => 1,
		'type' => 'officer'),
	array(
		'name' => 'Encryption Specialist',
		'desc' => "This NCO takes submitted Intelligence reports and runs them through algorithms, checking for keywords that denote mistyped classification and then puts the report into crypto form and sends them through the proper channels of communication to either on board ship consoles or off board to who ever needs to receive it. The Encryption Specialist reports to the Chief Intelligence Officer.",
		'dept_id' => 9,
		'order' => 4,
		'open' => 1,
		'type' => 'enlisted'),
	
	array(
		'name' => 'Chief Diplomatic Officer',
		'desc' => "The Diplomatic Officer of each vessel/base must be familiar with a variety of areas: history, religion, politics, economics, and military, and understand how they affect potential threats. A wide range of operations can occur in response to these areas and threats. These operations occur within three general states of being: peacetime competition, conflict and war.\r\n\r\nS/he must be equally flexible and demonstrate initiative, agility, depth, synchronization, and improvisation to provide responsive legal services to his/her Commanding Officer as well a diplomatic advise on current status of an Alien Species both aligned and non aligned to the Federation.\r\n\r\nThe Chief Diplomatic Officer is in charge of the Diplomatic Corps Detachment. He or she oversees the operation of it, as well as makes sure everything in that department is carried out according to Starfleet Regulations.",
		'dept_id' => 10,
		'order' => 0,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => 'Assistant Chief Diplomatic Officer',
		'desc' => "The Diplomatic Officer of each vessel/base must be familiar with a variety of areas: history, religion, politics, economics, and military, and understand how they affect potential threats. A wide range of operations can occur in response to these areas and threats. These operations occur within three general states of being: peacetime competition, conflict and war.\r\n\r\nS/he must be equally flexible and demonstrate initiative, agility, depth, synchronization, and improvisation to provide responsive legal services to his/her Commanding Officer aiding in official functions as prescribed by protocol, performing administrative duties, and other tasks as directed by the Chief Diplomatic Officer, as well a diplomatic advise on current status of an Alien Species both aligned and non aligned to the Federation.\r\n\r\nThe Assistant Chief Diplomatic Officer is the second-in-command of the Diplomatic Corps Detachment. If necessary, he or she can take the place of the Chief Diplomatic Officer on a temporary or permanent basis.",
		'dept_id' => 10,
		'order' => 1,
		'open' => 1,
		'type' => 'officer'),
	array(
		'name' => 'Diplomatic Officer',
		'desc' => "The Diplomatic Officer of each vessel/base must be familiar with a variety of areas: history, religion, politics, economics, and military, and understand how they affect potential threats. A wide range of operations can occur in response to these areas and threats. These operations occur within three general states of being: peacetime competition, conflict and war.\r\n\r\nS/he must be equally flexible and demonstrate initiative, agility, depth, synchronization, and improvisation to provide responsive legal services to his/her Commanding Officer aiding in official functions as prescribed by protocol, performing administrative duties, and other tasks as directed by the Chief Diplomatic Officer and/or Assistant Chief Diplomatic Officer as well a diplomatic advice on current status of an Alien Species both aligned and non aligned to the Federation.",
		'dept_id' => 10,
		'order' => 2,
		'open' => 2,
		'type' => 'officer'),
	array(
		'name' => 'Diplomatic Corpsman',
		'desc' => "The Diplomatic Corpsman is a special position reserved for enlisted officers who wish to study diplomacy, and aid the department in its mission. Their duties consist of, but are not limited to, aiding Diplomatic Officers and Diplomat's Aide in the construction of various legal documents, researching diplomatic archives, attending and aiding in the preparation for diplomatic functions, and other tasks as prescribed by the Chief Diplomatic Officer and/or Assistant Chief Diplomatic Officer. These individuals are qualified to undertake some of the responsibilities of a Diplomatic Officer, as their training are far less in-depth. They are, however, able to, and adequately trained to function as a paralegal when such services are required by a vessel/base's crew.",
		'dept_id' => 10,
		'order' => 3,
		'open' => 2,
		'type' => 'enlisted'),
	array(
		'name' => "Diplomat's Aide",
		'desc' => "S/he responds to the Ship/Base's Chief Diplomatic Officer, and is required to be able to stand in and run the Diplomatic Department as required should the Chief Diplomatic Officer be absent for any reason.\r\n\r\nThe Aide must therefore be versed in all Diplomatic information regarding the current status of the Federation and its aligned and non aligned neighbours.",
		'dept_id' => 10,
		'order' => 4,
		'open' => 1,
		'type' => 'enlisted'),
	array(
		'name' => 'Media Relations Officer',
		'desc' => "Like it or not, the public has a right to know what Starfleet is up to. To get the word out to journalists or in the case of classified missions, to keep word from getting out. The Chief Diplomatic Officer will usually appoint one of their Diplomatic Officers to serve as the Media Relations Officer.\r\n\r\nWith the exceptions of large stations and/or high profile diplomatic negotiations the Media Relations Officer duties consist of, but are not limited to keeping the Chief Diplomatic Officer and Assistant Chief Diplomatic Officer informed of all relevant media stories, dealing with the press on a daily basis, creating and issuing mission statments, conducting personal interviews, and answer questions from the media journalists.",
		'dept_id' => 10,
		'order' => 5,
		'open' => 1,
		'type' => 'enlisted'),
	array(
		'name' => 'Translation Specialist',
		'desc' => "The Translation Specialist is a person capable of translating written and spoken languages in real-time. They often have roles of interpreters and mediators due to their extensive linguistic capabilities. Translation Specialist reports to the Language Specialist.\r\n\r\nAlthough s/he is considered a Communications Officer the position also has close ties to the diplomacy. Under diplomacy the Translation Specialist is charged with the translation of any language, living or dead, that may be encountered by a vessel/base that the Universal Translator system can not interpret. These individuals are adept at using various decryption techniques to aid in the deciphering of such languages. These individuals are qualified to undertake any tasks that could be asked of a general Diplomatic Officer; however they specialize in the linguistic aspect of this department.",
		'dept_id' => 10,
		'order' => 6,
		'open' => 1,
		'type' => 'enlisted'),
		
	array(
		'name' => 'Marine Commanding Officer',
		'desc' => "The Marine CO is responsible for all the Marine personnel assigned to the ship/facility. S/he is in required to take command of any special ground operations and lease such actions with security. The Marines could be called the 24th century commandos.\r\n\r\nThe CO can range from a Second Lieutenant on a small ship to a Lieutenant Colonel on a large facility or colony. Charged with the training, condition and tactical leadership of the Marine compliment, they are a member of the senior staff.\r\n\r\nAnswers to the Commanding Officer of the ship/facility.",
		'dept_id' => 11,
		'order' => 0,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => 'Marine Executive Officer',
		'desc' => "The Executive Officer of the Marines, works like any Asst. Department head, removing some of the work load from the Marine CO and if the need arises taking on the role of Marine CO. S/he oversees the regular duties of the Marines, from regular drills to equipment training, assignment and supply request to the ship/facilities Materials Officer.\r\n\r\nAnswers to the Marine Commanding Officer.",
		'dept_id' => 11,
		'order' => 1,
		'open' => 1,
		'type' => 'officer'),
	array(
		'name' => 'First Sergeant',
		'desc' => "The First Sergeant is the highest ranked Enlisted marine. S/He is in charge of all of the marine enlisted affairs in the detachment. They assist the Company or Detachment Commander as their Executive Officer would. They act as a bridge, closing the gap between the NCO\'s and the Officers.\r\n\r\nAnswers To Marine Commanding Officer.",
		'dept_id' => 11,
		'order' => 2,
		'open' => 1,
		'type' => 'enlisted'),
	array(
		'name' => 'Marine',
		'desc' => "Serving within a squad, the marine is trained in a variety of means of combat, from melee to ranged projectile to sniping.",
		'dept_id' => 11,
		'order' => 3,
		'open' => 5,
		'type' => 'enlisted'),
		
	array(
		'name' => 'Group Commander',
		'desc' => "The Group Commander is in charge of all things related to his group's fighters, generally a responsibility of over 96 starfighters. As well, the group commander is responsible for all the personnel assigned to the group on the ship/facility, and ensuring that maintenance work is carried on the craft by Engineering.\r\n\r\nThe Group Commander reports to the Commanding Officer or Executive Officer and is a member of the Senior Staff.",
		'dept_id' => 12,
		'order' => 0,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => 'Wing Commander',
		'desc' => "The Wing Commander is in charge of all things related to his wing's fighters, generally a responsibility of between 48 and 72 starfighters. As well, the wing commander is responsible for all the personnel assigned to the flight on the ship/facility, and ensuring that maintenance work is carried on the craft by Engineering.\r\n\r\nReports to the Group Commander. If the Wing Commander is the senior starfighter pilot assigned to the starship, starbase or facility they report to the Commanding Officer or Executive Officer and is a member of the Senior Staff.",
		'dept_id' => 12,
		'order' => 1,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => 'Squadron Leader',
		'desc' => "The Squadron Leader is in charge of all things related to his squadron's fighters, generally a responsibility of up to 24 starfighters. As well, the squadron leader is responsible for all the personnel assigned to the squadron on the ship/facility, and ensuring that maintenance work is carried on the craft by Engineering.\r\n\r\nReports to the Wing Commander. If the Squadron Leader is the senior starfighter pilot assigned to the starship, starbase or facility they report to the Commanding Officer or Executive Officer and is a member of the Senior Staff.",
		'dept_id' => 12,
		'order' => 2,
		'open' => 2,
		'type' => 'officer'),
	array(
		'name' => 'Flight Leader',
		'desc' => "The Flight Leader is in charge of all things related to his flight's fighters, generally a responsibility of up to 8 starfighters. As well, the flight leader is responsible for all the personnel assigned to the flight on the ship/facility, and ensuring that maintenance work is carried on the craft by Engineering.\r\n\r\nReports to the Squadron Leader. If the Flight Leader is the senior starfighter pilot assigned to the starship, starbase or facility they report to the Commanding Officer or Executive Officer and is a member of the Senior Staff.",
		'dept_id' => 12,
		'order' => 3,
		'open' => 2,
		'type' => 'officer'),
	array(
		'name' => 'Fighter Pilot',
		'desc' => "Specialized pilot, trained in all areas and aspects of fighter combat. They are also familiar with runabouts, shuttles and transports.\r\n\r\nTo be a fighter pilot the pilot must hold a rank from within the Warrant Officer Ranks or commissioned ranks.\r\n\r\nReports to the Flight Leader.",
		'dept_id' => 12,
		'order' => 4,
		'open' => 4,
		'type' => 'officer'),
	array(
		'name' => 'Tactical Systems Operator',
		'desc' => "The Tactical Systems Operator (or TSO) is responsible for operating all offensive and defensive systems in fighters which have two operators. This frees the pilot to handle only the operation of the aerospacecraft. Most TSOs are also trained as pilots, for circumstances when the main pilot of the fighter is incapacitated or killed but the craft is still servicable. The TSO answers to the Flight Leader, and is generally subordinate to the Fighter Pilot operating his/her craft.\r\n\r\nBecause of the location of the TSO's seat in most fighters, the position is sometimes known as the 'back seater'.",
		'dept_id' => 12,
		'order' => 5,
		'open' => 4,
		'type' => 'officer'),
		
	array(
		'name' => 'Chef',
		'desc' => "Responsible for preparing all meals served in the Mess Hall and for the food during any diplomatic functions that may be held onboard.",
		'dept_id' => 13,
		'order' => 0,
		'open' => 1,
		'type' => 'enlisted')
);

$catalog_ranks = array(
	array(
		'name' => 'DS9 Duty Uniform',
		'location' => 'default',
		'credits' => "The Deep Space Nine duty uniform rank set used in Nova were created by Kuro-chan of <a href='http://www.kuro-rpg.net' target='_blank''>Kuro-RPG</a>. Please do not modify the images in any way.",
		'default' => (int) true,
		'genre' => $g),
);
