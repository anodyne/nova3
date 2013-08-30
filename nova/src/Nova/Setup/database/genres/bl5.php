<?php
/**
 * Genre Install Data (BL5)
 *
 * @package		Nova
 * @subpackage	Setup
 * @category	Asset
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */

$g = 'bl5';

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
		'desc' => "The Command department is ultimately responsible for the ship and its crew, and those within the department are responsible for commanding the vessel.",
		'order' => 0),
	array(
		'name' => 'Pilots',
		'desc' => "The best pilots anywhere, they are responsible for piloting the StarFury fighters in ship-to-ship battles, as well as providing escort.",
		'order' => 1),
	array(
		'name' => 'Security',
		'desc' => "The security department is ultimately responsible for the security of the ship and being prepared for anything to happen.",
		'order' => 2),
	array(
		'name' => 'Engineering',
		'desc' => "The engineering department has the enormous task of keeping the ship working; they are responsible for making repairs, fixing problems, and making sure that the ship is ready for anything.",
		'order' => 3),
	array(
		'name' => 'Medical',
		'desc' => "The medical department is responsible for the mental and physical health of the crew, from running annual physicals to combatting a strange plague that is afflicting the crew to helping a crew member deal with the loss of a loved one.",
		'order' => 4),
	array(
		'name' => 'Communications',
		'desc' => "The Communications department is responsible for the operation of the communications systems to ensure timely and accurate communications both within and outside the vessel.",
		'order' => 5),
	array(
		'name' => 'Marines',
		'desc' => "When the standard security detail is not enough, marines come in and clean up; the marine detachment is a powerful tactical addition to any ship, responsible for partaking in personal combat, from sniping to melee.",
		'order' => 6),
	array(
		'name' => 'Weapons Control',
		'desc' => "The Weapons Control department is responsible for controlling both small and large arms aboard the vessel, be that personal sidearms, the armaments of the StarFury fighters and even the vessel itself.",
		'order' => 7),
	array(
		'name' => 'Tactical',
		'desc' => "The Tactiacl department is responsible for the tactical readiness of the vessel and manning the weapon system during combat as well as coordinating StarFury craft as they engage in ship-to-ship combat.",
		'order' => 8)
);

$groups = array(
	array('name' => 'EarthForce Navy', 'order' => 0),
	array('name' => 'EarthForce Marines', 'order' => 1),
	array('name' => 'EarthForce Security Forces', 'order' => 2),
);

