<?php
/**
 * Genre Install Data (ST:23)
 *
 * @package		Install
 * @category	Assets
 * @author		Anodyne Productions
 */

$g = 'st23';

$data = array(
	'departments_'.$g 	=> 'depts',
	'ranks_info_'.$g	=> 'info',
	'ranks_groups_'.$g	=> 'groups',
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
		'name' => 'Operations',
		'desc' => "Responsible for the navigation and flight control of a vessel and its auxiliary craft, the Operations division includes pilots trained in both starship and auxiliary craft piloting as well as navigators and other personnel to help in running the various ancillary operations of the ship.",
		'order' => 1),
	array(
		'name' => 'Communications',
		'desc' => "The Communications department is responsible for the operation of the Starfleet's communications systems. On many ships the Communications department is simply amalgamated with Operations; it is often only on Flagships (where a large amount of communications traffic can be received in a very short space of time) and Starbases (where there is an extremely large amount of communications traffic at almost all times).",
		'order' => 2),
	array(
		'name' => 'Security',
		'desc' => "Merging the responsibilities of ship to ship and personnel combat into a single department, the armory division is responsible for the tactical readiness of the vessel and the security of the ship.",
		'order' => 3),
	array(
		'name' => 'Engineering',
		'desc' => "The engineering division has the enormous task of keeping the ship working; they are responsible for making repairs, fixing problems, and making sure that the ship is ready for anything.",
		'order' => 4),
	array(
		'name' => 'Science',
		'desc' => "From sensor readings to figuring out a way to enter the strange spacial anomaly, the science division is responsible for recording data, testing new ideas out, and making discoveries.",
		'order' => 5),
	array(
		'name' => 'Medical',
		'desc' => "The medical division is responsible for the mental and physical health of the crew, from running annual physicals to combatting a strange plague that is afflicting the crew to helping a crew member deal with the loss of a loved one.",
		'order' => 6)
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
		'name' => 'First Officer',
		'desc' => "The liaison between captain and crew, the First Officer acts as the disciplinarian, personnel manager, advisor to the captain, and much more. S/he is also one of only two officers, along with the Chief Medical Officer, that can remove a Commanding Officer from duty.",
		'dept_id' => 1,
		'order' => 1,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => 'Chief of the Boat',
		'desc' => "The senior-most Chief Petty Officer (including Senior and Master Chiefs), regardless of rating, is designated by the Commanding Officer as the Chief of the Boat (for vessels) or Command Chief (for starbases). In addition to his or her departmental responsibilities, the COB/CC performs the following duties: serves as a liaison between the Commanding Officer (or Executive Officer) and the enlisted crewmen; ensures enlisted crews understand Command policies; advises the Commanding Officer and Executive Officer regarding enlisted morale, and evaluates the quality of noncommissioned officer leadership, management, and supervisory training.\r\n\r\nThe COB/CC works with the other department heads, Chiefs, supervisors, and crewmen to insure discipline is equitably maintained, and the welfare, morale, and health needs of the enlisted personnel are met. The COB/CC is qualified to temporarily act as Commanding or Executive Officer if so ordered.",
		'dept_id' => 1,
		'order' => 2,
		'open' => 1,
		'type' => 'enlisted'),
	array(
		'name' => 'Yeoman',
		'desc' => "The Captain's Yeoman is for Petty Officers who wish to continue as administrators. It is technically a non-Mate position. Use of this position is completely at the discretion of the Commanding Officer. File work, and sensitive message transport are but two examples of the Yeoman's possible duties. The Yeoman assists the CO in day-to-day duties that the CO would otherwise not have the time to do.",
		'dept_id' => 1,
		'order' => 3,
		'open' => 1,
		'type' => 'enlisted'),
	array(
		'name' => 'Chief Helmsman',
		'desc' => "A Helm Officer must always be present on the bridge of a starship. S/he plots courses, supervises the computers piloting, corrects any flight deviations and pilots the ship manually when needed. The Chief Helmsman is the senior most Helm Officer aboard, serving as a Senior Officer, and chief of the personnel under him/her.",
		'dept_id' => 2,
		'order' => 0,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => 'Chief Navigator',
		'desc' => "The Chief Navigator is the seniormost navigator on the ship and is responsible for all navigators aboard the vessel. Responsibilities of the navigators is include projecting the course of a starship and determining a ship's position, velocity and direction in relationship to a course. The navigator can also use the ship's navigational sensors to determine the positions, speeds and trajectories of other objects. Additionally, the navigator is in charge of coordinating phaser crews for real and simulated combat and for firing the weapons.",
		'dept_id' => 2,
		'order' => 1,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => 'Helmsman',
		'desc' => "A Helm Officer must always be present on the bridge of a starship, and every vessel has a number of Helm Officers to allow shift rotations. S/he plots courses, supervises the computers piloting, corrects any flight deviations and pilots the ship manually when needed. Helm Officers report to the Chief Helmsman.",
		'dept_id' => 2,
		'order' => 2,
		'open' => 4,
		'type' => 'officer'),
	array(
		'name' => 'Navigator',
		'desc' => "A Navigator must always be present on the bridge of a starship, and every vessel has a number of Navigators to allow shift rotations. S/he handles all matters of navigating the ship while the helmsmen pilot the ship. Navigators report to the Chief Navigator.",
		'dept_id' => 2,
		'order' => 3,
		'open' => 4,
		'type' => 'officer'),
	array(
		'name' => 'Shuttle Pilot',
		'desc' => "All small spacecrafts aboard a starship, starbase or a facility are flown by Shuttle Pilots. This is often the proving ground for pilots until they earn a berth on a starship as a Helmsman or Navigator. They report to the Chief Helmsman.",
		'dept_id' => 2,
		'order' => 4,
		'open' => 2,
		'type' => 'enlisted'),
	array(
		'name' => 'Chief Communications Officer',
		'desc' => "Responsible for maintaining and upgrading the universal translator, controls the intercom and responsible for coordinating communications with other ships, stations or colonies/planets.",
		'dept_id' => 3,
		'order' => 0,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => 'Communications Officer',
		'desc' => "The Communications officer is responsible for managing all incoming and outgoing transmissions. This role involves the study of new and old languages and text in an attempt to better understand and interpret their meaning.",
		'dept_id' => 3,
		'order' => 1,
		'open' => 4,
		'type' => 'officer'),
	array(
		'name' => 'Chief Security Officer',
		'desc' => "Her/his duty is to ensure the safety of ship and crew. Some take it as their personal duty to protect the Commanding Officer/First Officer on away teams. She/he is also responsible for people under arrest and the safety of guests, liked or not. S/he also is a department head and a member of the senior staff, responsible for all the crew members in her/his department and duty rosters.",
		'dept_id' => 4,
		'order' => 0,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => 'Security Officer',
		'desc' => "There are several Security Officers aboard each vessel. They are assigned to their duties by the Chief of Security and mostly guard sensitive areas, protect people, patrol, and handle other threats to the Federation.",
		'dept_id' => 4,
		'order' => 1,
		'open' => 5,
		'type' => 'officer'),
	array(
		'name' => 'Tactical Officer',
		'desc' => "There are several Tactical Officers aboard each vessel. They are assigned to their duties by the Security Chief and handle all weapons aboard the ship, including manning tactical stations during armed space combat.",
		'dept_id' => 4,
		'order' => 2,
		'open' => 3,
		'type' => 'officer'),
	array(
		'name' => 'Security Investigations Officer',
		'desc' => "The Security Investigations Officer is an Enlisted Officer. S/He fulfills the role of a special investigator or detective when dealing with Starfleet matters aboard ship or on a planet. Coordinates with the Chief Armory Officer on all investigations as needed. The Security Investigations Officer reports to the Chief Armory Officer.",
		'dept_id' => 4,
		'order' => 5,
		'open' => 2,
		'type' => 'enlisted'),
	array(
		'name' => 'Brig Officer',
		'desc' => "The Brig Officer is an Armory Officer who has chosen to specialize in a specific role. S/he guards the brig and its cells. But there are other duties associated with this post as well. S/he is responsible for any prisoner transport, and the questioning of prisoners.",
		'dept_id' => 4,
		'order' => 10,
		'open' => 5,
		'type' => 'enlisted'),
	array(
		'name' => 'Master-at-Arms',
		'desc' => "The Master-at-Arms trains and supervises Armory crewmen in departmental operations, repairs, and protocols; maintains duty assignments for all Armory personnel; supervises weapons locker access and firearm deployment; and is qualified to temporarily act as Chief Armory Officer if so ordered. The Master-at-Arms reports to the Chief Armory Officer.",
		'dept_id' => 4,
		'order' => 15,
		'open' => 1,
		'type' => 'enlisted'),
	array(
		'name' => 'Chief Engineer',
		'desc' => "The Chief Engineer is responsible for the condition of all systems and equipment on board a Starfleet ship or facility. S/he oversees maintenance, repairs and upgrades of all equipment. S/he is also responsible for the many repairs teams during crisis situations.\r\n\r\nThe Chief Engineer is not only the department head but also a senior officer, responsible for all the crew members in her/his department and maintenance of the duty rosters.",
		'dept_id' => 5,
		'order' => 0,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => 'Assistant Chief Engineer',
		'desc' => "The Assistant Chief Engineer assists the Chief Engineer in the daily work; in issues regarding mechanical, administrative matters and co-ordinating repairs with other departments.\r\n\r\nIf so required, the Assistant Chief Engineer must be able to take over as Chief Engineer, and thus must be versed in current information regarding the ship or facility.",
		'dept_id' => 5,
		'order' => 1,
		'open' => 1,
		'type' => 'officer'),
	array(
		'name' => 'Engineer',
		'desc' => "There are several non-specialized engineers aboard of each vessel. They are assigned to their duties by the Chief Engineer and his Assistant, performing a number of different tasks as required, i.e. general maintenance and repair. Generally, engineers as assigned to more specialized engineering person to assist in there work is so requested by the specialized engineer.",
		'dept_id' => 5,
		'order' => 5,
		'open' => 10,
		'type' => 'officer'),
	array(
		'name' => 'Damage Control Specialist',
		'desc' => "The Damage Control Specialist is a specialized Engineer. The Damage Control Specialist controls all damage control aboard the ship when it gets damaged in battle. S/he oversees all damage repair aboard the ship, and coordinates repair teams on the smaller jobs so the Chief Engineer can worry about other matters.\r\n\r\nA small team is assigned to the Damage Control Specialist which is made up from NCO personnel assigned by the Assistant and Chief Engineer. The Damage Control Specialist reports to the Assistant and Chief Engineer.",
		'dept_id' => 5,
		'order' => 10,
		'open' => 5,
		'type' => 'enlisted'),
	array(
		'name' => 'Chief Science Officer',
		'desc' => "The Chief Science Officer is responsible for all the scientific data the ship/facility collects, and the distribution of such data to specific section within the department for analysis. S/he is also responsible with providing the ship's captain with scientific information needed for command decisions.\r\n\r\nS/he also is a department head and a member of the Senior Staff and responsible for all the crew members in her/his department and duty rosters.",
		'dept_id' => 6,
		'order' => 0,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => 'Science Officer',
		'desc' => "There are several general Science Officers aboard each vessel. They are assigned to their duties by the Chief Science Officer and his Assistant. Assignments include work for the Specialized Section heads, as well as duties for work being carried out by the Chief.",
		'dept_id' => 6,
		'order' => 5,
		'open' => 5,
		'type' => 'officer'),
	array(
		'name' => 'Chief Medical Officer',
		'desc' => "The Chief Medical Officer is responsible for the physical health of the entire crew, but does more than patch up injured crew members. His/her function is to ensure that they do not get sick or injured to begin with, and to this end monitors their health and conditioning with regular check ups. If necessary, the Chief Medical Officer can remove anyone from duty, even a Commanding Officer. Besides this s/he is available to provide medical advice to any individual who requests it.",
		'dept_id' => 7,
		'order' => 0,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => 'Counselor',
		'desc' => "Because of their training in psychology, technically the ship's/facility's Counselor is considered part of Starfleet Medical. The Counselor is responsible both for advising the Commanding Officer in dealing with other people and races, and in helping crew members with personal, psychological, and emotional problems.\r\n\r\nThe Counselor reports to the Chief Medical Officer.",
		'dept_id' => 7,
		'order' => 2,
		'open' => 1,
		'type' => 'officer'),
	array(
		'name' => 'Medical Officer',
		'desc' => "Medical Officer undertake the majority of the work aboard the ship/facility, examining the crew, and administering medical care under the instruction of the Chief Medical Officer.",
		'dept_id' => 7,
		'order' => 5,
		'open' => 5,
		'type' => 'officer'),
	array(
		'name' => 'Nurse',
		'desc' => "Nurses are trained in basic medical care, and are capable of dealing with less serious medical cases. In more serious matters the nurse assist the medical officer in the examination and administration of medical care, be this injecting required drugs, or simply assuring the injured party that they will be ok. The Nurses also maintain the medical wards, overseeing the patients and ensuring they are receiving medication and care as instructed by the Medical Officer.",
		'dept_id' => 7,
		'order' => 10,
		'open' => 10,
		'type' => 'enlisted')
);

$catalog_ranks = array(
	array(
		'name' => 'Duty Uniform',
		'location' => 'default',
		'credits' => "The Original Series rank set used in Nova were created by Kuro-chan of <a href='http://www.kuro-rpg.net' target='_blank''>Kuro-RPG</a>. Please do not modify the images in any way.",
		'default' => 1,
		'genre' => $g)
);
