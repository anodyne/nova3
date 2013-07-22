<?php
/**
 * Genre Install Data (ROM)
 *
 * @package		Nova
 * @subpackage	Setup
 * @category	Asset
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */

$g = 'rom';

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
		'desc' => "As on most space-faring vessels the Command Department is made up of those officers deemed to be in the day-to-day control of the Warbird.  The Apart from the Commanding Officer, other members of the Command Staff also serve in other faculties/ departments.",
		'order' => 0),
	array(
		'name' => 'Scientific Research',
		'desc' => "Responsible for all the scientific data the warbird collects, and the distribution of such data to specific section within the department for analysis. They are also responsible with providing the ship's captain with scientific information needed for command decisions.",
		'order' => 1),
	array(
		'name' => 'Medical Sciences',
		'desc' => "Responsible for the physical health of the entire crew, but does more than patch up injured crew members. Their function is to ensure that they do not get sick or injured to begin with, and to this end monitors their health and conditioning with regular check ups. If necessary, the Leader of Medical Sciences can remove anyone from duty, excluding the Commander. Besides this they available to provide medical advice to any individual who requests it. Additionally the Seniors of the 3 bracnhes of Medical Sciences as well as the Leader of the Department are also responsible for all aspect of the medical deck, such as the Medical labs, Surgical suites, Psychiatric treatment areas.",
		'order' => 2),
	array(
		'name' => 'Research &amp; Development',
		'desc' => "This department is of an oddity only found within the Romulan Star Empire.  The entire purpose of this department is to take alien technology (e.g. Starfleet) and backwards engineer it and to create something similiar to the original but allowing it to be compatible with other Romulan Technologies.",
		'order' => 3),
	array(
		'name' => 'Flight Control',
		'desc' => "A Flight Controller must always be present on the bridge of a starship, and every vessel has a number of Flight Control Officers to allow shift rotations. They plot courses, supervises the computers piloting, corrects any flight deviations and pilots the ship manually when needed.",
		'order' => 4),
	array(
		'name' => 'Warbird Control',
		'desc' => "Responsibility of ensuring that ship functions, such as the use of the lateral sensor array, do not interfere with one and another. They must prioritize resource allocations, so that the most critical activities can have every chance of success. If so required, they can curtail shipboard functions if they thinks they will interfere with the ship's current mission or routine operations.",
		'order' => 5),
	array(
		'name' => 'Singularity Control',
		'desc' => "Responsible for the condition of all systems and equipment on board the Warbird. They oversee maintenance, repairs and upgrades of all equipment. They control the output and maintain the operational status of the Singularity Drive. They also responsible for the many repairs teams during crisis situations.",
		'order' => 6),
	array(
		'name' => 'Cloaking Control',
		'desc' => "Responsible for the smooth operation of the Cloaking Device and other related systems, unlike other Control departments, Cloaking Control is a very small department, with members usually having served for many tours within an Singularity Control Department, and then undergoing specialist Cloaking Technology Training Programmes. The department only contains 3 staff members.",
		'order' => 7),
	array(
		'name' => 'Communications Control',
		'desc' => "Monitors any and all transmissions aboard the warbird, as well as externally. Communications Officers are experienced linguist, proficient in many different languages.",
		'order' => 8),
	array(
		'name' => 'Weapons Control',
		'desc' => "They are the vessels gunman.They responsible for the ships weapon system, and is also the COs tactical advisor in Star Ship Combat matters. Very often Weapons Officers are also trained in ground combat and small unit tactics. There is much more to Weapons Control than simply overseeing the weapons console on the bridge. Weapons Control maintains the weapons systems aboard the warbird, maintaining and reloading photons magazines. Tactical planning and current Intelligence analysis (if no Intelligence operatives are aboard) is also overseen by the tactical department.",
		'order' => 9),
	array(
		'name' => 'Tal Diann',
		'desc' => "Responsible for collected and collating all information that they deem appropriate for delivery to the Command Staff.  Unlike most departments the Tal Diann are considered a seperate force within the Galae in the same manner as the Tal Shi'ar.  They are often at odds with the Tal Shi'ar Agent on-board the warbird.",
		'order' => 10),
	array(
		'name' => 'Reman Commando Corps',
		'desc' => "It is their duty is to ensure the safety of ship and crew. The Commando Commander takes it as their personal duty to protect the Commanding Officer on landing parties. They are also responsible for people under arrest and the safety of guests, liked or not. They are also required to take command of any special ground operations. The Reman Commando Corps is the only branch of the Galae to have an enlisted service.  The RCC is always controlled by Galae Officers, but the rank and file is made up of Remans who are considered too inferior to hold a commissioned rank.",
		'order' => 11)
);