$info = array(
	array('name' => "Commander-in-Chief", 'short_name' => "CIC", 'order' => 0, 'group' => 1),
	array('name' => "General", 'short_name' => "GEN", 'order' => 1, 'group' => 1),
	array('name' => "Lieutenant General", 'short_name' => "LT GEN", 'order' => 2, 'group' => 1),
	array('name' => "Major General", 'short_name' => "MAJ GEN", 'order' => 3, 'group' => 1),
	array('name' => "Brigadier General", 'short_name' => "BRG GEN", 'order' => 4, 'group' => 1),

	array('name' => "Captain", 'short_name' => "CAPT", 'order' => 0, 'group' => 2),
	array('name' => "Commander", 'short_name' => "CMDR", 'order' => 1, 'group' => 2),
	array('name' => "Lieutenant Commander", 'short_name' => "LT CMDR", 'order' => 2, 'group' => 2),
	array('name' => "Lieutenant", 'short_name' => "LT", 'order' => 3, 'group' => 2),
	array('name' => "Lieutenant JG", 'short_name' => "LT(JG)", 'order' => 4, 'group' => 2),
	array('name' => "Ensign", 'short_name' => "ENS", 'order' => 5, 'group' => 2),

	array('name' => "Colonel", 'short_name' => "COL", 'order' => 0, 'group' => 3),
	array('name' => "Lieutenant Colonel", 'short_name' => "LT COL", 'order' => 1, 'group' => 3),
	array('name' => "Major", 'short_name' => "MAJ", 'order' => 2, 'group' => 3),
	array('name' => "Captain", 'short_name' => "CAPT", 'order' => 3, 'group' => 3),
	array('name' => "1st Lieutenant", 'short_name' => "1LT", 'order' => 4, 'group' => 3),
	array('name' => "2nd Lieutenant", 'short_name' => "2LT", 'order' => 5, 'group' => 3),

	array('name' => "Master Warrant Officer", 'short_name' => "MWO", 'order' => 0, 'group' => 4),
	array('name' => "Chief Warrant Officer 1st Class", 'short_name' => "CWO1", 'order' => 1, 'group' => 4),
	array('name' => "Chief Warrant Officer 2nd Class", 'short_name' => "CWO2", 'order' => 2, 'group' => 4),
	array('name' => "Chief Warrant Officer 3rd Class", 'short_name' => "CWO3", 'order' => 3, 'group' => 4),
	array('name' => "Warrant Officer", 'short_name' => "WO", 'order' => 4, 'group' => 4),

	array('name' => "Master Chief Petty Officer", 'short_name' => "MCPO", 'order' => 0, 'group' => 5),
	array('name' => "Senior Chief Petty Officer", 'short_name' => "SCPO", 'order' => 1, 'group' => 5),
	array('name' => "Chief Petty Officer", 'short_name' => "CPO", 'order' => 2, 'group' => 5),
	array('name' => "Petty Officer 1st Class", 'short_name' => "PO1", 'order' => 3, 'group' => 5),
	array('name' => "Petty Officer 2nd Class", 'short_name' => "PO2", 'order' => 4, 'group' => 5),
	array('name' => "Petty Officer 3rd Class", 'short_name' => "PO3", 'order' => 5, 'group' => 5),
	array('name' => "Crewman 1st Class", 'short_name' => "CR1", 'order' => 6, 'group' => 5),
	array('name' => "Crewman 2nd Class", 'short_name' => "CR2", 'order' => 7, 'group' => 5),
	array('name' => "Crewman 3rd Class", 'short_name' => "CR3", 'order' => 8, 'group' => 5),

	array('name' => "Master Gunnery Sergeant", 'short_name' => "MGSGT", 'order' => 0, 'group' => 6),
	array('name' => "Master Sergeant", 'short_name' => "MSGT", 'order' => 1, 'group' => 6),
	array('name' => "Gunnery Sergeant", 'short_name' => "GSGT", 'order' => 2, 'group' => 6),
	array('name' => "Staff Sergeant", 'short_name' => "SSGT", 'order' => 3, 'group' => 6),
	array('name' => "Sergeant", 'short_name' => "SGT", 'order' => 4, 'group' => 6),
	array('name' => "Corporal", 'short_name' => "CPL", 'order' => 5, 'group' => 6),
	array('name' => "Lance Corporal", 'short_name' => "LCPL", 'order' => 6, 'group' => 6),
	array('name' => "Private 1st Class", 'short_name' => "PVT1", 'order' => 7, 'group' => 6),
	array('name' => "Private", 'short_name' => "PVT", 'order' => 8, 'group' => 6),
);

