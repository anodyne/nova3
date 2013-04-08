<?php
/**
 * Genre Install Data (CRD)
 *
 * @package		Nova
 * @subpackage	Setup
 * @category	Asset
 * @author		Anodyne Productions
 * @author		Hasahnaithiau Nghymru
 * @copyright	2013 Anodyne Productions
 */

$g = 'crd';

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
		'desc' => "All positions in this department are singular.  The Commanding Officer of the vessel is always a member of the Space Forces, unless the vessel serves as the Lead Ship of an Order, then the Commanding Officer can be a member of the Militia. Members of the Command Staff do not hold any other responsibilities on board the vessel.",
		'order' => 0),
	array(
		'name' => 'Ship Control',
		'desc' => "Also known as a Helm Officer, one must always be present in operations of the vessel, and every vessel has a number of Space Control Officers to allow shift rotations. They plot courses, supervises the computers piloting, corrects any flight deviations and pilots the ship manually when needed.",
		'order' => 1),
	array(
		'name' => 'Engineering &amp; Maintenance',
		'desc' => "Responsibility of ensuring that ship functions, such as the use of the lateral sensor array, do not interfere with one and another. They must prioritize resource allocations, so that the most critical activities can have every chance of success. If so required, they can curtail shipboard functions if they thinks they will interfere with the ship's current mission or routine operations. responsible for the condition of all systems and equipment on board the ship. They oversee maintenance, repairs and upgrades of all equipment. They control the output and maintain the operational status of the Warp Core. They also responsible for the many repairs teams during crisis situations.",
		'order' => 2),
	array(
		'name' => 'Communications Control',
		'desc' => "Monitors any and all transmissions aboard the ship, as well as externally. Communications Officers are experienced linguist, proficient in many different languages.",
		'order' => 3),
	array(
		'name' => 'Warfare',
		'desc' => "They are the vessels gunman and security. They responsible for the ships weapon system, and is also the COs tactical advisor in Star Ship Combat matters. Very often Warfare Officers are also trained in ground combat and small unit tactics. There is much more to Warfare than simply overseeing the weapons console on the bridge. Warfare maintains the weapons systems aboard the ship, maintaining and reloading photons magazines. Tactical planning and current Intelligence analysis (if no Intelligence operatives are aboard) and manning all secure areas of the vessel.",
		'order' => 4),
	array(
		'name' => 'Militia Infantry',
		'desc' => "It is their duty is to ensure the safety of ship and crew. The Infantry Commander takes it as their personal duty to protect the Commanding Officer on landing parties. They are also responsible for people under arrest and the safety of guests, liked or not. They are also required to take command of any special ground operations.",
		'order' => 5),
	array(
		'name' => 'Science Staff',
		'desc' => "Responsible for all the scientific data the vessel collects, and the distribution of such data to specific section amongst the staff for study. Scientists are seen with something bordering on contempt within the Cardassian Union, and are seen by the Central Command to serve one purpose; for the benefit of the military.  Members of the Science Staff are not technically members of either the Space Forces or the Militia, but are part of the Military but rather the Military Sciencetific Order, and are seen as seconded to a particular Order/Vessel.  Due to the specialist nature of the department, everyone within the Sciences has carried out their required Military Service, and has elected to continue within the Military and specialized in sciences.  Due to the gender biased within the Cardassian Union, the majority of Scientists appear to be female.",
		'order' => 6),
	array(
		'name' => 'Medical Staff',
		'desc' => "Responsible for the physical health of the entire crew, but does more than patch up injured crew members. Their function is to ensure that they do not get sick or injured to begin with, and to this end monitors their health and conditioning with regular check ups. Unlike a Starfleet vessel a Cardassian Doctor cannot relieve the vessel's Commander of duty. Besides this they available to provide medical advice to any individual who requests it. As with the Sciences, the Medical Staff are not members of the Space Forces or Militia, but rather are members of the Military Medical Order and are seen as on seconded duty with the particular Order of the vessel on which they serve.",
		'order' => 7),
	array(
		'name' => 'Political Staff',
		'desc' => "This department is of an oddity of the Cardassian Union.  The entire purpose of this department is to ensure that the vessel and her crew follow the will of the Central Command at all times.  Duty to the state is something that is programmed into the Cardassian psyche, and the Political Staff ensure they follow this programming.  As with the Sciences and Medical Staff members of the Political Staff are neither Space Force nor Militia Officers, but rather are directly answerable to the Central Command. In situations of First Contact or meetings with Alien species, a Political Officer can supersede the vessel's Commanding Officer is s/he believes that the Commanding Officer is not doing what is best for the Union or the Central Command. They are seen as a nasty necessity to life serving the Union.",
		'order' => 8),
	array(
		'name' => '5th Order',
		'desc' => "The Fifth Order, also known as the 'Jade Order' (Cairhail Terapha), comprises the Central Command's military intelligence division. Central Command maintains the Fifth Order so it does not have to depend entirely on the Obsidian Order for military intelligence. The Jade Order is far smaller than the Obsidian Order, and has a fierce rivalry with its larger 'civilian' competitor. As with the above departments, the Officers of the Jade Order are not considered Space Forces or Militia, but are rather on seconded duty to the particular order of the vessel on which they serve.",
		'order' => 9),
	array(
		'name' => 'Logistics',
		'desc' => "The logistics department keeps track of all matters coming in and off the vessel, also when carrying out private freight the Logistics Officer along with the Commanding Officer takes a percentage of any profit for doing so.",
		'order' => 10)
);

