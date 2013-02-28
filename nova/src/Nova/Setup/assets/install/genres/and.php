<?php
/*
|---------------------------------------------------------------
| INSTALL - GENRE DATA (and)
|---------------------------------------------------------------
|
| File: assets/install_data_and.php
| System Version: 1.0
|
| Genre data compiled by Moss (Anodyne forums) and David VanScott
|
*/

# TODO: figure out the rank image names

/*
|---------------------------------------------------------------
| Genre Variables
|---------------------------------------------------------------
*/
$g = 'and';

/*
|---------------------------------------------------------------
| Genre Table Data (and)
|---------------------------------------------------------------
*/
$data = array(
	'departments_'. $g 	=> 'depts',
	'ranks_'. $g		=> 'ranks',
	'positions_'. $g	=> 'positions',
	'catalog_ranks'		=> 'catalog_ranks',
);

$depts = array(
	array(
		'dept_name' => 'Command',
		'dept_desc' => "The Command department is ultimately responsible for the ship and its crew and those within the department are responsible for commanding the vessel and representing the interests of the High Guard.",
		'dept_order' => 0),
	array(
		'dept_name' => 'Pilots',
		'dept_desc' => "Responsible for the navigation and flight control of a vessel and its auxiliary craft, the Pilots division includes pilots trained in both starship and auxiliary craft piloting.",
		'dept_order' => 1),
	array(
		'dept_name' => 'Weapons',
		'dept_desc' => "Given the highly tactical role the High Guard plays, the Weapons division is responsible for all ship-to-ship security and tactical operations as well as maintaining the vast ordinance armament onboard High Guard ships.",
		'dept_order' => 2),
	array(
		'dept_name' => 'Engineering',
		'dept_desc' => "The Engineering division has the enormous task of keeping the vessel working. They are responsible for making repairs, fixing problems and making sure that the ship is ready for anything.",
		'dept_order' => 3),	
	array(
		'dept_name' => 'Science',
		'dept_desc' => "From sensor readings to figuring out a way to enter a strange spacial anomaly, the Science division is responsible for recording data, testing new ideas out and making discoveries.",
		'dept_order' => 4),
	array(
		'dept_name' => 'Medical',
		'dept_desc' => "The Medical division is responsible for the mental and physical health of the crew. This includes everything from running annual physicals to combatting a strange plague afflicting the crew to helping a crew member deal with the loss of a loved one.",
		'dept_order' => 5),
	array(
		'dept_name' => 'Communications',
		'dept_desc' => "The Communications division is responsible for external and internal communications on the ship.",
		'dept_order' => 6),
	array(
		'dept_name' => 'Lancer Detachment',
		'dept_desc' => "When the standard security detail is not enough, the Lancers come in and clean up. The Lancer Detachment is a powerful tactical addition to any High Guard vessel, responsible for partaking in personal combat, from sniping to melee.",
		'dept_order' => 7),
);

