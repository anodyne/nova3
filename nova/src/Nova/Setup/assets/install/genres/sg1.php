<?php
/**
 * Genre Install Data (SG1)
 *
 * @package		Nova
 * @subpackage	Setup
 * @category	Asset
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */

$g = 'sg1';

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
		'desc' => "The Command Department consists of the Commander and the Executive Officer. The Commander is ultimately responsible for the safety and welfare of the SG Team. S/he has final authority on all decisions regarding the ship and her mission. The Executive officer or XO is the commander's immediate subordinate, and is also his/her successor should the need arise.",
		'order' => 0),
	array(
		'name' => 'Archeology',
		'desc' => "The Branch of anthropology studies people and their cultures on off world planets and catalogs them back on base for further study of the culture and its people.  Civilans play an important role in this department because Armed forces usually don't have jobs in Archeology.",
		'order' => 1),
	array(
		'name' => 'Linguistics',
		'desc' => "Linguists are the people that can communicate in different languages with other cultures.  Both Military and Civilians are employed to do this.",
		'order' => 2),
	array(
		'name' => 'Engineering',
		'desc' => "When something needs fixing these are the people men and women, military and civilian that get called.   Engineers are responsible for the fixing computer systems, to the stargate, and even sending in UAVs & MALPs.",
		'order' => 3),
	array(
		'name' => 'Science',
		'desc' => "The Science department is always making discoveries on survival, coming up with new ideas on how to help the team, and cataloging information on current off world discoveries and events.",
		'order' => 4),
	array(
		'name' => 'Medical',
		'desc' => "When a person is either hurt or sick the medical department will always be there.  These skilled men and women are doctors and medics either staying in the infirmary or going out in the fields with teams.",
		'order' => 5),
	array(
		'name' => 'Diplomatic Liaisons',
		'desc' => "Representing Earth and Humans alike the diplomat Liaisons stay on base or travel out with teams making sure the human race is not seen in a negative right.",
		'order' => 6),
	array(
		'name' => 'Fighter Squadron',
		'desc' => "When Earth is in those dire situations the X302 is there. With the ability to fly on planet they have the capability of also flying in space.",
		'order' => 7),
	array(
		'name' => 'Military',
		'desc' => "Your Military personnel in an SG Team are trained combat warriors from all branch all over the world.  In some times things get sticky and military is there to back it up with expert combat knowledge and firepower.",
		'order' => 8),
	array(
		'name' => 'Alpha Team',
		'desc' => "The Alpha Team of SG1.  Capable of carrying out missions and orders directed to them.",
		'order' => 9),
	array(
		'name' => 'Bravo Team',
		'desc' => "The Bravo Team of SG1.  Capable of carrying out missions and orders directed to them.",
		'order' => 10)
);

$groups = array(
	array('name' => 'Army', 'order' => 0),
	array('name' => 'Marines', 'order' => 1),
	array('name' => 'Air Force', 'order' => 2),
);

