<?php
/**
 * Genre Install Data (SGA)
 *
 * @package		Install
 * @category	Assets
 * @author		Anodyne Productions
 */

/**
 * army - a
 * air force - af
 * marines - m
 */

$g = 'sga';

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
		'name' => 'Jumper Squadron',
		'desc' => "The Jumper Squadron is a fast travel to close place or can fly through the gate and be a means of travel for the team.",
		'order' => 7),
	array(
		'name' => 'Military',
		'desc' => "Your Military personnel in an SG Team are trained combat warriors from all branch all over the world.  In some times things get sticky and military is there to back it up with expert combat knowledge and firepower.",
		'order' => 8),
	array(
		'name' => 'Alpha Team',
		'desc' => "The Alpha Team of Atlantis.  Capable of carrying out missions and orders directed to them.",
		'order' => 9),
	array(
		'name' => 'Bravo Team',
		'desc' => "The Bravo Team of Atlantis.  Capable of carrying out missions and orders directed to them.",
		'order' => 10)
);

$ranks= array(
	array(
		'name' => 'General',
		'short_name' => 'GEN',
		'image' => 'a-a4',
		'order' => 0,
		'class' => 1),
	array(
		'name' => 'General',
		'short_name' => 'GEN',
		'image' => 'm-a4',
		'order' => 0,
		'class' => 2),
	array(
		'name' => 'General',
		'short_name' => 'GEN',
		'image' => 'af-a4',
		'order' => 0,
		'class' => 3),
		
	array(
		'name' => 'Lieutenant General',
		'short_name' => 'LTGEN',
		'image' => 'a-a3',
		'order' => 1,
		'class' => 1),
	array(
		'name' => 'Lieutenant General',
		'short_name' => 'LTGEN',
		'image' => 'm-a3',
		'order' => 1,
		'class' => 2),
	array(
		'name' => 'Lieutenant General',
		'short_name' => 'LTGEN',
		'image' => 'af-a3',
		'order' => 1,
		'class' => 3),
		
	array(
		'name' => 'Major General',
		'short_name' => 'MAJGEN',
		'image' => 'a-a2',
		'order' => 2,
		'class' => 1),
	array(
		'name' => 'Major General',
		'short_name' => 'MAJGEN',
		'image' => 'm-a2',
		'order' => 2,
		'class' => 2),
	array(
		'name' => 'Major General',
		'short_name' => 'MAJGEN',
		'image' => 'af-a2',
		'order' => 2,
		'class' => 3),
		
	array(
		'name' => 'Brigadier General',
		'short_name' => 'BRGGEN',
		'image' => 'a-a1',
		'order' => 3,
		'class' => 1),
	array(
		'name' => 'Brigadier General',
		'short_name' => 'BRGGEN',
		'image' => 'm-a1',
		'order' => 3,
		'class' => 2),
	array(
		'name' => 'Brigadier General',
		'short_name' => 'BRGGEN',
		'image' => 'af-a1',
		'order' => 3,
		'class' => 3),
		
	array(
		'name' => 'Colonel',
		'short_name' => 'COL',
		'image' => 'a-o6',
		'order' => 4,
		'class' => 1),
	array(
		'name' => 'Colonel',
		'short_name' => 'COL',
		'image' => 'm-o6',
		'order' => 4,
		'class' => 2),
	array(
		'name' => 'Colonel',
		'short_name' => 'COL',
		'image' => 'af-o6',
		'order' => 4,
		'class' => 3),
		
	array(
		'name' => 'Lieutenant Colonel',
		'short_name' => 'LTCOL',
		'image' => 'a-o5',
		'order' => 5,
		'class' => 1),
	array(
		'name' => 'Lieutenant Colonel',
		'short_name' => 'LTCOL',
		'image' => 'm-o5',
		'order' => 5,
		'class' => 2),
	array(
		'name' => 'Lieutenant Colonel',
		'short_name' => 'LTCOL',
		'image' => 'af-o5',
		'order' => 5,
		'class' => 3),
		
	array(
		'name' => 'Major',
		'short_name' => 'MAJ',
		'image' => 'a-o4',
		'order' => 6,
		'class' => 1),
	array(
		'name' => 'Major',
		'short_name' => 'MAJ',
		'image' => 'm-o4',
		'order' => 6,
		'class' => 2),
	array(
		'name' => 'Major',
		'short_name' => 'MAJ',
		'image' => 'af-o4',
		'order' => 6,
		'class' => 3),
		
	array(
		'name' => 'Captain',
		'short_name' => 'CAPT',
		'image' => 'a-o3',
		'order' => 7,
		'class' => 1),
	array(
		'name' => 'Captain',
		'short_name' => 'CAPT',
		'image' => 'm-o3',
		'order' => 7,
		'class' => 2),
	array(
		'name' => 'Captain',
		'short_name' => 'CAPT',
		'image' => 'af-o3',
		'order' => 7,
		'class' => 3),
		
	array(
		'name' => '1st Lieutenant',
		'short_name' => '1LT',
		'image' => 'a-o2',
		'order' => 8,
		'class' => 1),
	array(
		'name' => '1st Lieutenant',
		'short_name' => '1LT',
		'image' => 'm-o2',
		'order' => 8,
		'class' => 2),
	array(
		'name' => '1st Lieutenant',
		'short_name' => '1LT',
		'image' => 'af-o2',
		'order' => 8,
		'class' => 3),
		
	array(
		'name' => '2nd Lieutenant',
		'short_name' => '2LT',
		'image' => 'a-o1',
		'order' => 9,
		'class' => 1),
	array(
		'name' => '2nd Lieutenant',
		'short_name' => '2LT',
		'image' => 'm-o1',
		'order' => 9,
		'class' => 2),
	array(
		'name' => '2nd Lieutenant',
		'short_name' => '2LT',
		'image' => 'af-o1',
		'order' => 9,
		'class' => 3),
		
	array(
		'name' => 'Sergeant Major',
		'short_name' => 'SGTMAJ',
		'image' => 'a-e9',
		'order' => 10,
		'class' => 1),
	array(
		'name' => 'Master Gunnery Sergeant',
		'short_name' => 'MSTGSGT',
		'image' => 'm-e9',
		'order' => 10,
		'class' => 2),
	array(
		'name' => 'Chief Master Sergeant',
		'short_name' => 'CMSGT',
		'image' => 'af-e9',
		'order' => 10,
		'class' => 3),
		
	array(
		'name' => 'Master Sergeant',
		'short_name' => 'MSTSGT',
		'image' => 'a-e8',
		'order' => 11,
		'class' => 1),
	array(
		'name' => 'Master Sergeant',
		'short_name' => 'MSTSGT',
		'image' => 'm-e8',
		'order' => 11,
		'class' => 2),
	array(
		'name' => 'Senior Master Sergeant',
		'short_name' => 'SRMSGT',
		'image' => 'af-e8',
		'order' => 11,
		'class' => 3),
		
	array(
		'name' => 'Sergeant 1st Class',
		'short_name' => 'SGT1',
		'image' => 'a-e7',
		'order' => 12,
		'class' => 1),
	array(
		'name' => 'Gunnery Sergeant',
		'short_name' => 'GNYSGT',
		'image' => 'm-e7',
		'order' => 12,
		'class' => 2),
	array(
		'name' => 'Master Sergeant',
		'short_name' => 'MSTSGT',
		'image' => 'af-e7',
		'order' => 12,
		'class' => 3),
		
	array(
		'name' => 'Staff Sergeant',
		'short_name' => 'SSGT',
		'image' => 'a-e6',
		'order' => 13,
		'class' => 1),
	array(
		'name' => 'Staff Sergeant',
		'short_name' => 'SSGT',
		'image' => 'm-e6',
		'order' => 13,
		'class' => 2),
	array(
		'name' => 'Technical Sergeant',
		'short_name' => 'TSGT',
		'image' => 'af-e6',
		'order' => 13,
		'class' => 3),
		
	array(
		'name' => 'Sergeant',
		'short_name' => 'SGT',
		'image' => 'a-e5',
		'order' => 14,
		'class' => 1),
	array(
		'name' => 'Sergeant',
		'short_name' => 'SGT',
		'image' => 'm-e5',
		'order' => 14,
		'class' => 2),
	array(
		'name' => 'Staff Sergeant',
		'short_name' => 'SSGT',
		'image' => 'af-e5',
		'order' => 14,
		'class' => 3),
		
	array(
		'name' => 'Corporal',
		'short_name' => 'CPL',
		'image' => 'a-e4',
		'order' => 15,
		'class' => 1),
	array(
		'name' => 'Corporal',
		'short_name' => 'CPL',
		'image' => 'm-e4',
		'order' => 15,
		'class' => 2),
	array(
		'name' => 'Sergeant',
		'short_name' => 'SGT',
		'image' => 'af-e4',
		'order' => 15,
		'class' => 3),
		
	array(
		'name' => 'Private 1st Class',
		'short_name' => 'PVT1',
		'image' => 'a-e3',
		'order' => 16,
		'class' => 1),
	array(
		'name' => 'Lance Corporal',
		'short_name' => 'LCPL',
		'image' => 'm-e3',
		'order' => 16,
		'class' => 2),
	array(
		'name' => 'Airman 1st Class',
		'short_name' => 'ARM1',
		'image' => 'af-e3',
		'order' => 16,
		'class' => 3),
		
	array(
		'name' => 'Private',
		'short_name' => 'PVT',
		'image' => 'a-e2',
		'order' => 17,
		'class' => 1),
	array(
		'name' => 'Private 1st Class',
		'short_name' => 'PVT1',
		'image' => 'm-e2',
		'order' => 17,
		'class' => 2),
	array(
		'name' => 'Airman',
		'short_name' => 'ARM',
		'image' => 'af-e2',
		'order' => 17,
		'class' => 3),
		
	array(
		'name' => 'Private',
		'short_name' => 'PVT',
		'image' => 'a-e1',
		'order' => 18,
		'class' => 1),
	array(
		'name' => 'Private',
		'short_name' => 'PVT',
		'image' => 'm-e1',
		'order' => 18,
		'class' => 2),
	array(
		'name' => 'Airman Basic',
		'short_name' => 'ARMB',
		'image' => 'af-e1',
		'order' => 18,
		'class' => 3),
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
		'desc' => "A Deck crew member is your grease monkey.  They maintain, test, and check the Jumpers.",
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
		'desc' => "The Base Diplomatic Liaison is a consultant for cultures coming to Atlantis. Base Diplomatic Liaisons consult with the American and other foreign countries to Earth.",
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
		'desc' => "Is leader of the Jumper Squadron Air lift team. Reports to the Executive Officer. Is a member of the Senior Staff.",
		'dept_id' => 8,
		'order' => 0,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => 'Squadron Pilot',
		'desc' => "A member of the Jumper Squadron. The Jumper pilot reports the Squadron Leader.",
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
