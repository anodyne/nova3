<?php
/**
 * Genre Install Data (MOV)
 *
 * @package		Install
 * @category	Assets
 * @author		Anodyne Productions
 */

$g = 'mov';

$data = array(
	'departments_'.$g 	=> 'depts',
	'ranks_'.$g			=> 'ranks',
	'positions_'.$g		=> 'positions',
	'catalog_ranks'		=> 'catalog_ranks'
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

$ranks = array(
	array(
		'name' => 'Fleet Admiral',
		'short_name' => 'FADM',
		'image' => 'w-a5',
		'order' => 0,
		'class' => 1),
	array(
		'name' => 'Fleet Admiral',
		'short_name' => 'FADM',
		'image' => 'y-a5',
		'order' => 0,
		'class' => 2),
	array(
		'name' => 'Fleet Admiral',
		'short_name' => 'FADM',
		'image' => 't-a5',
		'order' => 0,
		'class' => 3),
	array(
		'name' => 'Fleet Admiral',
		'short_name' => 'FADM',
		'image' => 'r-a5',
		'order' => 0,
		'class' => 4),
		
	array(
		'name' => 'Admiral',
		'short_name' => 'ADM',
		'image' => 'w-a4',
		'order' => 1,
		'class' => 1),
	array(
		'name' => 'Admiral',
		'short_name' => 'ADM',
		'image' => 'y-a4',
		'order' => 1,
		'class' => 2),
	array(
		'name' => 'Admiral',
		'short_name' => 'ADM',
		'image' => 't-a4',
		'order' => 1,
		'class' => 3),
	array(
		'name' => 'Admiral',
		'short_name' => 'ADM',
		'image' => 'r-a4',
		'order' => 1,
		'class' => 3),
		
	array(
		'name' => 'Vice-Admiral',
		'short_name' => 'VADM',
		'image' => 'w-a3',
		'order' => 2,
		'class' => 1),
	array(
		'name' => 'Vice-Admiral',
		'short_name' => 'VADM',
		'image' => 'y-a3',
		'order' => 2,
		'class' => 2),
	array(
		'name' => 'Vice-Admiral',
		'short_name' => 'VADM',
		'image' => 't-a3',
		'order' => 2,
		'class' => 3),
	array(
		'name' => 'Vice-Admiral',
		'short_name' => 'VADM',
		'image' => 'r-a3',
		'order' => 2,
		'class' => 4),
		
	array(
		'name' => 'Rear-Admiral',
		'short_name' => 'RADM',
		'image' => 'w-a2',
		'order' => 3,
		'class' => 1),
	array(
		'name' => 'Rear-Admiral',
		'short_name' => 'RADM',
		'image' => 'y-a2',
		'order' => 3,
		'class' => 2),
	array(
		'name' => 'Rear-Admiral',
		'short_name' => 'RADM',
		'image' => 't-a2',
		'order' => 3,
		'class' => 3),
	array(
		'name' => 'Rear-Admiral',
		'short_name' => 'RADM',
		'image' => 'r-a2',
		'order' => 3,
		'class' => 4),
		
	array(
		'name' => 'Commodore',
		'short_name' => 'COMO',
		'image' => 'w-a1',
		'order' => 4,
		'class' => 1),
	array(
		'name' => 'Commodore',
		'short_name' => 'COMO',
		'image' => 'y-a1',
		'order' => 4,
		'class' => 2),
	array(
		'name' => 'Commodore',
		'short_name' => 'COMO',
		'image' => 't-a1',
		'order' => 4,
		'class' => 3),
	array(
		'name' => 'Commodore',
		'short_name' => 'COMO',
		'image' => 'r-a1',
		'order' => 4,
		'class' => 4),
		
	array(
		'name' => 'Captain',
		'short_name' => 'CAPT',
		'image' => 'w-o6',
		'order' => 5,
		'class' => 1),
	array(
		'name' => 'Captain',
		'short_name' => 'CAPT',
		'image' => 'y-o6',
		'order' => 5,
		'class' => 2),
	array(
		'name' => 'Captain',
		'short_name' => 'CAPT',
		'image' => 't-o6',
		'order' => 5,
		'class' => 3),
	array(
		'name' => 'Captain',
		'short_name' => 'CAPT',
		'image' => 'r-o6',
		'order' => 5,
		'class' => 4),
	
	array(
		'name' => 'Commander',
		'short_name' => 'CMDR',
		'image' => 'w-o5',
		'order' => 6,
		'class' => 1),
	array(
		'name' => 'Commander',
		'short_name' => 'CMDR',
		'image' => 'y-o5',
		'order' => 6,
		'class' => 2),
	array(
		'name' => 'Commander',
		'short_name' => 'CMDR',
		'image' => 't-o5',
		'order' => 6,
		'class' => 3),
	array(
		'name' => 'Commander',
		'short_name' => 'CMDR',
		'image' => 'r-o5',
		'order' => 6,
		'class' => 4),
		
	array(
		'name' => 'Lieutenant Commander',
		'short_name' => 'LT CMDR',
		'image' => 'w-o4',
		'order' => 7,
		'class' => 1),
	array(
		'name' => 'Lieutenant Commander',
		'short_name' => 'LT CMDR',
		'image' => 'y-o4',
		'order' => 7,
		'class' => 2),
	array(
		'name' => 'Lieutenant Commander',
		'short_name' => 'LT CMDR',
		'image' => 't-o4',
		'order' => 7,
		'class' => 3),
	array(
		'name' => 'Lieutenant Commander',
		'short_name' => 'LT CMDR',
		'image' => 'r-o4',
		'order' => 7,
		'class' => 4),
		
	array(
		'name' => 'Lieutenant',
		'short_name' => 'LT',
		'image' => 'w-o3',
		'order' => 8,
		'class' => 1),
	array(
		'name' => 'Lieutenant',
		'short_name' => 'LT',
		'image' => 'y-o3',
		'order' => 8,
		'class' => 2),
	array(
		'name' => 'Lieutenant',
		'short_name' => 'LT',
		'image' => 't-o3',
		'order' => 8,
		'class' => 3),
	array(
		'name' => 'Lieutenant',
		'short_name' => 'LT',
		'image' => 'r-o3',
		'order' => 8,
		'class' => 4),
		
	array(
		'name' => 'Lieutenant JG',
		'short_name' => 'LT(JG)',
		'image' => 'w-o2',
		'order' => 9,
		'class' => 1),
	array(
		'name' => 'Lieutenant JG',
		'short_name' => 'LT(JG)',
		'image' => 'y-o2',
		'order' => 9,
		'class' => 2),
	array(
		'name' => 'Lieutenant JG',
		'short_name' => 'LT(JG)',
		'image' => 't-o2',
		'order' => 9,
		'class' => 3),
	array(
		'name' => 'Lieutenant JG',
		'short_name' => 'LT(JG)',
		'image' => 'r-o2',
		'order' => 9,
		'class' => 4),
		
	array(
		'name' => 'Ensign',
		'short_name' => 'EN',
		'image' => 'w-o1',
		'order' => 10,
		'class' => 1),
	array(
		'name' => 'Ensign',
		'short_name' => 'EN',
		'image' => 'y-o1',
		'order' => 10,
		'class' => 2),
	array(
		'name' => 'Ensign',
		'short_name' => 'EN',
		'image' => 't-o1',
		'order' => 10,
		'class' => 3),
	array(
		'name' => 'Ensign',
		'short_name' => 'EN',
		'image' => 'r-o1',
		'order' => 10,
		'class' => 4),
		
	array(
		'name' => 'Master Chief Petty Officer',
		'short_name' => 'MCPO',
		'image' => 'w-e6',
		'order' => 11,
		'class' => 1),
	array(
		'name' => 'Master Chief Petty Officer',
		'short_name' => 'MCPO',
		'image' => 'y-e6',
		'order' => 11,
		'class' => 2),
	array(
		'name' => 'Master Chief Petty Officer',
		'short_name' => 'MCPO',
		'image' => 't-e6',
		'order' => 11,
		'class' => 3),
	array(
		'name' => 'Master Chief Petty Officer',
		'short_name' => 'MCPO',
		'image' => 'r-e6',
		'order' => 11,
		'class' => 4),
		
	array(
		'name' => 'Senior Chief Petty Officer',
		'short_name' => 'SCPO',
		'image' => 'w-e5',
		'order' => 12,
		'class' => 1),
	array(
		'name' => 'Senior Chief Petty Officer',
		'short_name' => 'SCPO',
		'image' => 'y-e5',
		'order' => 12,
		'class' => 2),
	array(
		'name' => 'Senior Chief Petty Officer',
		'short_name' => 'SCPO',
		'image' => 't-e5',
		'order' => 12,
		'class' => 3),
	array(
		'name' => 'Senior Chief Petty Officer',
		'short_name' => 'SCPO',
		'image' => 'r-e5',
		'order' => 12,
		'class' => 4),
		
	array(
		'name' => 'Chief Petty Officer',
		'short_name' => 'CPO',
		'image' => 'w-e4',
		'order' => 13,
		'class' => 1),
	array(
		'name' => 'Chief Petty Officer',
		'short_name' => 'CPO',
		'image' => 'y-e4',
		'order' => 13,
		'class' => 2),
	array(
		'name' => 'Chief Petty Officer',
		'short_name' => 'CPO',
		'image' => 't-e4',
		'order' => 13,
		'class' => 3),
	array(
		'name' => 'Chief Petty Officer',
		'short_name' => 'CPO',
		'image' => 'r-e4',
		'order' => 13,
		'class' => 4),
		
	array(
		'name' => 'Petty Officer, 1st Class',
		'short_name' => 'PO1',
		'image' => 'w-e3',
		'order' => 14,
		'class' => 1),
	array(
		'name' => 'Petty Officer, 1st Class',
		'short_name' => 'PO1',
		'image' => 'y-e3',
		'order' => 14,
		'class' => 2),
	array(
		'name' => 'Petty Officer, 1st Class',
		'short_name' => 'PO1',
		'image' => 't-e3',
		'order' => 14,
		'class' => 3),
	array(
		'name' => 'Petty Officer, 1st Class',
		'short_name' => 'PO1',
		'image' => 'r-e3',
		'order' => 14,
		'class' => 4),
		
	array(
		'name' => 'Petty Officer, 2nd Class',
		'short_name' => 'PO2',
		'image' => 'w-e2',
		'order' => 15,
		'class' => 1),
	array(
		'name' => 'Petty Officer, 2nd Class',
		'short_name' => 'PO2',
		'image' => 'y-e2',
		'order' => 15,
		'class' => 2),
	array(
		'name' => 'Petty Officer, 2nd Class',
		'short_name' => 'PO2',
		'image' => 't-e2',
		'order' => 15,
		'class' => 3),
	array(
		'name' => 'Petty Officer, 2nd Class',
		'short_name' => 'PO2',
		'image' => 'r-e2',
		'order' => 15,
		'class' => 4),
		
	array(
		'name' => 'Crewman',
		'short_name' => 'CR',
		'image' => 'w-e1',
		'order' => 16,
		'class' => 1),
	array(
		'name' => 'Crewman',
		'short_name' => 'CR',
		'image' => 'y-e1',
		'order' => 16,
		'class' => 2),
	array(
		'name' => 'Crewman',
		'short_name' => 'CR',
		'image' => 't-e1',
		'order' => 16,
		'class' => 3),
	array(
		'name' => 'Crewman',
		'short_name' => 'CR',
		'image' => 'r-e1',
		'order' => 16,
		'class' => 4),
		
	array(
		'name' => '',
		'short_name' => '',
		'image' => 'w-blank',
		'order' => 17,
		'class' => 1),
	array(
		'name' => '',
		'short_name' => '',
		'image' => 'y-blank',
		'order' => 17,
		'class' => 2),
	array(
		'name' => '',
		'short_name' => '',
		'image' => 't-blank',
		'order' => 17,
		'class' => 3),
	array(
		'name' => '',
		'short_name' => '',
		'image' => 'r-blank',
		'order' => 17,
		'class' => 4)
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
		'desc' => "The Navigator is responsible for projecting the course of a starship and determining a ship's position, velocity and direction in relationship to a course. The navigator can also use the ship's navigational sensors to determine the positions, speeds and trajectories of other objects. Additionally, the navigator is in charge of coordinating phaser crews for real and simulated combat and for firing the weapons.",
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
		'name' => 'Duty Uniforms',
		'location' => 'default',
		'credits' => "The Star Trek Movie era rank sets used in Nova were created by Kuro-chan of Kuro-RPG. The ranksets can be found at <a href='http://www.kuro-rpg.net' target='_blank''>Kuro-RPG</a>. Please do not copy or modify the images.",
		'default' => 1,
		'genre' => $g)
);