$info = array(
	array('name' => "General", 'short_name' => "GEN", 'order' => 0, 'group' => 1),
	array('name' => "Lieutenant General", 'short_name' => "LTG", 'order' => 1, 'group' => 1),
	array('name' => "Major General", 'short_name' => "MG", 'order' => 2, 'group' => 1),
	array('name' => "Brigadier General", 'short_name' => "BG", 'order' => 3, 'group' => 1),

	array('name' => "Colonel", 'short_name' => "COL", 'order' => 0, 'group' => 2),
	array('name' => "Lieutenant Colonel", 'short_name' => "LTC", 'order' => 1, 'group' => 2),
	array('name' => "Major", 'short_name' => "MAJ", 'order' => 2, 'group' => 2),
	array('name' => "Captain", 'short_name' => "CPT", 'order' => 3, 'group' => 2),
	array('name' => "1st Lieutenant", 'short_name' => "1LT", 'order' => 4, 'group' => 2),
	array('name' => "2nd Lieutenant", 'short_name' => "2LT", 'order' => 5, 'group' => 2),

	array('name' => "Sergeant Major", 'short_name' => "SGM", 'order' => 0, 'group' => 3),
	array('name' => "Master Sergeant", 'short_name' => "MSG", 'order' => 1, 'group' => 3),
	array('name' => "Sergeant 1st Class", 'short_name' => "SFC", 'order' => 2, 'group' => 3),
	array('name' => "Staff Sergeant", 'short_name' => "SSG", 'order' => 3, 'group' => 3),
	array('name' => "Sergeant", 'short_name' => "SGT", 'order' => 4, 'group' => 3),
	array('name' => "Corporal", 'short_name' => "CPL", 'order' => 5, 'group' => 3),
	array('name' => "Private 1st Class", 'short_name' => "PFC", 'order' => 6, 'group' => 3),
	array('name' => "Private E-2", 'short_name' => "PV2", 'order' => 7, 'group' => 3),
	array('name' => "Private E-1", 'short_name' => "PV1", 'order' => 8, 'group' => 3),

	array('name' => "Gunnery Sergeant", 'short_name' => "GSG", 'order' => 2, 'group' => 4),
	array('name' => "Lance Corporal", 'short_name' => "LCP", 'order' => 6, 'group' => 4),
	array('name' => "Private 1st Class", 'short_name' => "PFC", 'order' => 7, 'group' => 4),
	array('name' => "Private", 'short_name' => "PV", 'order' => 8, 'group' => 4),

	array('name' => "Chief Master Sergeant", 'short_name' => "CMSGT", 'order' => 0, 'group' => 5),
	array('name' => "Senior Master Sergeant", 'short_name' => "SMSGT", 'order' => 1, 'group' => 5),
	array('name' => "Master Sergeant", 'short_name' => "MSGT", 'order' => 2, 'group' => 5),
	array('name' => "Technical Sergeant", 'short_name' => "TSGT", 'order' => 3, 'group' => 5),
	array('name' => "Staff Sergeant", 'short_name' => "SSGT", 'order' => 4, 'group' => 5),
	array('name' => "Senior Airman", 'short_name' => "SRA", 'order' => 5, 'group' => 5),
	array('name' => "Airman 1st Class", 'short_name' => "AFC", 'order' => 6, 'group' => 5),
	array('name' => "Airman", 'short_name' => "AMN", 'order' => 7, 'group' => 5),
	array('name' => "Airman Basic", 'short_name' => "AB", 'order' => 8, 'group' => 5),
);

$ranks = array(
	array('info_id' => 1, 'group_id' => 1, 'base' => 'a-a4'),
	array('info_id' => 2, 'group_id' => 1, 'base' => 'a-a3'),
	array('info_id' => 3, 'group_id' => 1, 'base' => 'a-a2'),
	array('info_id' => 4, 'group_id' => 1, 'base' => 'a-a1'),
	array('info_id' => 5, 'group_id' => 1, 'base' => 'a-o6'),
	array('info_id' => 6, 'group_id' => 1, 'base' => 'a-o5'),
	array('info_id' => 7, 'group_id' => 1, 'base' => 'a-o4'),
	array('info_id' => 8, 'group_id' => 1, 'base' => 'a-o3'),
	array('info_id' => 9, 'group_id' => 1, 'base' => 'a-o2'),
	array('info_id' => 10, 'group_id' => 1, 'base' => 'a-o1'),
	array('info_id' => 11, 'group_id' => 1, 'base' => 'a-e9'),
	array('info_id' => 12, 'group_id' => 1, 'base' => 'a-e8'),
	array('info_id' => 13, 'group_id' => 1, 'base' => 'a-e7'),
	array('info_id' => 14, 'group_id' => 1, 'base' => 'a-e6'),
	array('info_id' => 15, 'group_id' => 1, 'base' => 'a-e5'),
	array('info_id' => 16, 'group_id' => 1, 'base' => 'a-e4'),
	array('info_id' => 17, 'group_id' => 1, 'base' => 'a-e3'),
	array('info_id' => 18, 'group_id' => 1, 'base' => 'a-e2'),
	array('info_id' => 19, 'group_id' => 1, 'base' => 'a-e1'),

	array('info_id' => 1, 'group_id' => 2, 'base' => 'm-a4'),
	array('info_id' => 2, 'group_id' => 2, 'base' => 'm-a3'),
	array('info_id' => 3, 'group_id' => 2, 'base' => 'm-a2'),
	array('info_id' => 4, 'group_id' => 2, 'base' => 'm-a1'),
	array('info_id' => 5, 'group_id' => 2, 'base' => 'm-o6'),
	array('info_id' => 6, 'group_id' => 2, 'base' => 'm-o5'),
	array('info_id' => 7, 'group_id' => 2, 'base' => 'm-o4'),
	array('info_id' => 8, 'group_id' => 2, 'base' => 'm-o3'),
	array('info_id' => 9, 'group_id' => 2, 'base' => 'm-o2'),
	array('info_id' => 10, 'group_id' => 2, 'base' => 'm-o1'),
	array('info_id' => 11, 'group_id' => 2, 'base' => 'm-e9'),
	array('info_id' => 12, 'group_id' => 2, 'base' => 'm-e8'),
	array('info_id' => 20, 'group_id' => 2, 'base' => 'm-e7'),
	array('info_id' => 14, 'group_id' => 2, 'base' => 'm-e6'),
	array('info_id' => 15, 'group_id' => 2, 'base' => 'm-e5'),
	array('info_id' => 16, 'group_id' => 2, 'base' => 'm-e4'),
	array('info_id' => 21, 'group_id' => 2, 'base' => 'm-e3'),
	array('info_id' => 22, 'group_id' => 2, 'base' => 'm-e2'),
	array('info_id' => 23, 'group_id' => 2, 'base' => 'm-e1'),

	array('info_id' => 1, 'group_id' => 3, 'base' => 'af-a4'),
	array('info_id' => 2, 'group_id' => 3, 'base' => 'af-a3'),
	array('info_id' => 3, 'group_id' => 3, 'base' => 'af-a2'),
	array('info_id' => 4, 'group_id' => 3, 'base' => 'af-a1'),
	array('info_id' => 5, 'group_id' => 3, 'base' => 'af-o6'),
	array('info_id' => 6, 'group_id' => 3, 'base' => 'af-o5'),
	array('info_id' => 7, 'group_id' => 3, 'base' => 'af-o4'),
	array('info_id' => 8, 'group_id' => 3, 'base' => 'af-o3'),
	array('info_id' => 9, 'group_id' => 3, 'base' => 'af-o2'),
	array('info_id' => 10, 'group_id' => 3, 'base' => 'af-o1'),
	array('info_id' => 24, 'group_id' => 3, 'base' => 'af-e9'),
	array('info_id' => 25, 'group_id' => 3, 'base' => 'af-e8'),
	array('info_id' => 26, 'group_id' => 3, 'base' => 'af-e7'),
	array('info_id' => 27, 'group_id' => 3, 'base' => 'af-e6'),
	array('info_id' => 28, 'group_id' => 3, 'base' => 'af-e5'),
	array('info_id' => 29, 'group_id' => 3, 'base' => 'af-e4'),
	array('info_id' => 30, 'group_id' => 3, 'base' => 'af-e3'),
	array('info_id' => 31, 'group_id' => 3, 'base' => 'af-e2'),
	array('info_id' => 32, 'group_id' => 3, 'base' => 'af-e1'),
);