$ranks = array(
	array(
		'rank_name' => 'Fleet Admiral',
		'rank_short_name' => 'FADM',
		'rank_image' => 'a5',
		'rank_order' => 0,
		'rank_class' => 1),
	array(
		'rank_name' => 'Admiral',
		'rank_short_name' => 'ADM',
		'rank_image' => 'a4',
		'rank_order' => 1,
		'rank_class' => 1),
	array(
		'rank_name' => 'Vice-Admiral',
		'rank_short_name' => 'VADM',
		'rank_image' => 'a3',
		'rank_order' => 2,
		'rank_class' => 1),
	array(
		'rank_name' => 'Rear-Admiral (Upper Half)',
		'rank_short_name' => 'RADM',
		'rank_image' => 'a2',
		'rank_order' => 3,
		'rank_class' => 1),
	array(
		'rank_name' => 'Rear-Admiral (Lower Half)',
		'rank_short_name' => 'RADM',
		'rank_image' => 'a1',
		'rank_order' => 4,
		'rank_class' => 1),
	array(
		'rank_name' => 'Captain',
		'rank_short_name' => 'CAPT',
		'rank_image' => 'o6',
		'rank_order' => 5,
		'rank_class' => 1),
	array(
		'rank_name' => 'Commander',
		'rank_short_name' => 'CMDR',
		'rank_image' => 'o5',
		'rank_order' => 6,
		'rank_class' => 1),
	array(
		'rank_name' => 'Lieutenant Commander',
		'rank_short_name' => 'LTCMDR',
		'rank_image' => 'o4',
		'rank_order' => 7,
		'rank_class' => 1),
	array(
		'rank_name' => 'Lieutenant',
		'rank_short_name' => 'LT',
		'rank_image' => 'o3',
		'rank_order' => 8,
		'rank_class' => 1),
	array(
		'rank_name' => 'Lieutenant JG',
		'rank_short_name' => 'LT(JG)',
		'rank_image' => 'o2',
		'rank_order' => 9,
		'rank_class' => 1),
	array(
		'rank_name' => 'Ensign',
		'rank_short_name' => 'ENS',
		'rank_image' => 'o1',
		'rank_order' => 10,
		'rank_class' => 1),
	array(
		'rank_name' => 'Argosy Chief Petty Officer',
		'rank_short_name' => 'ACPO',
		'rank_image' => 'e9',
		'rank_order' => 11,
		'rank_class' => 1),
	array(
		'rank_name' => 'Master Chief Petty Officer',
		'rank_short_name' => 'MCPO',
		'rank_image' => 'e8',
		'rank_order' => 12,
		'rank_class' => 1),
	array(
		'rank_name' => 'Senior Chief Petty Officer',
		'rank_short_name' => 'SCPO',
		'rank_image' => 'e7',
		'rank_order' => 13,
		'rank_class' => 1),
	array(
		'rank_name' => 'Chief Petty Officer',
		'rank_short_name' => 'CPO',
		'rank_image' => 'e6',
		'rank_order' => 14,
		'rank_class' => 1),
	array(
		'rank_name' => 'Petty Officer',
		'rank_short_name' => 'PO',
		'rank_image' => 'e5',
		'rank_order' => 15,
		'rank_class' => 1),
	array(
		'rank_name' => 'Master Spacer',
		'rank_short_name' => 'MSPC',
		'rank_image' => 'e4',
		'rank_order' => 16,
		'rank_class' => 1),
	array(
		'rank_name' => 'Senior Spacer',
		'rank_short_name' => 'SSPC',
		'rank_image' => 'e3',
		'rank_order' => 17,
		'rank_class' => 1),
	array(
		'rank_name' => 'Spacer, 1st Class',
		'rank_short_name' => 'SPC1',
		'rank_image' => 'e2',
		'rank_order' => 18,
		'rank_class' => 1),
	array(
		'rank_name' => 'Spacer',
		'rank_short_name' => 'S',
		'rank_image' => 'e1',
		'rank_order' => 19,
		'rank_class' => 1),
	array(
		'rank_name' => '',
		'rank_short_name' => '',
		'rank_image' => 'blank',
		'rank_order' => 20,
		'rank_class' => 1),
		
	array(
		'rank_name' => 'General',
		'rank_short_name' => 'GEN',
		'rank_image' => 'a4',
		'rank_order' => 0,
		'rank_class' => 2),
	array(
		'rank_name' => 'Lieutenant General',
		'rank_short_name' => 'LTGEN',
		'rank_image' => 'a3',
		'rank_order' => 1,
		'rank_class' => 2),
	array(
		'rank_name' => 'Major General',
		'rank_short_name' => 'MAJGEN',
		'rank_image' => 'a2',
		'rank_order' => 2,
		'rank_class' => 2),
	array(
		'rank_name' => 'Brigadier General',
		'rank_short_name' => 'BGEN',
		'rank_image' => 'a1',
		'rank_order' => 3,
		'rank_class' => 2),
	array(
		'rank_name' => 'Colonel',
		'rank_short_name' => 'COL',
		'rank_image' => 'o6',
		'rank_order' => 4,
		'rank_class' => 2),
	array(
		'rank_name' => 'Lieutenant Colonel',
		'rank_short_name' => 'LTCOL',
		'rank_image' => 'o5',
		'rank_order' => 5,
		'rank_class' => 2),
	array(
		'rank_name' => 'Major',
		'rank_short_name' => 'MAJ',
		'rank_image' => 'o4',
		'rank_order' => 6,
		'rank_class' => 2),
	array(
		'rank_name' => 'Brevet Major',
		'rank_short_name' => 'BMAJ',
		'rank_image' => 'o3',
		'rank_order' => 7,
		'rank_class' => 2),
	array(
		'rank_name' => '1st Signifier',
		'rank_short_name' => '1SIG',
		'rank_image' => 'o2',
		'rank_order' => 8,
		'rank_class' => 2),
	array(
		'rank_name' => '2nd Signifier',
		'rank_short_name' => '2SIG',
		'rank_image' => 'o1',
		'rank_order' => 9,
		'rank_class' => 2),
	array(
		'rank_name' => 'Sergeant Major of the Lancers',
		'rank_short_name' => 'SGTMAJ',
		'rank_image' => 'e9',
		'rank_order' => 10,
		'rank_class' => 2),
	array(
		'rank_name' => 'Sergeant Major',
		'rank_short_name' => 'SGTMAJ',
		'rank_image' => 'e8',
		'rank_order' => 11,
		'rank_class' => 2),
	array(
		'rank_name' => 'First Sergeant',
		'rank_short_name' => '1SGT',
		'rank_image' => 'e7',
		'rank_order' => 12,
		'rank_class' => 2),
	array(
		'rank_name' => 'Master Sergeant',
		'rank_short_name' => 'MSGT',
		'rank_image' => 'e6',
		'rank_order' => 13,
		'rank_class' => 2),
	array(
		'rank_name' => 'Gunnery Sergeant',
		'rank_short_name' => 'GYSGT',
		'rank_image' => 'e5',
		'rank_order' => 14,
		'rank_class' => 2),
	array(
		'rank_name' => 'Staff Sergeant',
		'rank_short_name' => 'SSGT',
		'rank_image' => 'e4',
		'rank_order' => 15,
		'rank_class' => 2),
	array(
		'rank_name' => 'Sergeant',
		'rank_short_name' => 'SGT',
		'rank_image' => 'e3',
		'rank_order' => 16,
		'rank_class' => 2),
	array(
		'rank_name' => 'Lancer, 1st Class',
		'rank_short_name' => 'LNC1',
		'rank_image' => 'e2',
		'rank_order' => 17,
		'rank_class' => 2),
	array(
		'rank_name' => 'Lancer',
		'rank_short_name' => 'LNC',
		'rank_image' => 'e1',
		'rank_order' => 18,
		'rank_class' => 2),
	array(
		'rank_name' => '',
		'rank_short_name' => '',
		'rank_image' => 'blank',
		'rank_order' => 19,
		'rank_class' => 2),
);