$groups = array(
	array('name' => 'Romulan Star Navy', 'order' => 0),
	array('name' => 'Tal Shiar', 'order' => 1),
);

$info = array(
	array('name' => "Admiral", 'short_name' => "ADM", 'order' => 0, 'group' => 1),
	array('name' => "Commodore", 'short_name' => "COMO", 'order' => 1, 'group' => 1),
	array('name' => "Commander", 'short_name' => "CMDR", 'order' => 2, 'group' => 1),
	array('name' => "Sub-Commander", 'short_name' => "SCMDR", 'order' => 3, 'group' => 1),
	array('name' => "Centurion", 'short_name' => "CENT", 'order' => 4, 'group' => 1),
	array('name' => "Lieutenant", 'short_name' => "LT", 'order' => 5, 'group' => 1),
	array('name' => "Sub-Lieutenant", 'short_name' => "SLT", 'order' => 6, 'group' => 1),
	array('name' => "Uhlan", 'short_name' => "UHL", 'order' => 7, 'group' => 1),

	array('name' => "General", 'short_name' => "GEN", 'order' => 0, 'group' => 2),
	array('name' => "Sub-General", 'short_name' => "SGEN", 'order' => 1, 'group' => 2),
	array('name' => "Colonel", 'short_name' => "COL", 'order' => 2, 'group' => 2),
	array('name' => "Sub-Colonel", 'short_name' => "SCOL", 'order' => 3, 'group' => 2),
	array('name' => "Major", 'short_name' => "MAJ", 'order' => 4, 'group' => 2),
	array('name' => "Captain", 'short_name' => "CAPT", 'order' => 5, 'group' => 2),
	array('name' => "Lieutenant", 'short_name' => "LT", 'order' => 6, 'group' => 2),
);

$ranks = array(
	array('info_id' => 1, 'group_id' => 1, 'base' => 's-o8'),
	array('info_id' => 2, 'group_id' => 1, 'base' => 's-o7'),
	array('info_id' => 3, 'group_id' => 1, 'base' => 's-o6'),
	array('info_id' => 4, 'group_id' => 1, 'base' => 's-o5'),
	array('info_id' => 5, 'group_id' => 1, 'base' => 's-o4'),
	array('info_id' => 6, 'group_id' => 1, 'base' => 's-o3'),
	array('info_id' => 7, 'group_id' => 1, 'base' => 's-o2'),
	array('info_id' => 8, 'group_id' => 1, 'base' => 's-o1'),

	array('info_id' => 9, 'group_id' => 2, 'base' => 'g-o8'),
	array('info_id' => 10, 'group_id' => 2, 'base' => 'g-o7'),
	array('info_id' => 11, 'group_id' => 2, 'base' => 'g-o6'),
	array('info_id' => 12, 'group_id' => 2, 'base' => 'g-o5'),
	array('info_id' => 13, 'group_id' => 2, 'base' => 'g-o4'),
	array('info_id' => 14, 'group_id' => 2, 'base' => 'g-o3'),
	array('info_id' => 15, 'group_id' => 2, 'base' => 'g-o2'),
	array('info_id' => 8, 'group_id' => 2, 'base' => 'g-o1'),
);