$groups = array(
	array('name' => 'Admiralty', 'order' => 0),
	array('name' => 'Officers', 'order' => 1),
	array('name' => 'Enlisted', 'order' => 2),
);

$info = array(
	array('name' => "Legate (3rd Order)", 'short_name' => "LEG", 'order' => 0, 'group' => 1),
	array('name' => "Legate (2nd Order)", 'short_name' => "LEG", 'order' => 1, 'group' => 1),
	array('name' => "Legate (1st Order)", 'short_name' => "LEG", 'order' => 2, 'group' => 1),
	array('name' => "Jagual", 'short_name' => "JAG", 'order' => 3, 'group' => 1),

	array('name' => "Gul", 'short_name' => "GUL", 'order' => 0, 'group' => 2),
	array('name' => "Glinn", 'short_name' => "GLI", 'order' => 1, 'group' => 2),
	array('name' => "Kel", 'short_name' => "KEL", 'order' => 2, 'group' => 2),
	array('name' => "Gil", 'short_name' => "GIL", 'order' => 3, 'group' => 2),
	array('name' => "Dalin", 'short_name' => "DAL", 'order' => 4, 'group' => 2),
	array('name' => "Riyak", 'short_name' => "RIY", 'order' => 5, 'group' => 2),

	array('name' => "Ragoc", 'short_name' => "RAG", 'order' => 0, 'group' => 3),
	array('name' => "Gor", 'short_name' => "GOR", 'order' => 1, 'group' => 3),
	array('name' => "Garhec", 'short_name' => "GAR", 'order' => 2, 'group' => 3),
);

$ranks = array(
	array('info_id' => 1, 'group_id' => 1, 'base' => 'a4'),
	array('info_id' => 2, 'group_id' => 1, 'base' => 'a3'),
	array('info_id' => 3, 'group_id' => 1, 'base' => 'a2'),
	array('info_id' => 4, 'group_id' => 1, 'base' => 'a1'),
	array('info_id' => 5, 'group_id' => 2, 'base' => 'o6'),
	array('info_id' => 6, 'group_id' => 2, 'base' => 'o5'),
	array('info_id' => 7, 'group_id' => 2, 'base' => 'o4'),
	array('info_id' => 8, 'group_id' => 2, 'base' => 'o3'),
	array('info_id' => 9, 'group_id' => 2, 'base' => 'o2'),
	array('info_id' => 10, 'group_id' => 2, 'base' => 'o1'),
	array('info_id' => 11, 'group_id' => 3, 'base' => 'e3'),
	array('info_id' => 12, 'group_id' => 3, 'base' => 'e2'),
	array('info_id' => 13, 'group_id' => 3, 'base' => 'e1'),
);