$ranks = array(
	array('info_id' => 1, 'group_id' => 1, 'base' => 'b-a5'),
	array('info_id' => 2, 'group_id' => 1, 'base' => 'b-a4'),
	array('info_id' => 3, 'group_id' => 1, 'base' => 'b-a3'),
	array('info_id' => 4, 'group_id' => 1, 'base' => 'b-a2'),
	array('info_id' => 5, 'group_id' => 1, 'base' => 'b-a1'),
	array('info_id' => 6, 'group_id' => 1, 'base' => 'b-o6'),
	array('info_id' => 7, 'group_id' => 1, 'base' => 'b-o5'),
	array('info_id' => 8, 'group_id' => 1, 'base' => 'b-o4'),
	array('info_id' => 9, 'group_id' => 1, 'base' => 'b-o3'),
	array('info_id' => 10, 'group_id' => 1, 'base' => 'b-o2'),
	array('info_id' => 11, 'group_id' => 1, 'base' => 'b-o1'),
	array('info_id' => 18, 'group_id' => 1, 'base' => 'b-w5'),
	array('info_id' => 19, 'group_id' => 1, 'base' => 'b-w4'),
	array('info_id' => 20, 'group_id' => 1, 'base' => 'b-w3'),
	array('info_id' => 21, 'group_id' => 1, 'base' => 'b-w2'),
	array('info_id' => 22, 'group_id' => 1, 'base' => 'b-w1'),
	array('info_id' => 23, 'group_id' => 1, 'base' => 'b-e9'),
	array('info_id' => 24, 'group_id' => 1, 'base' => 'b-e8'),
	array('info_id' => 25, 'group_id' => 1, 'base' => 'b-e7'),
	array('info_id' => 26, 'group_id' => 1, 'base' => 'b-e6'),
	array('info_id' => 27, 'group_id' => 1, 'base' => 'b-e5'),
	array('info_id' => 28, 'group_id' => 1, 'base' => 'b-e4'),
	array('info_id' => 29, 'group_id' => 1, 'base' => 'b-e3'),
	array('info_id' => 30, 'group_id' => 1, 'base' => 'b-e2'),
	array('info_id' => 31, 'group_id' => 1, 'base' => 'b-e1'),

	array('info_id' => 1, 'group_id' => 2, 'base' => 'd-a5'),
	array('info_id' => 2, 'group_id' => 2, 'base' => 'd-a4'),
	array('info_id' => 3, 'group_id' => 2, 'base' => 'd-a3'),
	array('info_id' => 4, 'group_id' => 2, 'base' => 'd-a2'),
	array('info_id' => 5, 'group_id' => 2, 'base' => 'd-a1'),
	array('info_id' => 12, 'group_id' => 2, 'base' => 'd-o6'),
	array('info_id' => 13, 'group_id' => 2, 'base' => 'd-o5'),
	array('info_id' => 14, 'group_id' => 2, 'base' => 'd-o4'),
	array('info_id' => 15, 'group_id' => 2, 'base' => 'd-o3'),
	array('info_id' => 16, 'group_id' => 2, 'base' => 'd-o2'),
	array('info_id' => 17, 'group_id' => 2, 'base' => 'd-o1'),
	array('info_id' => 18, 'group_id' => 2, 'base' => 'd-w5'),
	array('info_id' => 19, 'group_id' => 2, 'base' => 'd-w4'),
	array('info_id' => 20, 'group_id' => 2, 'base' => 'd-w3'),
	array('info_id' => 21, 'group_id' => 2, 'base' => 'd-w2'),
	array('info_id' => 22, 'group_id' => 2, 'base' => 'd-w1'),
	array('info_id' => 32, 'group_id' => 2, 'base' => 'd-e9'),
	array('info_id' => 33, 'group_id' => 2, 'base' => 'd-e8'),
	array('info_id' => 34, 'group_id' => 2, 'base' => 'd-e7'),
	array('info_id' => 35, 'group_id' => 2, 'base' => 'd-e6'),
	array('info_id' => 36, 'group_id' => 2, 'base' => 'd-e5'),
	array('info_id' => 37, 'group_id' => 2, 'base' => 'd-e4'),
	array('info_id' => 38, 'group_id' => 2, 'base' => 'd-e3'),
	array('info_id' => 39, 'group_id' => 2, 'base' => 'd-e2'),
	array('info_id' => 40, 'group_id' => 2, 'base' => 'd-e1'),

	array('info_id' => 1, 'group_id' => 3, 'base' => 's-a5'),
	array('info_id' => 2, 'group_id' => 3, 'base' => 's-a4'),
	array('info_id' => 3, 'group_id' => 3, 'base' => 's-a3'),
	array('info_id' => 4, 'group_id' => 3, 'base' => 's-a2'),
	array('info_id' => 5, 'group_id' => 3, 'base' => 's-a1'),
	array('info_id' => 6, 'group_id' => 3, 'base' => 's-o6'),
	array('info_id' => 7, 'group_id' => 3, 'base' => 's-o5'),
	array('info_id' => 8, 'group_id' => 3, 'base' => 's-o4'),
	array('info_id' => 9, 'group_id' => 3, 'base' => 's-o3'),
	array('info_id' => 10, 'group_id' => 3, 'base' => 's-o2'),
	array('info_id' => 11, 'group_id' => 3, 'base' => 's-o1'),
	array('info_id' => 18, 'group_id' => 3, 'base' => 's-w5'),
	array('info_id' => 19, 'group_id' => 3, 'base' => 's-w4'),
	array('info_id' => 20, 'group_id' => 3, 'base' => 's-w3'),
	array('info_id' => 21, 'group_id' => 3, 'base' => 's-w2'),
	array('info_id' => 22, 'group_id' => 3, 'base' => 's-w1'),
	array('info_id' => 23, 'group_id' => 3, 'base' => 's-e9'),
	array('info_id' => 24, 'group_id' => 3, 'base' => 's-e8'),
	array('info_id' => 25, 'group_id' => 3, 'base' => 's-e7'),
	array('info_id' => 26, 'group_id' => 3, 'base' => 's-e6'),
	array('info_id' => 27, 'group_id' => 3, 'base' => 's-e5'),
	array('info_id' => 28, 'group_id' => 3, 'base' => 's-e4'),
	array('info_id' => 29, 'group_id' => 3, 'base' => 's-e3'),
	array('info_id' => 30, 'group_id' => 3, 'base' => 's-e2'),
	array('info_id' => 31, 'group_id' => 3, 'base' => 's-e1'),
);