$positions = array(
	array(
		'name' => 'Commanding Officer',
		'desc' => "Ultimately responsible for the ship and crew, the Commanding Officer is the most senior officer aboard a vessel. S/he is responsible for carrying out the orders of the Generals above their position.",
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
		'name' => 'Chief Archaeologist',
		'desc' => "Studies people and cultures of off world planets.  Shares and discusses the human race with other cultures off world. In addition, they are in charge of the department and report to the Executive Officer. Is a member of the Senior Staff.",
		'dept_id' => 2,
		'order' => 0,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => 'Assistant Chief Archaeologist',
		'desc' => "Studies people and cultures of off world planets.  Shares and discusses the human race with other cultures off world. Also assists the Department head in daily operations.  If the Chief of the department is for some reason not able to perform his/her duties the Assistant Chief steps forwards as Acting Chief until the Chief returns.",
		'dept_id' => 2,
		'order' => 1,
		'open' => 1,
		'type' => 'officer'),
	array(
		'name' => 'Archaeologist',
		'desc' => "Studies people and cultures of off world planets.  Shares and discusses the human race with other cultures off world.",
		'dept_id' => 2,
		'order' => 2,
		'open' => 5,
		'type' => 'officer'),
		
	array(
		'name' => 'Chief of Linguistics',
		'desc' => "A person who speaks more than one language.  Most linguists specialize in languages.  The Linguist some times does more than English and one other languages. In addition, they are in charge of the department and reports to the Executive Officer.  Is a member of the Senior Staff.",
		'dept_id' => 3,
		'order' => 0,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => 'Assistant Chief of Linguistics',
		'desc' => "A person who speaks more than one language.  Most linguists specialize in languages.  The Linguist some times does more than English and one other languages. Also assists the Department head in daily operations.  If the Chief of the department is for some reason not able to perform his/her duties the Assistant Chief steps forwards as Acting Chief until the Chief returns.",
		'dept_id' => 3,
		'order' => 1,
		'open' => 1,
		'type' => 'officer'),
	array(
		'name' => 'Linguist',
		'desc' => "A person who speaks more than one language.  Most linguists specialize in languages.  The Linguist some times does more than English and one other languages.",
		'dept_id' => 3,
		'order' => 2,
		'open' => 5,
		'type' => 'officer'),
	
	array(
		'name' => 'Chief of Engineering',
		'desc' => "In charge of the department and reports to the Executive Officer.  Is a member of the Senior Staff.",
		'dept_id' => 4,
		'order' => 0,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => 'Assistant Chief of Engineering',
		'desc' => "Assists the Department head in daily operations.  If the Chief of the department is for some reason not able to perform his/her duties the Assistant Chief steps forwards as Acting Chief until the Chiefs return.",
		'dept_id' => 4,
		'order' => 1,
		'open' => 1,
		'type' => 'officer'),
	array(
		'name' => 'Chief of the Deck',
		'desc' => "The Chief of the deck is in charge of the deck crew.  He reports to the Chief of Engineering.",
		'dept_id' => 4,
		'order' => 2,
		'open' => 1,
		'type' => 'officer'),
	array(
		'name' => 'Engineering Specialist',
		'desc' => "",
		'dept_id' => 4,
		'order' => 3,
		'open' => 5,
		'type' => 'officer'),
	array(
		'name' => 'Deck Crew',
		'desc' => "A Deck crew member is your grease monkey.  They maintain, test, and check the X203s.",
		'dept_id' => 4,
		'order' => 4,
		'open' => 5,
		'type' => 'enlisted'),
	array(
		'name' => 'Stargate Specialist',
		'desc' => "A Stargate Specialist knows how to maintain and test the Stargate.  If the Stargate is not working they know the best means of trouble shooting.",
		'dept_id' => 4,
		'order' => 5,
		'open' => 5,
		'type' => 'officer'),
	array(
		'name' => 'DHD Specialist',
		'desc' => "The Dialer for the Stargate, the DHD is an ancient system that the humans rebuilt and made current to computers.  The DHD specialist knows how to troubleshoot and dial the DHD.",
		'dept_id' => 4,
		'order' => 6,
		'open' => 5,
		'type' => 'officer'),
	array(
		'name' => 'UAV/MALP Specialist',
		'desc' => "Before Stargate will send a team through they will send in a UAV (Unmanned Aerial Vehicle) or a MALP (Mobile Analytic Laboratory Probe) a wheeled robot.  The Specialist sends the device in and collects data and Intelligence for the team to use.",
		'dept_id' => 4,
		'order' => 7,
		'open' => 5,
		'type' => 'officer'),
	array(
		'name' => 'Communications Specialist',
		'desc' => "Responsible for all communication equipment the Communications Specialist can travel with the team or stay on base.  They report to the front lines of the field and can send information to the team and vise versa.",
		'dept_id' => 4,
		'order' => 8,
		'open' => 5,
		'type' => 'officer'),
		
	array(
		'name' => 'Chief of Science',
		'desc' => "In charge of the department and reports to the Executive Officer.  Is a member of the Senior Staff.",
		'dept_id' => 5,
		'order' => 0,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => 'Assistant Chief of Science',
		'desc' => "Assists the Department head in daily operations.  If the Chief of the department is for some reason not able to perform his/her duties the Assistant Chief steps forwards as Acting Chief until the Chief returns.",
		'dept_id' => 5,
		'order' => 1,
		'open' => 1,
		'type' => 'officer'),
	array(
		'name' => 'Botanist',
		'desc' => "Specializing in the study of plants the Botanist catalogs data of off world plants as with studies plants.",
		'dept_id' => 5,
		'order' => 2,
		'open' => 5,
		'type' => 'officer'),
	array(
		'name' => 'Geologist',
		'desc' => "Studies the liquid and matter that makes up off world planets.",
		'dept_id' => 5,
		'order' => 3,
		'open' => 5,
		'type' => 'officer'),
	array(
		'name' => 'Astrophysicist',
		'desc' => "They look up towards the stars. These specialist look at start maps and charts and try to figure out new places to travel.  They also keep the catalog up to date on past visited planets.",
		'dept_id' => 5,
		'order' => 4,
		'open' => 5,
		'type' => 'officer'),
		
	array(
		'name' => 'Chief of Medical',
		'desc' => "In charge of the department and reports to the Executive Officer.  Is a member of the Senior Staff.",
		'dept_id' => 6,
		'order' => 0,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => 'Assistant Chief of Medical',
		'desc' => "Assists the Department head in daily operations.  If the Chief of the department is for some reason not able to perform his/her duties the Assistant Chief steps forwards as Acting Chief until the Chief returns.",
		'dept_id' => 6,
		'order' => 1,
		'open' => 1,
		'type' => 'officer'),
	array(
		'name' => 'Physician',
		'desc' => "The Physician stays on the base in the infirmary and assists the Chief of Medical and the Assistant Chief.",
		'dept_id' => 6,
		'order' => 2,
		'open' => 5,
		'type' => 'officer'),
	array(
		'name' => 'Field Medic',
		'desc' => "Travels out into the field with the Stargate Teams.  The Field Medic is the expert in Emergency Medicine.",
		'dept_id' => 6,
		'order' => 3,
		'open' => 5,
		'type' => 'officer'),
		
	array(
		'name' => 'Chief of Diplomatics',
		'desc' => "In charge of the department and reports to the Executive Officer.  Is a member of the Senior Staff.",
		'dept_id' => 7,
		'order' => 0,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => 'Assistant Chief of Diplomatics',
		'desc' => "Assists the Department head in daily operations.  If the Chief of the department is for some reason not able to perform his/her duties the Assistant Chief steps forwards as Acting Chief until the Chief returns.",
		'dept_id' => 7,
		'order' => 1,
		'open' => 1,
		'type' => 'officer'),
	array(
		'name' => 'Base Diplomatic Liaison',
		'desc' => "The Base Diplomatic Liaison is a consultant for cultures coming to Earth. Base Diplomatic Liaisons consult with the American and other foreign countries to Earth.",
		'dept_id' => 7,
		'order' => 2,
		'open' => 5,
		'type' => 'other'),
	array(
		'name' => 'Off World Diplomatic Liaison',
		'desc' => "Representing Earth and Humans the Off world Diplomatic Liaison represents the team in a positive light.",
		'dept_id' => 7,
		'order' => 3,
		'open' => 5,
		'type' => 'other'),
		
	array(
		'name' => 'Squadron Leader',
		'desc' => "Is leader of the Fighter Squadron. Reports to the Executive Officer. Is a member of the Senior Staff.",
		'dept_id' => 8,
		'order' => 0,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => 'Squadron Pilot',
		'desc' => "A member of the Fighter Squadron. The fighter pilot reports the Squadron Leader.",
		'dept_id' => 8,
		'order' => 1,
		'open' => 6,
		'type' => 'officer'),
		
	array(
		'name' => 'Chief of Military',
		'desc' => "In charge of the department and reports to the Executive Officer. Is a member of the Senior Staff.",
		'dept_id' => 9,
		'order' => 0,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => 'Assistant Chief of Military',
		'desc' => "Assists the Department head in daily operations. If the Chief of the department is for some reason not able to perform his/her duties the Assistant Chief steps forwards as Acting Chief until the Chiefs return.",
		'dept_id' => 9,
		'order' => 1,
		'open' => 1,
		'type' => 'officer'),
	array(
		'name' => 'Weapons Specialist',
		'desc' => "The Weapons Specialist is the master of all weapons, US and foreign, and off world. They train in small and heavy weapons and assist others in weapons training.",
		'dept_id' => 9,
		'order' => 2,
		'open' => 5,
		'type' => 'officer'),
	array(
		'name' => 'Engineering Specialist',
		'desc' => "A very crucial member of the team is the Engineering Specialist is your demolitions man. Able to do land and underwater demolitions and navigation as with fortification and sabotage.",
		'dept_id' => 9,
		'order' => 3,
		'open' => 5,
		'type' => 'officer'),
	array(
		'name' => 'Infiltration Specialist',
		'desc' => "When you need to get in undetected the Infiltration can get him/herself and the team in. Sometimes the Infiltration specialist works alone and done specialized mission. While they can get in they can get out as well.  Expert in rescue operations as well s/he can get in and out of any area.",
		'dept_id' => 9,
		'order' => 4,
		'open' => 5,
		'type' => 'officer'),
);

$catalog_ranks = array(
	array(
		'name' => 'U.S. Military',
		'location' => 'default',
		'credits' => "The Stargate ranks used in Nova are the US Military sets created by James Arnhem. The rankset can be found at <a href='http://www.kuro-rpg.net' target='_blank'>Kuro-RPG</a>. Please do not copy or modify the images.",
		'default' => 1,
		'genre' => $g)
);