$positions = array(
	array(
		'pos_name' => 'Commanding Officer',
		'pos_desc' => "Ultimately responsible for the ship and crew, the Commanding Officer is the most senior officer aboard a vessel. S/he is responsible for carrying out the orders of the High Guard and for representing both the High Guard and the Commonwealth.",
		'pos_dept' => 1,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'First Officer',
		'pos_desc' => "The liaison between captain and crew, the First Officer acts as the disciplinarian, personnel manager, advisor to the captain and much more. S/he is also one of only two officers, along with the Chief Medical Officer, who can remove a Commanding Officer from duty.",
		'pos_dept' => 1,
		'pos_order' => 1,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Chief of the Boat',
		'pos_desc' => "The senior-most Argosy Petty Officer (including Senior and Master Chiefs), regardless of rating, is designated by the Commanding Officer as the Chief of the Boat (for vessels) or Command Chief (for bases). In addition to his or her departmental responsibilities, the COB/CC performs the following duties: serves as a liaison between the Commanding Officer (or First Officer) and the enlisted crewmen, ensures enlisted crews understand Command policies, advises the Commanding Officer and First Officer regarding enlisted morale and evaluates the quality of noncommissioned officer leadership, management and supervisory training. The COB/CC works with the other department heads, Chiefs, supervisors, and crewmen to insure discipline is equitably maintained and the welfare, morale, and health needs of the enlisted personnel are met. The COB/CC is qualified to temporarily act as Commanding or First Officer if so ordered.",
		'pos_dept' => 1,
		'pos_order' => 2,
		'pos_open' => 1,
		'pos_type' => 'enlisted'),
	array(
		'pos_name' => 'Ship Artificial Intelligence',
		'pos_desc' => "An artificial intelligence which controls the ship (and numerous robots and androids) and can replace most of the functions of crew. Can appear as a human-like figure on any display or as a hologram. The display and the hologram possess different aspects of the AI personality.",
		'pos_dept' => 1,
		'pos_order' => 3,
		'pos_open' => 1,
		'pos_type' => 'other'),
	array(
		'pos_name' => 'Master-at-Arms',
		'pos_desc' => "The Master-at-Arms trains and supervises security crewmen in departmental operations, repairs, and protocols, maintains duty assignments for all Security personnel, supervises weapons locker access and firearm deployment and is qualified to act as ships/vessels Chief Weapons Officer. The Master-at-Arms can also be a Lancer or Naval non-commissioned officer and works with both the Lancer Detachment Sergeant Major and the Chief of the Boat and/or Command Chief, however the Master-at-Arms falls outside the chain of command of both Senior Enlisted Advisors and reports directly to the Commanding Officer and can be found on the command deck at all times.",
		'pos_dept' => 1,
		'pos_order' => 4,
		'pos_open' => 1,
		'pos_type' => 'enlisted'),
	array(
		'pos_name' => 'Chief Piloting Officer',
		'pos_desc' => "The Pilot division incorporates two jobs: navigation and flight control. A piloting officer must always be present on the bridge of a starship. S/he plots courses, supervises the computers piloting, corrects any flight deviations and pilots the ship manually when needed. The Chief Piloting Officer is the senior most pilot officer aboard, serving as a Senior Officer and chief of the personnel under him/her.",
		'pos_dept' => 2,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Piloting Officer',
		'pos_desc' => "The Pilot division incorporates two jobs: navigation and flight control. A pilot officer must always be present on the command deck and every vessel has a number of pilot officers to allow shift rotations. S/he plots courses, supervises the computers piloting, corrects any flight deviations and pilots the ship manually when needed. Reports directly to the Chief Piloting Officer.",
		'pos_dept' => 2,
		'pos_order' => 1,
		'pos_open' => 5,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Chief Weapons Officer',
		'pos_desc' => "The Chief Weapons Officer is responsible for overseeing all tactical and security matters aboard High Guard ships. S/he mans the weapons console on the bridge (from which they coordinate the ship-to-ship combat assets) and ensures security is maintained both on the ship and when the crew leave the ship. The Chief Weapons Officer is the seniormost member of the Weapons division.",
		'pos_dept' => 3,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Weapons Officer',
		'pos_desc' => "There are several Weapons Officers aboard each vessel and are assigned duties by the Weapon's Chief. Most common duties of a Weapons Officer are guarding sensitive areas, protecting people, patrol and handling other threats to the Commonwealth.",
		'pos_dept' => 3,
		'pos_order' => 1,
		'pos_open' => 5,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Gunner',
		'pos_desc' => "An integral part of any High Guard ship, the Gunners are individuals who operate the weapons stations aboard a High Guard ship and assist the Weapon's Chief in maintaining and overseeing the ordinance aboard the ship.",
		'pos_dept' => 3,
		'pos_order' => 2,
		'pos_open' => 10,
		'pos_type' => 'enlisted'),
	array(
		'pos_name' => 'Chief Engineering Officer',
		'pos_desc' => "The Chief Engineer is responsible for the condition of all systems and equipment on board a High Guard ship or facility. S/he oversees maintenance, repairs and upgrades of all equipment and is also responsible for the many repair teams during crisis situations. The Chief Engineer is not only the division head but also a senior officer, responsible for all the crew members in their division.",
		'pos_dept' => 4,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Engineering Officer',
		'pos_desc' => "There are several non-specialized engineers aboard each vessel. They are assigned to their duties by the Chief Engineer and perfor a number of tasks as required (i.e. general maintenance and repair). Generally, engineers are assigned to more specialized engineering persons to assist in their work if so requested by the specialized engineer.",
		'pos_dept' => 4,
		'pos_order' => 2,
		'pos_open' => 5,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Damage Control Specialist',
		'pos_desc' => "The Damage Control Specialist is a specialized engineer. The Damage Control Specialist oversees all damage control aboard the ship when it gets damaged in any capacity. S/he coordinates all repairs aboard the ship as ordered by the Chief Engineer. A small team is assigned to the Damage Control Specialist which is made up from personnel assigned by the Chief Engineer. The Damage Control Specialist reports to the Chief Engineer.",
		'pos_dept' => 4,
		'pos_order' => 3,
		'pos_open' => 5,
		'pos_type' => 'enlisted'),
	array(
		'pos_name' => 'Chief Science Officer',
		'pos_desc' => "The Chief Science Officer is responsible for all the scientific data the ship/facility collects and the distribution of such data to specific sections within the division for analysis. S/he is also responsible with providing the ship's captain with scientific information needed for command decisions. As a division head and a member of the Senior Staff, s/he is responsible for all the crew members in their division.",
		'pos_dept' => 5,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Science Officer',
		'pos_desc' => "There are several general Science Officers aboard each vessel and are assigned their duties by the Chief Science Officer. Assignments include work for the specialized section heads as well as duties for work being carried out by the Chief Science Officer.",
		'pos_dept' => 5,
		'pos_order' => 1,
		'pos_open' => 5,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Chief Medical Officer',
		'pos_desc' => "The Chief Medical Officer is responsible for the physical health of the entire crew, but does more than patch up injured crew members. His/her function is to ensure they do not get sick or injured to begin with and to this end monitors their health and conditioning with regular checkups. If necessary, the Chief Medical Officer can remove anyone from duty, even a Commanding Officer.",
		'pos_dept' => 6,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Counselor',
		'pos_desc' => "Because of their training in psychology, the ship/facility's Counselor is considered part of High Guard Medical. The Counselor is responsible both for advising the Commanding Officer in dealing with other people and races and in helping crew members with personal, psychological, and emotional problems. The Counselor is considered a member of the Senior Staff and is responsible for any counseling personnel in their division.",
		'pos_dept' => 6,
		'pos_order' => 1,
		'pos_open' => 1,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Medical Officer',
		'pos_desc' => "Medical Officers undertake the majority of medical work aboard the ship/facility, examining the crew and administering medical care under the instruction of the Chief Medical Officer.",
		'pos_dept' => 6,
		'pos_order' => 2,
		'pos_open' => 5,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Nurse',
		'pos_desc' => "The backbone of any infirmary, nurses are trained in basic medical care and are capable of dealing with less serious medical cases. In more serious matters nurses assist the medical officers in the examination and administration of medical care. Nurses also maintain the medical wards, overseeing the patients and ensuring they are receiving medication and care as instructed by the Chief Medical Officer.",
		'pos_dept' => 6,
		'pos_order' => 3,
		'pos_open' => 15,
		'pos_type' => 'enlisted'),
	array(
		'pos_name' => 'Chief Communications Officer',
		'pos_desc' => "The Chief Communications Officer is responsible for the control and maintainance of all communications equipment aboard the ship/facility. This includes working with the universal transloator, controlling internal communications and coordincation external communications with other ships, stations or colonies/planets.",
		'pos_dept' => 7,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Communications Officer',
		'pos_desc' => "The Communications Officer is responsible for the control and maintainance of all communications equipment aboard the ship/facility. This role involves the study of new and old languages and text in an attempt to better understand and interpret their meaning. Reports to the Chief Communications Officer.",
		'pos_dept' => 7,
		'pos_order' => 1,
		'pos_open' => 5,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Lancer Commanding Officer',
		'pos_desc' => "The Lancer CO is responsible for all Lancer personnel assigned to the ship/facility.  S/he is in required to take command of any special ground operations and lead such actions with security.  The Lancer CO can range from a Second Lieutenant on a small ship to a Lieutenant Colonel on a large facility or colony. Charged with the training, condition and tactical leadership of the Lancer compliment, they are a member of the Senior Staff.",
		'pos_dept' => 8,
		'pos_order' => 0,
		'pos_open' => 1,
		'pos_type' => 'senior'),
	array(
		'pos_name' => 'Lancer First Officer',
		'pos_desc' => "The First Officer of the Lancer Detachment works like any assistant division head, removing some of the work load from the Lancer CO, and if the need arises, taking on the role of head of the Lancer Detachment. S/he oversees the regular duties of the Lancers, from regular drills to equipment training, assignment and supply requests.",
		'pos_dept' => 8,
		'pos_order' => 1,
		'pos_open' => 1,
		'pos_type' => 'officer'),
	array(
		'pos_name' => 'Lancer Sergeant',
		'pos_desc' => "The Lancer Sergeant is the highest ranked enlisted Lancer. S/he is in charge of all of the Lancer enlisted affairs in the detachment. They assist the Company or Detachment Commander as their First Officer would. They act to close the gap between the non-commissioned officers and the officers.",
		'pos_dept' => 8,
		'pos_order' => 2,
		'pos_open' => 1,
		'pos_type' => 'enlisted'),
	array(
		'pos_name' => 'Lancer',
		'pos_desc' => "Serving within a squad, the Lancer is trained in a variety of means of combat, from melee to ranged projectile to sniping.",
		'pos_dept' => 8,
		'pos_order' => 3,
		'pos_open' => 20,
		'pos_type' => 'enlisted'),
);

$catalog_ranks = array(
	array(
		'rankcat_name' => 'Duty Ranks',
		'rankcat_location' => 'default',
		'rankcat_credits' => "The Andromeda Duty rank set was created by Fedhog of Kuro-RPG. The rankset can be found at <a href='http://www.kuro-rpg.net' target='_blank'>Kuro-RPG</a>. Please do not copy or modify the images.",
		'rankcat_default' => 'y')
);