$positions = array(
	array(
		'name' => 'Commander',
		'desc' => "Seniormost officer on a warbird and responsible for everything that happens. The Commander receives their orders straight from the Star Empire leadership.",
		'dept_id' => 1,
		'order' => 0,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => 'Sub-Commander',
		'desc' => "Second seniormost officer on a warbird and usually hand-selected by the Commander. The Sub-Commander is responsible for helping to run the warbird and carry out the orders of the Commander.",
		'dept_id' => 1,
		'order' => 1,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => 'Sciences Head',
		'desc' => "A position held by the most senior Sciences Department Leader, included in Command Staff if not held by the First Officer.",
		'dept_id' => 1,
		'order' => 2,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => 'Control Head',
		'desc' => "A position held by the most senior Support Department Leader, included in Command Staff if not held by the First Officer.",
		'dept_id' => 1,
		'order' => 3,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => 'Warfare Head',
		'desc' => "A position held by the most senior Warfare Department Leader, included in Command Staff if not held by the First Officer.",
		'dept_id' => 1,
		'order' => 4,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => "Protocol Officer/Tal Prai'ex Representative",
		'desc' => "A stand alone position, this person is usually a member of the Tal Prai'ex and ensures that all actions carried out by the Command Staff are in-line with the policies of the Praetorate.  Generally seen as the Praetor's spy on a Warbird.",
		'dept_id' => 1,
		'order' => 5,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => "Tal Shi'ar Representative",
		'desc' => "If the Protocol Officer is the Praetor's eyes and ears on a Warbird, the Tal Shi'ar Representative is his/her nemesis, as they act as the eyes and ears of the Tal Shi'ar on the vessel.",
		'dept_id' => 1,
		'order' => 6,
		'open' => 1,
		'type' => 'senior'),
	
	array(
		'name' => 'Leader of Science',
		'desc' => "The most senior Scientist on board the warbird.  An expert in several specialist fields of scientific research, but also an experienced generalist to be able to deal and understand all information they gather.",
		'dept_id' => 2,
		'order' => 0,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => 'Senior Scientist',
		'desc' => "The second two most senior Scientist on board the warbird.  An expert in two specialist fields of scientific research, but also an experienced generalist to be able to deal and understand all information they gather.",
		'dept_id' => 2,
		'order' => 1,
		'open' => 2,
		'type' => 'officer'),
	array(
		'name' => 'Specialist Scientist',
		'desc' => "A Specialist Scientist on board the warbird.  An expert in a specialist field of scientific research, but also an experienced generalist to be able to deal and understand all information they gather.",
		'dept_id' => 2,
		'order' => 2,
		'open' => 3,
		'type' => 'officer'),
	array(
		'name' => 'General Scientist',
		'desc' => "A Generalist Scientist on board the warbird. They are not yet considered to be an expert in a particular field of scientific research, but considered well versed in the many fields of scienctific research to carry out solo study.",
		'dept_id' => 2,
		'order' => 3,
		'open' => 5,
		'type' => 'officer'),
	array(
		'name' => 'Lower Scientist',
		'desc' => "A Lower Generalist Scientist on board the warbird. They are not yet considered to be an expert in a particular field of scientific research, but considered versed in the many fields of scienctific research to carry out supervised study.",
		'dept_id' => 2,
		'order' => 4,
		'open' => 5,
		'type' => 'officer'),
	array(
		'name' => 'Research Aide',
		'desc' => "Generally an officer carrying out Military Service, they act as a general dogs-body to other scientists and aide them in their research programmes.",
		'dept_id' => 2,
		'order' => 5,
		'open' => 10,
		'type' => 'officer'),
		
	array(
		'name' => 'Leader of Medical Sciences',
		'desc' => "The most Senior Doctor on board the Warbird, considered to be an expert in the 3 main branches of Medicial Sciences, Medicine, Surgery and Psychiatry.  It is to him/her that the Senior Surgeon, Senior Physician and Senior Psychiatrist all report.",
		'dept_id' => 3,
		'order' => 0,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => 'Senior of Surgery',
		'desc' => "The most Senior Surgeon on board the Warbird (save for the Leader of Medical Sciences), considered to be an expert in Surgery.  It is to him/her that the Specialist (Surgical) Doctors report.",
		'dept_id' => 3,
		'order' => 1,
		'open' => 1,
		'type' => 'officer'),
	array(
		'name' => 'Senior of Medicine',
		'desc' => "The most Senior Physician on board the Warbird (save for the Leader of Medical Sciences), considered to be an expert in Medicine.  It is to him/her that the Specialist (Medical) Doctors report.",
		'dept_id' => 3,
		'order' => 2,
		'open' => 1,
		'type' => 'officer'),
	array(
		'name' => 'Senior of Psychiatry',
		'desc' => "The most Senior Psychiatrist on board the Warbird (save for the Leader of Medical Sciences), considered to be an expert in Psychiatry.  It is to him/her that the Specialist (Psychiaric) Doctors report.",
		'dept_id' => 3,
		'order' => 3,
		'open' => 1,
		'type' => 'officer'),
	array(
		'name' => 'Specialist Doctor',
		'desc' => "Doctors whom Specialise in one of the three main branches of Medical Sciences, and report to the Senior of their Branch.",
		'dept_id' => 3,
		'order' => 5,
		'open' => 6,
		'type' => 'officer'),
	array(
		'name' => 'General Doctor',
		'desc' => "Unlike a Specialist, these Doctors are rather seen as jack of all trades, and can deal with most medical situations, but may refer to a Specialist",
		'dept_id' => 3,
		'order' => 6,
		'open' => 6,
		'type' => 'officer'),
	array(
		'name' => 'Medical Aide',
		'desc' => "Generally an officer carrying out Military Service, they act as a general dogs-body for Doctors to assist them in medical treatments etc.",
		'dept_id' => 3,
		'order' => 7,
		'open' => 10,
		'type' => 'officer'),
		
	array(
		'name' => 'Leader of R&amp;D',
		'desc' => "This person is responsible for the gathering of all alien technologies and reverse engineering them to be viable for use with other Romulan Technologies.  Also works with Ship and Singularity Control for intergrating such technologies into the Warbird.",
		'dept_id' => 4,
		'order' => 0,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => 'Senior Developer',
		'desc' => "This person acts as a deputy to the Leader of R&D, assisting him/her in reverse engineering technology for use within the Romulan Star Empire.",
		'dept_id' => 4,
		'order' => 1,
		'open' => 2,
		'type' => 'officer'),
	array(
		'name' => 'Developer',
		'desc' => "This person assists in reverse engineering technology for use within the Romulan Star Empire.",
		'dept_id' => 4,
		'order' => 2,
		'open' => 4,
		'type' => 'officer'),
	array(
		'name' => 'Researcher',
		'desc' => "This person carries out research into technologies and acts as collector of alien Technologies for use in reverse engineering.",
		'dept_id' => 4,
		'order' => 3,
		'open' => 4,
		'type' => 'officer'),
	array(
		'name' => 'Research Aide',
		'desc' => "Generally an officer carrying out Military Service, they act as a general dogs-body for Developers and Researchers.",
		'dept_id' => 4,
		'order' => 4,
		'open' => 10,
		'type' => 'officer'),
		
	array(
		'name' => 'Leader of Flight Control',
		'desc' => "The most senior Pilot and Navigator on board the warbird.  An expert all aspects of flight control and spacial navigation.",
		'dept_id' => 5,
		'order' => 0,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => 'Senior Controller',
		'desc' => "The second two most senior Pilots and Navigators on board the warbird.  An expert all aspects of flight control and spacial navigation.",
		'dept_id' => 5,
		'order' => 1,
		'open' => 2,
		'type' => 'officer'),
	array(
		'name' => 'Specialist Controller',
		'desc' => "An expert all aspects of flight control and spacial navigation.",
		'dept_id' => 5,
		'order' => 2,
		'open' => 4,
		'type' => 'officer'),
	array(
		'name' => 'General Controller',
		'desc' => "An experienced Pilot and/or Navigator.",
		'dept_id' => 5,
		'order' => 3,
		'open' => 8,
		'type' => 'officer'),
	array(
		'name' => 'Lower Controller',
		'desc' => "A junior Pilot and/or Navigator.",
		'dept_id' => 5,
		'order' => 4,
		'open' => 8,
		'type' => 'officer'),
	array(
		'name' => 'Control Aide',
		'desc' => "enerally an officer carrying out Military Service, they act as a general dogs-body for the Flight Control Department.",
		'dept_id' => 5,
		'order' => 5,
		'open' => 10,
		'type' => 'officer'),
		
	array(
		'name' => 'Leader of Warbird Control',
		'desc' => "The most senior Techie on board the warbird.  An expert in all aspects of warbird systems operations.",
		'dept_id' => 6,
		'order' => 0,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => 'Senior Controller',
		'desc' => "The second two most senior Techies on board the warbird.  An expert in all aspects of warbird systems operations.",
		'dept_id' => 6,
		'order' => 1,
		'open' => 2,
		'type' => 'officer'),
	array(
		'name' => 'Specialist Controller',
		'desc' => "An expert all aspects of warbird systems operations.",
		'dept_id' => 6,
		'order' => 2,
		'open' => 4,
		'type' => 'officer'),
	array(
		'name' => 'General Controller',
		'desc' => "An experienced Techie.",
		'dept_id' => 6,
		'order' => 3,
		'open' => 8,
		'type' => 'officer'),
	array(
		'name' => 'Lower Controller',
		'desc' => "A junior techie.",
		'dept_id' => 6,
		'order' => 4,
		'open' => 8,
		'type' => 'officer'),
	array(
		'name' => 'Control Aide',
		'desc' => "Generally an officer carrying out Military Service, they act as a general dogs-body for the Warbird Control Department.",
		'dept_id' => 6,
		'order' => 5,
		'open' => 10,
		'type' => 'officer'),
	
	array(
		'name' => 'Leader of Singularity Control',
		'desc' => "The most senior Engineer on board the warbird.  An expert in all aspects of Warbird Engineering.",
		'dept_id' => 7,
		'order' => 0,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => 'Senior Controller',
		'desc' => "The second two most senior Engineers on board the warbird.  An expert in all aspects of Warbird Engineering.",
		'dept_id' => 7,
		'order' => 1,
		'open' => 2,
		'type' => 'officer'),
	array(
		'name' => 'Specialist Controller',
		'desc' => "An expert all aspects of warbird engineering.",
		'dept_id' => 7,
		'order' => 2,
		'open' => 4,
		'type' => 'officer'),
	array(
		'name' => 'General Controller',
		'desc' => "An experienced engineer.",
		'dept_id' => 7,
		'order' => 3,
		'open' => 8,
		'type' => 'officer'),
	array(
		'name' => 'Lower Controller',
		'desc' => "A junior engineer.",
		'dept_id' => 7,
		'order' => 4,
		'open' => 8,
		'type' => 'officer'),
	array(
		'name' => 'Control Aide',
		'desc' => "Generally an officer carrying out Military Service, they act as a general dogs-body for the Singularity Control Department.",
		'dept_id' => 7,
		'order' => 5,
		'open' => 10,
		'type' => 'officer'),
		
	array(
		'name' => 'Leader of Cloaking Control',
		'desc' => "A seasoned and experienced Engineer, who has proven him or herself an expert in all brances of Engineering, and has served as a Leader of Singularity Control or Warbird Control and is loyal enough to the RSE to warrant his or her being trained in the classified Cloaking Device.",
		'dept_id' => 8,
		'order' => 0,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => 'Senior Controller',
		'desc' => "A seasoned and experienced Engineer although less so than the Leader of Singularity Control, who has proven him or herself an expert in all brances of Engineering, and has served as a Leader of Singularity Control or Warbird Control and is loyal enough to the RSE to warrant his or her being trained in the classified Cloaking Device.",
		'dept_id' => 8,
		'order' => 1,
		'open' => 2,
		'type' => 'officer'),
	array(
		'name' => 'Specialist Controller',
		'desc' => "A seasoned and experienced Engineer although less so than the Senior Controller, who has proven him or herself an expert in all brances of Engineering, and has served as a Leader of Singularity Control or Warbird Control and is loyal enough to the RSE to warrant his or her being trained in the classified Cloaking Device.",
		'dept_id' => 8,
		'order' => 2,
		'open' => 4,
		'type' => 'officer'),
		
	array(
		'name' => 'Leader of Communications Control',
		'desc' => "The most senior Linguists on board the warbird.  An expert in over 20 languages, and in all Communications equipment.",
		'dept_id' => 9,
		'order' => 0,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => 'Senior Controller',
		'desc' => "The second two most senior Linguists on board the warbird.  An expert in over 10 languages, and in all Communications equipment.",
		'dept_id' => 9,
		'order' => 1,
		'open' => 2,
		'type' => 'officer'),
	array(
		'name' => 'Specialist Controller',
		'desc' => "An expert in over 10 languages and Communications equipment.",
		'dept_id' => 9,
		'order' => 2,
		'open' => 4,
		'type' => 'officer'),
	array(
		'name' => 'General Controller',
		'desc' => "An experienced linguist.",
		'dept_id' => 9,
		'order' => 3,
		'open' => 8,
		'type' => 'officer'),
	array(
		'name' => 'Lower Controller',
		'desc' => "An junior linguist.",
		'dept_id' => 9,
		'order' => 4,
		'open' => 8,
		'type' => 'officer'),
	array(
		'name' => 'Control Aide',
		'desc' => "Generally an officer carrying out Military Service, they act as a general dogs-body for the Communications Control Department.",
		'dept_id' => 9,
		'order' => 5,
		'open' => 10,
		'type' => 'officer'),
		
	array(
		'name' => 'Weapons Master/Mistress',
		'desc' => "A seasoned and experienced weapons expert, as well as stratetician, who ensures the safety of the vessel from external forces via useage of weapons.  Also maintains all weapons on board the Warbird.",
		'dept_id' => 10,
		'order' => 0,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => 'Senior Weapons Controller',
		'desc' => "A highly experienced weapons expert, as well as stratetician, who ensures the safety of the vessel from external forces via useage of weapons.  Also maintains all weapons on board the Warbird.",
		'dept_id' => 10,
		'order' => 1,
		'open' => 2,
		'type' => 'officer'),
	array(
		'name' => 'Weapons Master/Mistress',
		'desc' => "An experienced weapons officer who ensures the safety of the vessel from external forces. These individuals have a high level of expertise in all weapons aboard a Warbird.",
		'dept_id' => 10,
		'order' => 0,
		'open' => 2,
		'type' => 'senior'),
	array(
		'name' => 'Specialist Controller',
		'desc' => "Specialized weapons officers who help ensure the safety of the vessel from external forces. Generally, these specialists have trained on one or two specific weapons systems instead of general weapons knowledge.",
		'dept_id' => 10,
		'order' => 2,
		'open' => 4,
		'type' => 'officer'),
	array(
		'name' => 'General Controller',
		'desc' => "An experienced weapons officer who help ensure the safety of the vessel from external forces.",
		'dept_id' => 10,
		'order' => 3,
		'open' => 8,
		'type' => 'officer'),
	array(
		'name' => 'Lower Controller',
		'desc' => "A junior weapons officer who works with the General Controllers to ensure the safety of the vessel from external forces.",
		'dept_id' => 10,
		'order' => 4,
		'open' => 8,
		'type' => 'officer'),
	array(
		'name' => 'Control Aide',
		'desc' => "Generally an officer carrying out Military Service, they act as a general dogs-body for the Weapons Control Department.",
		'dept_id' => 10,
		'order' => 5,
		'open' => 10,
		'type' => 'officer'),
		
	array(
		'name' => 'Tal Diann Master/Mistress',
		'desc' => "The gatherer of all intelligence on the vessel for use by the Command Staff.  Often works with the Commander to subvert the machinations of the Tal Shi'ar Representative due to the animosity between the two Intelligence groups.",
		'dept_id' => 11,
		'order' => 0,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => 'Tal Diann Deputy Leader',
		'desc' => "An experienced and trusted intelligence asset that works to help the Master/Mistress subert the machinations of the Tal Shi'ar aboard Warbirds.",
		'dept_id' => 11,
		'order' => 1,
		'open' => 2,
		'type' => 'officer'),
	array(
		'name' => 'Tal Diann Officer',
		'desc' => "An experienced intelligence asset aboard a Warbird that works to subvert the machinations of the Tal'Shiar on their vessel.",
		'dept_id' => 11,
		'order' => 2,
		'open' => 4,
		'type' => 'officer'),
		
	array(
		'name' => 'Reman Master/Mistress',
		'desc' => "S/he is the person that controls all the Reman Slaves on board the Warbird, ensuring their loyalty to the RSE, as well as disciplining them.  S/he has a station on the Command Deck and monitors internal security.  Also s/he is present on landing and boarding parties.",
		'dept_id' => 12,
		'order' => 0,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => 'Slave Overseer',
		'desc' => "The Over-seer of one unit of Reman Slaves.",
		'dept_id' => 12,
		'order' => 1,
		'open' => 4,
		'type' => 'officer'),
	array(
		'name' => 'Elder Slave',
		'desc' => "The most senior Reman Commando within a Unit.",
		'dept_id' => 12,
		'order' => 2,
		'open' => 4,
		'type' => 'officer'),
	array(
		'name' => 'Slave',
		'desc' => "A normal Reman Commando.",
		'dept_id' => 12,
		'order' => 3,
		'open' => 20,
		'type' => 'officer')
);

$catalog_ranks = array(
	array(
		'name' => 'Duty Uniform (Nemesis)',
		'location' => 'default',
		'credits' => "The Romulan rank sets was created by Kuro-chan of Kuro-RPG. The rankset (and others) can be found at <a href='http://www.kuro-rpg.net' target='_blank'>Kuro-RPG</a>. Please do not copy or modify the images.",
		'genre' => $g)
);