$positions = array(
	array(
		'name' => "Commanding Officer",
		'desc' => "Ultimately responsible for the ship and crew, the Commanding Officer is the most senior officer aboard a vessel. S/he is responsible for carrying out the orders of EarthForce, and for representing both Earthforce & Earth Alliance.",
		'dept_id' => 1,
		'order' => 0,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => "Executive Officer",
		'desc' => "The liaison between captain and crew, the Executive Officer acts as the disciplinarian, personnel manager, advisor to the captain, and much more. S/he is also one of only two officers, along with the Chief Medical Officer, that can remove a Commanding Officer from duty.",
		'dept_id' => 1,
		'order' => 1,
		'open' => 1,
		'type' => 'senior'),
		
	array(
		'name' => "Commander, Air Group",
		'desc' => "The Air Group Commander oversees the day-to-day operations of the Starfury pilots, assigning them their flight duties as well as handling all training.",
		'dept_id' => 2,
		'order' => 0,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => "Squadron Leader",
		'desc' => "A StarFury Squadron Leader is the second most senior officer below the CAG. Generally speaking, his duites are the same as the CAG, however, he also leads a squadron during missions.",
		'dept_id' => 2,
		'order' => 1,
		'open' => 5,
		'type' => 'officer'),
	array(
		'name' => "StarFury Pilot",
		'desc' => "A pilot in the StarFury squadron.",
		'dept_id' => 2,
		'order' => 2,
		'open' => 20,
		'type' => 'officer'),
		
	array(
		'name' => "Chief of Security",
		'desc' => "The Chief Security Officer is called Chief of Security. Her/his duty is to ensure the safety of ship and crew. She/he is also responsible for people under arrest and the safety of guests, liked or not. S/he also is a department head and a member of the senior staff, responsible for all the crew members in her/his department and duty rosters.",
		'dept_id' => 3,
		'order' => 0,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => "Assistant Chief of Security",
		'desc' => "The Assistant Chief Security Officer is sometimes called Deputy of Security. S/he assists the Chief of Security in the daily work; in issues regarding Security and any administrative matters. If required the Deputy must be able to take command of the Security department.",
		'dept_id' => 3,
		'order' => 1,
		'open' => 1,
		'type' => 'officer'),
	array(
		'name' => "Security Officer",
		'desc' => "There are several Security Officers aboard each vessel. They are assigned to their duties by the Chief of Security and his/her Deputy and mostly guard sensitive areas, protect people, patrol, and handle other threats to the Ship & or station.",
		'dept_id' => 3,
		'order' => 2,
		'open' => 5,
		'type' => 'officer'),
		
	array(
		'name' => "Chief of Engineering",
		'desc' => "The Chief Engineer is responsible for the condition of all systems and equipment on board a Earth Force ship or facility. S/he oversees maintenance, repairs and upgrades of all equipment. S/he is also responsible for the many repairs teams during crisis situations.\r\n\r\nThe Chief Engineer is not only the department head but also a senior officer, responsible for all the crew members in her/his department and maintenance of the duty rosters.",
		'dept_id' => 4,
		'order' => 0,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => "Engineering Officer",
		'desc' => "There are several non-specialized engineers aboard of each vessel. They are assigned to their duties by the Chief Engineer and his Assistant, performing a number of different tasks as required, i.e. general maintenance and repair. Generally, engineers as assigned to more specialized engineering person to assist in there work is so requested by the specialized engineer.",
		'dept_id' => 4,
		'order' => 1,
		'open' => 5,
		'type' => 'officer'),
	array(
		'name' => "Damage Control Officer",
		'desc' => "The Damage Control Specialist is a specialized Engineer. The Damage Control Specialist controls all damage control aboard the ship when it gets damaged in battle. S/he oversees all damage repair aboard the ship, and coordinates repair teams on the smaller jobs so the Chief Engineer can worry about other matters.\r\n\r\nA small team is assigned to the Damage Control Specialist which is made up from NCO personnel assigned by the Chief Engineer. The Damage Control Specialist reports to the Chief Engineer.",
		'dept_id' => 4,
		'order' => 2,
		'open' => 5,
		'type' => 'officer'),
		
	array(
		'name' => "Chief Medical Officer",
		'desc' => "The Chief Medical Officer is responsible for the physical health of the entire crew, but does more than patch up injured crew members. His/her function is to ensure that they do not get sick or injured to begin with, and to this end monitors their health and conditioning with regular check ups. If necessary, the Chief Medical Officer can remove anyone from duty, even a Commanding Officer. Besides this s/he is available to provide medical advice to any individual who requests it.\r\n\r\nAdditionally the Chief is also responsible for all aspect of the medical deck, such as the Medical labs, Surgical suites and Dentistry labs.\r\n\r\nS/he also is a department head and a member of the Senior Staff and responsible for all the crew members in her/his department and duty rosters.",
		'dept_id' => 5,
		'order' => 0,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => "Assistant Chief Medical Officer",
		'desc' => "A ship or facility has numerous personnel aboard, and thus the Chief Medical Officer cannot be expect to do all the work required. The Asst. Chief Medical Officer assists Chief in all areas, such as administration, and application of medical care.",
		'dept_id' => 5,
		'order' => 1,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => "Medical Officer",
		'desc' => "Medical Officer undertake the majority of the work aboard the ship/facility, examining the crew, and administering medical care under the instruction of the Chief Medical Officer and Assistant Chief Medical Officer also run the other Medical areas not directly overseen by the Chief Medical Officer.",
		'dept_id' => 5,
		'order' => 2,
		'open' => 5,
		'type' => 'officer'),
	array(
		'name' => "Medic",
		'desc' => "Medics undertake the majority of the work aboard the ship/facility, examining the crew, and administering medical care under the instruction of the Chief Medical Officer as well as running the other Medical areas not directly overseen by the Chief Medical Officer.",
		'dept_id' => 5,
		'order' => 3,
		'open' => 5,
		'type' => 'enlisted'),
		
	array(
		'name' => "Chief Communications Officer",
		'desc' => "The Chief Communications Officer oversees all of the communications arrays and equpment onbaord the ship/station maing sure everything is in working order.",
		'dept_id' => 6,
		'order' => 0,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => "Communications Officer",
		'desc' => "Communications Officers work under the direction of the Chief Communication Officer and are responsible for keeping in contact with all ships and stations.",
		'dept_id' => 6,
		'order' => 1,
		'open' => 3,
		'type' => 'officer'),
		
	array(
		'name' => "Marine Commander",
		'desc' => "The Marine CO is responsible for all the Marine personnel assigned to the ship/facility. S/he is in required to take command of any special ground operations and lease such actions with security. The CO can range from a Second Lieutenant on a small ship to a Lieutenant Colonel on a large facility or colony. Charged with the training, condition and tactical leadership of the Marine compliment, they are a member of the senior staff.\r\n\r\nAnswers to the Commanding Officer of the ship/facility.",
		'dept_id' => 7,
		'order' => 0,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => "Marine Deputy Commander",
		'desc' => "The Executive Officer of the Marines, works like any Asst. Department head, removing some of the work load from the Marine CO and if the need arises taking on the role of Marine CO. S/he oversees the regular duties of the Marines, from regular drills to equipment training, assignment and supply request to the ship/facilities Materials Officer.\r\n\r\nAnswers to the Marine Commanding Officer.",
		'dept_id' => 7,
		'order' => 1,
		'open' => 1,
		'type' => 'officer'),
	array(
		'name' => "Marine Sergeant",
		'desc' => "The First Sergeant is the highest ranked Enlisted marine. S/He is in charge of all of the marine enlisted affairs in the detachment. They assist the Company or Detachment Commander as their Executive Officer would. They act as a bridge, closing the gap between the NCOs and the Officers.\r\n\r\nAnswers To Marine Commanding Officer.",
		'dept_id' => 7,
		'order' => 2,
		'open' => 1,
		'type' => 'enlisted'),
	array(
		'name' => "Marine",
		'desc' => "Serving within a squad, the marine is trained in a variety of means of combat, from melee to ranged projectile to sniping.",
		'dept_id' => 7,
		'order' => 3,
		'open' => 10,
		'type' => 'enlisted'),
		
	array(
		'name' => "Chief Weapons Control Officer",
		'desc' => "The Chief Weapons Control Officer oversees all of the weapons onboard the ship/facility making sure all weapons are in useable condition.",
		'dept_id' => 8,
		'order' => 0,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => "Weapons Control Officer",
		'desc' => "The Weapons Control Officers oversee the weapons platform and are responsible for firing of the weapons on command.",
		'dept_id' => 8,
		'order' => 1,
		'open' => 3,
		'type' => 'officer'),
		
	array(
		'name' => "Chief Tactical Officer",
		'desc' => "The Chief Tactical Officer oversees all tactical decisions made onboard the ship/facility. Tactical Operations can include coordination of StarFury squadrons as well as vessel-to-vessel tactical operations. The Chief Tactical Officer works closely with those in the Weapons Division for the successful execution of tactical operations.",
		'dept_id' => 9,
		'order' => 0,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => "Tactical Officer",
		'desc' => "Tactical Officers assist the Chief Tactical Officer with the tactical operations aboard the ship/facility.",
		'dept_id' => 9,
		'order' => 1,
		'open' => 3,
		'type' => 'officer'),
);

$catalog_ranks = array(
	array(
		'name' => 'Duty Uniform',
		'location' => 'default',
		'credits' => "The Babylon 5 rank sets used in Nova were created by Kuro-chan of Kuro-RPG. The ranksets can be found at <a href='http://www.kuro-rpg.net' target='_blank''>Kuro-RPG</a>. Please do not copy or modify the images.",
		'genre' => $g)
);