<?php

return [

	'departments' => [
		[
			'name' => 'Command',
			'description' => "As on most space-faring vessels the Command department is made up of those officers deemed to be in the day-to-day control of the Warbird. Apart from the Commanding Officer, other members of the Command Staff also serve in other faculties/ departments.",
			'order' => 0,
			'positions' => [
				[
					'name' => 'Commander',
					'description' => "Seniormost officer on a warbird and responsible for everything that happens. The Commander receives their orders straight from the Star Empire leadership.",
					'order' => 0,
					'available' => 1,
				],
				[
					'name' => 'Sub-Commander',
					'description' => "Second seniormost officer on a warbird and usually hand-selected by the Commander. The Sub-Commander is responsible for helping to run the warbird and carry out the orders of the Commander.",
					'order' => 1,
					'available' => 1,
				],
				[
					'name' => 'Sciences Head',
					'description' => "A position held by the most senior Sciences Department Leader, included in Command Staff if not held by the First Officer.",
					'order' => 2,
					'available' => 1,
				],
				[
					'name' => 'Control Head',
					'description' => "A position held by the most senior Support Department Leader, included in Command Staff if not held by the First Officer.",
					'order' => 3,
					'available' => 1,
				],
				[
					'name' => 'Warfare Head',
					'description' => "A position held by the most senior Warfare Department Leader, included in Command Staff if not held by the First Officer.",
					'order' => 4,
					'available' => 1,
				],
				[
					'name' => "Protocol Officer/Tal Prai'ex Representative",
					'description' => "A stand alone position, this person is usually a member of the Tal Prai'ex and ensures that all actions carried out by the Command Staff are in-line with the policies of the Praetorate. Generally seen as the Praetor's spy on a Warbird.",
					'order' => 5,
					'available' => 1,
				],
				[
					'name' => "Tal Shi'ar Representative",
					'description' => "If the Protocol Officer is the Praetor's eyes and ears on a Warbird, the Tal Shi'ar Representative is his/her nemesis, as they act as the eyes and ears of the Tal Shi'ar on the vessel.",
					'order' => 6,
					'available' => 1,
				],
			],
		],
		[
			'name' => 'Scientific Research',
			'description' => "Responsible for all the scientific data the Warbird collects, and the distribution of such data to specific sections within the department for analysis. They are also responsible with providing the ship's captain with scientific information needed for command decisions.",
			'order' => 1,
			'positions' => [
				[
					'name' => 'Leader of Science',
					'description' => "The most senior Scientist on board the warbird. An expert in several specialist fields of scientific research, but also an experienced generalist to be able to deal and understand all information they gather.",
					'order' => 0,
					'available' => 1,
				],
				[
					'name' => 'Senior Scientist',
					'description' => "The second two most senior Scientist on board the warbird. An expert in two specialist fields of scientific research, but also an experienced generalist to be able to deal and understand all information they gather.",
					'order' => 1,
					'available' => 2,
				],
				[
					'name' => 'Specialist Scientist',
					'description' => "A Specialist Scientist on board the warbird. An expert in a specialist field of scientific research, but also an experienced generalist to be able to deal and understand all information they gather.",
					'order' => 2,
					'available' => 3,
				],
				[
					'name' => 'General Scientist',
					'description' => "A Generalist Scientist on board the warbird. They are not yet considered to be an expert in a particular field of scientific research, but considered well versed in the many fields of scienctific research to carry out solo study.",
					'order' => 3,
					'available' => 5,
				],
				[
					'name' => 'Lower Scientist',
					'description' => "A Lower Generalist Scientist on board the warbird. They are not yet considered to be an expert in a particular field of scientific research, but considered versed in the many fields of scienctific research to carry out supervised study.",
					'order' => 4,
					'available' => 5,
				],
				[
					'name' => 'Research Aide',
					'description' => "Generally an officer carrying out Military Service, they act as a general dogs-body to other scientists and aide them in their research programmes.",
					'order' => 5,
					'available' => 10,
				],
			],
		],
		[
			'name' => 'Medical Sciences',
			'description' => "Responsible for the physical health of the entire crew, but does more than patch up injured crew members. Their function is to ensure that they do not get sick or injured to begin with, and to this end monitors their health and conditioning with regular check ups. If necessary, the Leader of Medical Sciences can remove anyone from duty, excluding the Commander. Besides this they available to provide medical advice to any individual who requests it. Additionally the Seniors of the 3 bracnhes of Medical Sciences as well as the Leader of the Department are also responsible for all aspect of the medical deck, such as the Medical labs, Surgical suites, Psychiatric treatment areas.",
			'order' => 2,
			'positions' => [
				[
					'name' => 'Leader of Medical Sciences',
					'description' => "The most Senior Doctor on board the Warbird, considered to be an expert in the 3 main branches of Medicial Sciences, Medicine, Surgery and Psychiatry. It is to him/her that the Senior Surgeon, Senior Physician and Senior Psychiatrist all report.",
					'order' => 0,
					'available' => 1,
				],
				[
					'name' => 'Senior of Surgery',
					'description' => "The most Senior Surgeon on board the Warbird (save for the Leader of Medical Sciences), considered to be an expert in Surgery. It is to him/her that the Specialist (Surgical) Doctors report.",
					'order' => 1,
					'available' => 1,
				],
				[
					'name' => 'Senior of Medicine',
					'description' => "The most Senior Physician on board the Warbird (save for the Leader of Medical Sciences), considered to be an expert in Medicine. It is to him/her that the Specialist (Medical) Doctors report.",
					'order' => 2,
					'available' => 1,
				],
				[
					'name' => 'Senior of Psychiatry',
					'description' => "The most Senior Psychiatrist on board the Warbird (save for the Leader of Medical Sciences), considered to be an expert in Psychiatry. It is to him/her that the Specialist (Psychiaric) Doctors report.",
					'order' => 3,
					'available' => 1,
				],
				[
					'name' => 'Specialist Doctor',
					'description' => "Doctors whom Specialise in one of the three main branches of Medical Sciences, and report to the Senior of their Branch.",
					'order' => 5,
					'available' => 6,
				],
				[
					'name' => 'General Doctor',
					'description' => "Unlike a Specialist, these Doctors are rather seen as jack of all trades, and can deal with most medical situations, but may refer to a Specialist",
					'order' => 6,
					'available' => 6,
				],
				[
					'name' => 'Medical Aide',
					'description' => "Generally an officer carrying out Military Service, they act as a general dogs-body for Doctors to assist them in medical treatments etc.",
					'order' => 7,
					'available' => 10,
				],
			],
		],
		[
			'name' => 'Research & Development',
			'description' => "This department is of an oddity only found within the Romulan Star Empire. The entire purpose of this department is to take alien technology (e.g. Starfleet) and backwards engineer it and to create something similiar to the original but allowing it to be compatible with other Romulan Technologies.",
			'order' => 3,
			'positions' => [
				[
					'name' => 'Leader of R&D',
					'description' => "This person is responsible for the gathering of all alien technologies and reverse engineering them to be viable for use with other Romulan Technologies. Also works with Ship and Singularity Control for intergrating such technologies into the Warbird.",
					'order' => 0,
					'available' => 1,
				],
				[
					'name' => 'Senior Developer',
					'description' => "This person acts as a deputy to the Leader of R&D, assisting him/her in reverse engineering technology for use within the Romulan Star Empire.",
					'order' => 1,
					'available' => 2,
				],
				[
					'name' => 'Developer',
					'description' => "This person assists in reverse engineering technology for use within the Romulan Star Empire.",
					'order' => 2,
					'available' => 4,
				],
				[
					'name' => 'Researcher',
					'description' => "This person carries out research into technologies and acts as collector of alien Technologies for use in reverse engineering.",
					'order' => 3,
					'available' => 4,
				],
				[
					'name' => 'Research Aide',
					'description' => "Generally an officer carrying out Military Service, they act as a general dogs-body for Developers and Researchers.",
					'order' => 4,
					'available' => 10,
				],
			],
		],
		[
			'name' => 'Flight Control',
			'description' => "A Flight Controller must always be present on the bridge of a starship, and every vessel has a number of Flight Control Officers to allow shift rotations. They plot courses, supervises the computers piloting, corrects any flight deviations and pilots the ship manually when needed.",
			'order' => 4,
			'positions' => [
				[
					'name' => 'Leader of Flight Control',
					'description' => "The most senior Pilot and Navigator on board the warbird. An expert all aspects of flight control and spacial navigation.",
					'order' => 0,
					'available' => 1,
				],
				[
					'name' => 'Senior Controller',
					'description' => "The second two most senior Pilots and Navigators on board the warbird. An expert all aspects of flight control and spacial navigation.",
					'order' => 1,
					'available' => 2,
				],
				[
					'name' => 'Specialist Controller',
					'description' => "An expert all aspects of flight control and spacial navigation.",
					'order' => 2,
					'available' => 4,
				],
				[
					'name' => 'General Controller',
					'description' => "An experienced Pilot and/or Navigator.",
					'order' => 3,
					'available' => 8,
				],
				[
					'name' => 'Lower Controller',
					'description' => "A junior Pilot and/or Navigator.",
					'order' => 4,
					'available' => 8,
				],
				[
					'name' => 'Control Aide',
					'description' => "enerally an officer carrying out Military Service, they act as a general dogs-body for the Flight Control Department.",
					'order' => 5,
					'available' => 10,
				],
			],
		],
		[
			'name' => 'Warbird Control',
			'description' => "Responsibility of ensuring that ship functions, such as the use of the lateral sensor array, do not interfere with one and another. They must prioritize resource allocations, so that the most critical activities can have every chance of success. If so required, they can curtail shipboard functions if they thinks they will interfere with the ship's current mission or routine operations.",
			'order' => 5,
			'positions' => [
				[
					'name' => 'Leader of Warbird Control',
					'description' => "The most senior Techie on board the warbird. An expert in all aspects of warbird systems operations.",
					'order' => 0,
					'available' => 1,
				],
				[
					'name' => 'Senior Controller',
					'description' => "The second two most senior Techies on board the warbird. An expert in all aspects of warbird systems operations.",
					'order' => 1,
					'available' => 2,
				],
				[
					'name' => 'Specialist Controller',
					'description' => "An expert all aspects of warbird systems operations.",
					'order' => 2,
					'available' => 4,
				],
				[
					'name' => 'General Controller',
					'description' => "An experienced Techie.",
					'order' => 3,
					'available' => 8,
				],
				[
					'name' => 'Lower Controller',
					'description' => "A junior techie.",
					'order' => 4,
					'available' => 8,
				],
				[
					'name' => 'Control Aide',
					'description' => "Generally an officer carrying out Military Service, they act as a general dogs-body for the Warbird Control Department.",
					'order' => 5,
					'available' => 10,
				],
			],
		],
		[
			'name' => 'Singularity Control',
			'description' => "Responsible for the condition of all systems and equipment on board the Warbird. They oversee maintenance, repairs and upgrades of all equipment. They control the output and maintain the operational status of the Singularity Drive. They also responsible for the many repairs teams during crisis situations.",
			'order' => 6,
			'positions' => [
				[
					'name' => 'Leader of Singularity Control',
					'description' => "The most senior Engineer on board the warbird. An expert in all aspects of Warbird Engineering.",
					'order' => 0,
					'available' => 1,
				],
				[
					'name' => 'Senior Controller',
					'description' => "The second two most senior Engineers on board the warbird. An expert in all aspects of Warbird Engineering.",
					'order' => 1,
					'available' => 2,
				],
				[
					'name' => 'Specialist Controller',
					'description' => "An expert all aspects of warbird engineering.",
					'order' => 2,
					'available' => 4,
				],
				[
					'name' => 'General Controller',
					'description' => "An experienced engineer.",
					'order' => 3,
					'available' => 8,
				],
				[
					'name' => 'Lower Controller',
					'description' => "A junior engineer.",
					'order' => 4,
					'available' => 8,
				],
				[
					'name' => 'Control Aide',
					'description' => "Generally an officer carrying out Military Service, they act as a general dogs-body for the Singularity Control Department.",
					'order' => 5,
					'available' => 10,
				],
			],
		],
		[
			'name' => 'Cloaking Control',
			'description' => "Responsible for the smooth operation of the Cloaking Device and other related systems, unlike other Control departments, Cloaking Control is a very small department, with members usually having served for many tours within an Singularity Control Department, and then undergoing specialist Cloaking Technology Training Programmes. The department only contains 3 staff members.",
			'order' => 7,
			'positions' => [
				[
					'name' => 'Leader of Cloaking Control',
					'description' => "A seasoned and experienced Engineer, who has proven him or herself an expert in all brances of Engineering, and has served as a Leader of Singularity Control or Warbird Control and is loyal enough to the RSE to warrant his or her being trained in the classified Cloaking Device.",
					'order' => 0,
					'available' => 1,
				],
				[
					'name' => 'Senior Controller',
					'description' => "A seasoned and experienced Engineer although less so than the Leader of Singularity Control, who has proven him or herself an expert in all brances of Engineering, and has served as a Leader of Singularity Control or Warbird Control and is loyal enough to the RSE to warrant his or her being trained in the classified Cloaking Device.",
					'order' => 1,
					'available' => 2,
				],
				[
					'name' => 'Specialist Controller',
					'description' => "A seasoned and experienced Engineer although less so than the Senior Controller, who has proven him or herself an expert in all brances of Engineering, and has served as a Leader of Singularity Control or Warbird Control and is loyal enough to the RSE to warrant his or her being trained in the classified Cloaking Device.",
					'order' => 2,
					'available' => 4,
				],
			],
		],
		[
			'name' => 'Communications Control',
			'description' => "Monitors any and all transmissions aboard the warbird, as well as externally. Communications Officers are experienced linguist, proficient in many different languages.",
			'order' => 8,
			'positions' => [
				[
					'name' => 'Leader of Communications Control',
					'description' => "The most senior Linguists on board the warbird. An expert in over 20 languages, and in all Communications equipment.",
					'order' => 0,
					'available' => 1,
				],
				[
					'name' => 'Senior Controller',
					'description' => "The second two most senior Linguists on board the warbird. An expert in over 10 languages, and in all Communications equipment.",
					'order' => 1,
					'available' => 2,
				],
				[
					'name' => 'Specialist Controller',
					'description' => "An expert in over 10 languages and Communications equipment.",
					'order' => 2,
					'available' => 4,
				],
				[
					'name' => 'General Controller',
					'description' => "An experienced linguist.",
					'order' => 3,
					'available' => 8,
				],
				[
					'name' => 'Lower Controller',
					'description' => "An junior linguist.",
					'order' => 4,
					'available' => 8,
				],
				[
					'name' => 'Control Aide',
					'description' => "Generally an officer carrying out Military Service, they act as a general dogs-body for the Communications Control Department.",
					'order' => 5,
					'available' => 10,
				],
			],
		],
		[
			'name' => 'Weapons Control',
			'description' => "They are the vessels gunman.They responsible for the ships weapon system, and is also the COs tactical advisor in Star Ship Combat matters. Very often Weapons Officers are also trained in ground combat and small unit tactics. There is much more to Weapons Control than simply overseeing the weapons console on the bridge. Weapons Control maintains the weapons systems aboard the warbird, maintaining and reloading photons magazines. Tactical planning and current Intelligence analysis (if no Intelligence operatives are aboard) is also overseen by the tactical department.",
			'order' => 9,
			'positions' => [
				[
					'name' => 'Weapons Master/Mistress',
					'description' => "A seasoned and experienced weapons expert, as well as stratetician, who ensures the safety of the vessel from external forces via useage of weapons. Also maintains all weapons on board the Warbird.",
					'order' => 0,
					'available' => 1,
				],
				[
					'name' => 'Senior Weapons Controller',
					'description' => "A highly experienced weapons expert, as well as stratetician, who ensures the safety of the vessel from external forces via useage of weapons. Also maintains all weapons on board the Warbird.",
					'order' => 1,
					'available' => 2,
				],
				[
					'name' => 'Weapons Master/Mistress',
					'description' => "An experienced weapons officer who ensures the safety of the vessel from external forces. These individuals have a high level of expertise in all weapons aboard a Warbird.",
					'order' => 0,
					'available' => 2,
				],
				[
					'name' => 'Specialist Controller',
					'description' => "Specialized weapons officers who help ensure the safety of the vessel from external forces. Generally, these specialists have trained on one or two specific weapons systems instead of general weapons knowledge.",
					'order' => 2,
					'available' => 4,
				],
				[
					'name' => 'General Controller',
					'description' => "An experienced weapons officer who help ensure the safety of the vessel from external forces.",
					'order' => 3,
					'available' => 8,
				],
				[
					'name' => 'Lower Controller',
					'description' => "A junior weapons officer who works with the General Controllers to ensure the safety of the vessel from external forces.",
					'order' => 4,
					'available' => 8,
				],
				[
					'name' => 'Control Aide',
					'description' => "Generally an officer carrying out Military Service, they act as a general dogs-body for the Weapons Control Department.",
					'order' => 5,
					'available' => 10,
				],
			],
		],
		[
			'name' => 'Tal Diann',
			'description' => "Responsible for collected and collating all information that they deem appropriate for delivery to the Command Staff. Unlike most departments the Tal Diann are considered a seperate force within the Galae in the same manner as the Tal Shi'ar. They are often at odds with the Tal Shi'ar Agent on-board the Warbird.",
			'order' => 10,
			'positions' => [
				[
					'name' => 'Tal Diann Master/Mistress',
					'description' => "The gatherer of all intelligence on the vessel for use by the Command Staff. Often works with the Commander to subvert the machinations of the Tal Shi'ar Representative due to the animosity between the two Intelligence groups.",
					'order' => 0,
					'available' => 1,
				],
				[
					'name' => 'Tal Diann Deputy Leader',
					'description' => "An experienced and trusted intelligence asset that works to help the Master/Mistress subert the machinations of the Tal Shi'ar aboard Warbirds.",
					'order' => 1,
					'available' => 2,
				],
				[
					'name' => 'Tal Diann Officer',
					'description' => "An experienced intelligence asset aboard a Warbird that works to subvert the machinations of the Tal Shi'ar on their vessel.",
					'order' => 2,
					'available' => 4,
				],
			],
		],
		[
			'name' => 'Reman Commando Corps',
			'description' => "It is their duty is to ensure the safety of ship and crew. The Commando Commander takes it as their personal duty to protect the Commanding Officer on landing parties. They are also responsible for people under arrest and the safety of guests, liked or not. They are also required to take command of any special ground operations. The Reman Commando Corps is the only branch of the Galae to have an enlisted service. The RCC is always controlled by Galae Officers, but the rank and file is made up of Remans who are considered too inferior to hold a commissioned rank.",
			'order' => 11,
			'positions' => [
				[
					'name' => 'Reman Master/Mistress',
					'description' => "S/he is the person that controls all the Reman Slaves on board the Warbird, ensuring their loyalty to the RSE, as well as disciplining them. S/he has a station on the Command Deck and monitors internal security. Also s/he is present on landing and boarding parties.",
					'order' => 0,
					'available' => 1,
				],
				[
					'name' => 'Slave Overseer',
					'description' => "The Over-seer of one unit of Reman Slaves.",
					'order' => 1,
					'available' => 4,
				],
				[
					'name' => 'Elder Slave',
					'description' => "The most senior Reman Commando within a Unit.",
					'order' => 2,
					'available' => 4,
				],
				[
					'name' => 'Slave',
					'description' => "A normal Reman Commando.",
					'order' => 3,
					'available' => 20,
				],
			],
		],
	],

	'rankGroups' => [
		['name' => 'Romulan Star Navy', 'order' => 0],
		['name' => "Tal Shi'ar", 'order' => 1],
	],

	'rankInfo' => [
		['name' => 'Admiral', 'short_name' => 'ADM', 'order' => 0],
		['name' => 'Commander', 'short_name' => 'CMDR', 'order' => 1],
		['name' => 'Subcommander', 'short_name' => 'SCMDR', 'order' => 2],
		['name' => 'Centurion', 'short_name' => 'CENT', 'order' => 3],
		['name' => 'Lieutenant', 'short_name' => 'LT', 'order' => 4],
		['name' => 'Sublieutenant', 'short_name' => 'SLT', 'order' => 5],
		['name' => 'Uhlan', 'short_name' => 'UHL', 'order' => 6],

		['name' => 'General', 'short_name' => 'GEN', 'order' => 7],
		['name' => 'Colonel', 'short_name' => 'COL', 'order' => 8],
		['name' => 'Major', 'short_name' => 'MAJ', 'order' => 9],
		['name' => 'Captain', 'short_name' => 'CAPT', 'order' => 10],
		['name' => '1st Lieutenant', 'short_name' => '1LT', 'order' => 11],
		['name' => '2nd Lieutenant', 'short_name' => '2LT', 'order' => 12],
		['name' => 'Uhlan', 'short_name' => 'UHL', 'order' => 13],
	],

	'ranks' => [
		['group_id' => 1, 'info_id' => 1, 'order' => 0, 'base' => '08.png', 'overlay' => 'silver/a1.png'],
		['group_id' => 1, 'info_id' => 2, 'order' => 1, 'base' => '08.png', 'overlay' => 'silver/o6.png'],
		['group_id' => 1, 'info_id' => 3, 'order' => 2, 'base' => '08.png', 'overlay' => 'silver/o5.png'],
		['group_id' => 1, 'info_id' => 4, 'order' => 3, 'base' => '08.png', 'overlay' => 'silver/o4.png'],
		['group_id' => 1, 'info_id' => 5, 'order' => 4, 'base' => '08.png', 'overlay' => 'silver/o3.png'],
		['group_id' => 1, 'info_id' => 6, 'order' => 5, 'base' => '08.png', 'overlay' => 'silver/o2.png'],
		['group_id' => 1, 'info_id' => 7, 'order' => 6, 'base' => '08.png', 'overlay' => 'silver/o1.png'],

		['group_id' => 2, 'info_id' => 8, 'order' => 0, 'base' => '08.png', 'overlay' => 'gold/a1.png'],
		['group_id' => 2, 'info_id' => 9, 'order' => 1, 'base' => '08.png', 'overlay' => 'gold/o6.png'],
		['group_id' => 2, 'info_id' => 10, 'order' => 2, 'base' => '08.png', 'overlay' => 'gold/o5.png'],
		['group_id' => 2, 'info_id' => 11, 'order' => 3, 'base' => '08.png', 'overlay' => 'gold/o4.png'],
		['group_id' => 2, 'info_id' => 12, 'order' => 4, 'base' => '08.png', 'overlay' => 'gold/o3.png'],
		['group_id' => 2, 'info_id' => 13, 'order' => 5, 'base' => '08.png', 'overlay' => 'gold/o2.png'],
		['group_id' => 2, 'info_id' => 14, 'order' => 6, 'base' => '08.png', 'overlay' => 'gold/o1.png'],
	],

];