$positions = array(
	array(
		'name' => 'Commanding Officer',
		'desc' => "A stand alone position. Either an experienced Space Forces Officer or a Militia Officer with a high level of vesala.",
		'dept_id' => 1,
		'order' => 0,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => 'Deputy Commanding Officer',
		'desc' => "The second highest Officer on board the vessel, an experienced Officer, and does not necessarily have to be a Space Forces Officer.  Responsible for over-seeing a specific group of staff along with the ADCO.",
		'dept_id' => 1,
		'order' => 1,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => 'Assistant Deputy Commanding Officer',
		'desc' => "The third highest ranking/experienced officer on board the vessel.  Responsible for over-seeing a specific group of staff along with the DCO.",
		'dept_id' => 1,
		'order' => 2,
		'open' => 1,
		'type' => 'senior'),
	
	array(
		'name' => 'Head of Ship Control',
		'desc' => "The most senior Pilot and Navigator on board the vessel.  An expert in all aspects of flight control and spacial navigation.",
		'dept_id' => 2,
		'order' => 0,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => 'Deputy Head of Ship Control',
		'desc' => "The second most senior Pilots and Navigators on board the vessel.  An expert in all aspects of flight control and spacial navigation.",
		'dept_id' => 2,
		'order' => 1,
		'open' => 1,
		'type' => 'officer'),
	array(
		'name' => 'Assistant Deputy Head of Ship Control',
		'desc' => "An expert in all aspects of flight control and spacial navigation.",
		'dept_id' => 2,
		'order' => 2,
		'open' => 1,
		'type' => 'officer'),
	array(
		'name' => 'Pilot',
		'desc' => "An experienced Pilot.",
		'dept_id' => 2,
		'order' => 3,
		'open' => 4,
		'type' => 'officer'),
	array(
		'name' => 'Navigator',
		'desc' => "An experienced Navigator.",
		'dept_id' => 2,
		'order' => 4,
		'open' => 4,
		'type' => 'officer'),
		
	array(
		'name' => 'Head of Engineering &amp; Maintenance',
		'desc' => "The most senior Engineer on board the vessel.  An expert in all aspects of vessel systems operations.",
		'dept_id' => 3,
		'order' => 0,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => 'Deputy Head of Engineering &amp; Maintenance',
		'desc' => "The second most senior Engineer on board the vessel.  An expert in all aspects of vessel systems operations.",
		'dept_id' => 3,
		'order' => 1,
		'open' => 1,
		'type' => 'officer'),
	array(
		'name' => 'Assistant Deputy Head of Engineering &amp; Maintenance',
		'desc' => "An expert in all aspects of vessel systems operations.",
		'dept_id' => 3,
		'order' => 2,
		'open' => 1,
		'type' => 'officer'),
	array(
		'name' => 'Engineer',
		'desc' => "An experienced Engineer.",
		'dept_id' => 3,
		'order' => 3,
		'open' => 8,
		'type' => 'officer'),
		
	array(
		'name' => 'Head of Communications',
		'desc' => "The most senior Linguist on board the vessel.  An expert in over 20 languages, and in all Communications equipment.",
		'dept_id' => 4,
		'order' => 0,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => 'Deputy Head of Communications',
		'desc' => "The second most senior Linguist on board the vessel.  An expert in over 10 languages, and in all Communications equipment.",
		'dept_id' => 4,
		'order' => 1,
		'open' => 1,
		'type' => 'officer'),
	array(
		'name' => 'Assistant Deputy Head of Communications',
		'desc' => "An expert in over 10 languages and Communications equipment.",
		'dept_id' => 4,
		'order' => 2,
		'open' => 1,
		'type' => 'officer'),
	array(
		'name' => 'Communications Officer',
		'desc' => "An experienced linguist with knowledge in Communications equipment.",
		'dept_id' => 4,
		'order' => 3,
		'open' => 8,
		'type' => 'officer'),
		
	array(
		'name' => 'Head of Warfare',
		'desc' => "The most seasoned and experienced weapons and tactical expert aboard the vessel, as well as stratetician, who ensures the safety of the vessel from external forces via usage of weapons.  Also maintains all weapons on board the vessel.",
		'dept_id' => 5,
		'order' => 0,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => 'Deputy Head of Warfare',
		'desc' => "A seasoned and experienced weapons and tactical expert, as well as stratetician, who ensures the safety of the vessel from external forces via usage of weapons.  Also maintains all weapons on board the vessel.",
		'dept_id' => 5,
		'order' => 1,
		'open' => 1,
		'type' => 'officer'),
	array(
		'name' => 'Assistant Deputy Head of Warfare',
		'desc' => "An experienced weapons and tactical expert, as well as stratetician, who ensures the safety of the vessel from external forces via usage of weapons.  Also maintains all weapons on board the vessel.",
		'dept_id' => 5,
		'order' => 2,
		'open' => 1,
		'type' => 'officer'),
	array(
		'name' => 'Warfare Officer',
		'desc' => "An experienced weapons and tactical officer.",
		'dept_id' => 5,
		'order' => 3,
		'open' => 8,
		'type' => 'officer'),
		
	array(
		'name' => 'Infantry Commander',
		'desc' => "The Infantry Commander is responsible for the infantry forces on the ship/base. They oversee any and all matters related to their units, including tactical strategy in concert with the Commanding Officer. Works with other members of his/her team to ensure the infantry forces are ready to be deployed at a moment's notice. Reports to the Commanding Officer.",
		'dept_id' => 6,
		'order' => 0,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => 'Infantry Second-in-Command',
		'desc' => "Responsible for overseeing the infantry forces on a ship/base. Works in tandem with the Infantry Commander to ensure their forces are ready to deployed at a moment's notice. Reports to the Infantry Commander.",
		'dept_id' => 6,
		'order' => 1,
		'open' => 1,
		'type' => 'officer'),
	array(
		'name' => 'Infantry Third-in-Command',
		'desc' => "Responsible for overseeing the enlisted division of a ship/base's infantry complement. Reports to the Infantry Commander.",
		'dept_id' => 6,
		'order' => 2,
		'open' => 1,
		'type' => 'officer'),
	array(
		'name' => 'Infantry Soldier',
		'desc' => "The lifeblood of the Infantry, soldiers make up the units stationed on ships and bases. Reports to the Infantry Commander.",
		'dept_id' => 6,
		'order' => 3,
		'open' => 20,
		'type' => 'officer'),
	
	array(
		'name' => 'Head of Sciences',
		'desc' => "The most senior Scientist on board the vessel.  An expert in several specialist fields of scientific research.",
		'dept_id' => 7,
		'order' => 0,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => 'Deputy Head of Sciences',
		'desc' => "The second most senior Scientist on board the vessel.  Primarily deals with the day to day running of the Department, allowing the Head of Sciences to carry out their research projects.",
		'dept_id' => 7,
		'order' => 1,
		'open' => 1,
		'type' => 'officer'),
	array(
		'name' => 'Assistant Deputy Head of Sciences',
		'desc' => "The third most senior Scientist on board the vessel.  Usually an expert in on specialist field of study, but also an experienced generalist to be able to deal and understand all information they gather.",
		'dept_id' => 7,
		'order' => 2,
		'open' => 1,
		'type' => 'officer'),
	array(
		'name' => 'Scientist',
		'desc' => "A Generalist Scientist on board the vessel. They are not yet considered to be an expert in any one particular field of scientific research, but considered well versed in the many fields of scientific research to carry out solo study.",
		'dept_id' => 7,
		'order' => 3,
		'open' => 5,
		'type' => 'officer'),
		
	array(
		'name' => 'Head of Medicine &amp; Surgery',
		'desc' => "The most Senior Doctor on board the vessel, considered to be an expert in the both Medicine and Surgery.",
		'dept_id' => 8,
		'order' => 0,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => 'Deputy Head of Medicine &amp; Surgery',
		'desc' => "The second most senior Doctor on the vessel.  Experienced in both Medicine and Surgery.",
		'dept_id' => 8,
		'order' => 1,
		'open' => 1,
		'type' => 'officer'),
	array(
		'name' => 'Assistant Deputy Head of Medicine &amp; Surgery',
		'desc' => "The third most senior Doctor on the vessel.  Experienced in both Medicine and Surgery.",
		'dept_id' => 8,
		'order' => 2,
		'open' => 1,
		'type' => 'officer'),
	array(
		'name' => 'Doctor',
		'desc' => "An experienced doctor with expertise in either Medicine or Surgery. In most cases, unlike the senior officers, they will not be experienced in all medical matters.",
		'dept_id' => 8,
		'order' => 3,
		'open' => 4,
		'type' => 'officer'),
	array(
		'name' => 'Medical Orderly',
		'desc' => "They carry out the roles of Nurses and assistants to the Doctors.",
		'dept_id' => 8,
		'order' => 4,
		'open' => 8,
		'type' => 'enlisted'),
		
	array(
		'name' => 'Political Officer',
		'desc' => "The eyes and ears of the Central Command and Detapa Council on board the vessel, generally it is assumed all Political Officers also serve the Obsidian Order.",
		'dept_id' => 9,
		'order' => 0,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => 'Political Aide',
		'desc' => "The eyes and ears of the Central Command and Detapa Council on board the vessel that work with the Political Officer. Generally, it is assumed all Political Aides also serve the Obsidian Order.",
		'dept_id' => 9,
		'order' => 1,
		'open' => 1,
		'type' => 'enlisted'),
		
	array(
		'name' => 'Head Jade Officer',
		'desc' => "Ensures all intelligence the vessel gathers is relayed to Central Command, as well as all pertinent information from the Jade Order and Central Command is given to the Commanding Officer.",
		'dept_id' => 10,
		'order' => 0,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => 'Deputy Head Jade Officer',
		'desc' => "Ensures all intelligence the vessel gathers is relayed to Central Command, as well as all pertinent information from the Jade Order and Central Command is given to the Commanding Officer. Reports to the Head Jade Officer.",
		'dept_id' => 10,
		'order' => 1,
		'open' => 1,
		'type' => 'officer'),
		
	array(
		'name' => 'Head of Logistics',
		'desc' => "The Head of Logistics is responsible for keeping track of all matters coming in and off the vessel. A nuanced position, the Head of Logistics also coordinates carrying out private freight, a task which they take a percentage of profits (along with the Commanding Officer) for doing so.",
		'dept_id' => 11,
		'order' => 0,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => 'Deputy Head of Logistics',
		'desc' => "The Deputy Head of Logistics is responsible for helping to keep track of all matters coming in and off the vessel. Reports to the Head of Logistics.",
		'dept_id' => 11,
		'order' => 1,
		'open' => 1,
		'type' => 'officer'),
	array(
		'name' => 'Assistant Deputy Head of Logistics',
		'desc' => "Assists the Deputy Head of Logistics for tracking all matters coming in and off the vessel.",
		'dept_id' => 11,
		'order' => 2,
		'open' => 1,
		'type' => 'officer'),
	array(
		'name' => 'Logistics Officer',
		'desc' => "Tracks all matters coming in and off the vessel along with the other members of the Logistics department.",
		'dept_id' => 11,
		'order' => 3,
		'open' => 8,
		'type' => 'officer')
);

$catalog_ranks = array(
	array(
		'name' => 'Duty Uniform',
		'location' => 'default',
		'credits' => "The Cardassian rank sets used in Nova were created by Kuro-chan of Kuro-RPG. The ranksets can be found at <a href='http://www.kuro-rpg.net' target='_blank'>Kuro-RPG</a>. Please do not copy or modify the images.",
		'default' => 1,
		'genre' => $g)
);