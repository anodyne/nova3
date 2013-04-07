<?php
/**
 * Genre Install Data (BL5)
 *
 * @package		Install
 * @category	Assets
 * @author		Anodyne Productions
 * @author		Rycon (Anodyne forums)
 */

/**
 * blue - b - navy
 * gray - s - security forces
 * green - m
 * brown - d - marines
 */

$g = 'bl5';

$data = array(
	'departments_'.$g 	=> 'depts',
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

$ranks= array(
	array(
		'name' => 'Commander-in-Chief',
		'short_name' => 'CIC',
		'image' => 'b-a5',
		'order' => 0,
		'class' => 1),
	array(
		'name' => 'Commander-in-Chief',
		'short_name' => 'CIC',
		'image' => 's-a5',
		'order' => 0,
		'class' => 2),
	array(
		'name' => 'Commander-in-Chief',
		'short_name' => 'CIC',
		'image' => 'm-a5',
		'order' => 0,
		'class' => 3),
	array(
		'name' => 'Commander-in-Chief',
		'short_name' => 'CIC',
		'image' => 'd-a5',
		'order' => 0,
		'class' => 4),
		
	array(
		'name' => 'General',
		'short_name' => 'GEN',
		'image' => 'b-a4',
		'order' => 1,
		'class' => 1),
	array(
		'name' => 'General',
		'short_name' => 'GEN',
		'image' => 's-a4',
		'order' => 1,
		'class' => 2),
	array(
		'name' => 'General',
		'short_name' => 'GEN',
		'image' => 'm-a4',
		'order' => 1,
		'class' => 3),
	array(
		'name' => 'General',
		'short_name' => 'GEN',
		'image' => 'd-a4',
		'order' => 1,
		'class' => 4),
		
	array(
		'name' => 'Lieutenant General',
		'short_name' => 'LT GEN',
		'image' => 'b-a3',
		'order' => 2,
		'class' => 1),
	array(
		'name' => 'Lieutenant General',
		'short_name' => 'LT GEN',
		'image' => 's-a3',
		'order' => 2,
		'class' => 2),
	array(
		'name' => 'Lieutenant General',
		'short_name' => 'LT GEN',
		'image' => 'm-a3',
		'order' => 2,
		'class' => 3),
	array(
		'name' => 'Lieutenant General',
		'short_name' => 'LT GEN',
		'image' => 'd-a3',
		'order' => 2,
		'class' => 4),
		
	array(
		'name' => 'Major General',
		'short_name' => 'MAJ GEN',
		'image' => 'b-a2',
		'order' => 3,
		'class' => 1),
	array(
		'name' => 'Major General',
		'short_name' => 'MAJ GEN',
		'image' => 's-a2',
		'order' => 3,
		'class' => 2),
	array(
		'name' => 'Major General',
		'short_name' => 'MAJ GEN',
		'image' => 'm-a2',
		'order' => 3,
		'class' => 3),
	array(
		'name' => 'Major General',
		'short_name' => 'MAJ GEN',
		'image' => 'd-a2',
		'order' => 3,
		'class' => 4),
		
	array(
		'name' => 'Brigadier General',
		'short_name' => 'BRG GEN',
		'image' => 'b-a1',
		'order' => 4,
		'class' => 1),
	array(
		'name' => 'Brigadier General',
		'short_name' => 'BRG GEN',
		'image' => 's-a1',
		'order' => 4,
		'class' => 2),
	array(
		'name' => 'Brigadier General',
		'short_name' => 'BRG GEN',
		'image' => 'm-a1',
		'order' => 4,
		'class' => 3),
	array(
		'name' => 'Brigadier General',
		'short_name' => 'BRG GEN',
		'image' => 'd-a1',
		'order' => 4,
		'class' => 4),
		
	array(
		'name' => 'Captain',
		'short_name' => 'CAPT',
		'image' => 'b-o6',
		'order' => 5,
		'class' => 1),
	array(
		'name' => 'Captain',
		'short_name' => 'CAPT',
		'image' => 's-o6',
		'order' => 5,
		'class' => 2),
	array(
		'name' => 'Colonel',
		'short_name' => 'COL',
		'image' => 'm-o6',
		'order' => 5,
		'class' => 3),
	array(
		'name' => 'Colonel',
		'short_name' => 'COL',
		'image' => 'd-o6',
		'order' => 5,
		'class' => 4),
		
	array(
		'name' => 'Commander',
		'short_name' => 'CMDR',
		'image' => 'b-o5',
		'order' => 6,
		'class' => 1),
	array(
		'name' => 'Commander',
		'short_name' => 'CMDR',
		'image' => 's-o5',
		'order' => 6,
		'class' => 2),
	array(
		'name' => 'Lieutenant Colonel',
		'short_name' => 'LT COL',
		'image' => 'm-o5',
		'order' => 6,
		'class' => 3),
	array(
		'name' => 'Lieutenant Colonel',
		'short_name' => 'LT COL',
		'image' => 'd-o5',
		'order' => 6,
		'class' => 4),
		
	array(
		'name' => 'Lieutenant Commander',
		'short_name' => 'LT CMDR',
		'image' => 'b-o4',
		'order' => 7,
		'class' => 1),
	array(
		'name' => 'Lieutenant Commander',
		'short_name' => 'LT CMDR',
		'image' => 's-o4',
		'order' => 7,
		'class' => 2),
	array(
		'name' => 'Major',
		'short_name' => 'MAJ',
		'image' => 'm-o4',
		'order' => 7,
		'class' => 3),
	array(
		'name' => 'Major',
		'short_name' => 'MAJ',
		'image' => 'd-o4',
		'order' => 7,
		'class' => 4),
		
	array(
		'name' => 'Lieutenant',
		'short_name' => 'LT',
		'image' => 'b-o3',
		'order' => 8,
		'class' => 1),
	array(
		'name' => 'Lieutenant',
		'short_name' => 'LT',
		'image' => 's-o3',
		'order' => 8,
		'class' => 2),
	array(
		'name' => 'Marine Captain',
		'short_name' => 'MCAPT',
		'image' => 'm-o3',
		'order' => 8,
		'class' => 3),
	array(
		'name' => 'Marine Captain',
		'short_name' => 'MCAPT',
		'image' => 'd-o3',
		'order' => 8,
		'class' => 4),
		
	array(
		'name' => 'Lieutenant JG',
		'short_name' => 'LT(JG)',
		'image' => 'b-o2',
		'order' => 9,
		'class' => 1),
	array(
		'name' => 'Lieutenant JG',
		'short_name' => 'LT(JG)',
		'image' => 's-o2',
		'order' => 9,
		'class' => 2),
	array(
		'name' => '1st Lieutenant',
		'short_name' => '1LT',
		'image' => 'm-o2',
		'order' => 9,
		'class' => 3),
	array(
		'name' => '1st Lieutenant',
		'short_name' => '1LT',
		'image' => 'd-o2',
		'order' => 9,
		'class' => 4),
		
	array(
		'name' => 'Ensign',
		'short_name' => 'ENS',
		'image' => 'b-o1',
		'order' => 10,
		'class' => 1),
	array(
		'name' => 'Ensign',
		'short_name' => 'ENS',
		'image' => 's-o1',
		'order' => 10,
		'class' => 2),
	array(
		'name' => '2nd Lieutenant',
		'short_name' => '2LT',
		'image' => 'm-o1',
		'order' => 10,
		'class' => 3),
	array(
		'name' => '2nd Lieutenant',
		'short_name' => '2LT',
		'image' => 'd-o1',
		'order' => 10,
		'class' => 4),
		
	array(
		'name' => 'Chief Warrant Officer 1st Class',
		'short_name' => 'CWO1',
		'image' => 'b-w4',
		'order' => 11,
		'class' => 1),
	array(
		'name' => 'Chief Warrant Officer 1st Class',
		'short_name' => 'CWO1',
		'image' => 's-w4',
		'order' => 11,
		'class' => 2),
	array(
		'name' => 'Chief Warrant Officer 1st Class',
		'short_name' => 'CWO1',
		'image' => 'm-w4',
		'order' => 11,
		'class' => 3),
	array(
		'name' => 'Chief Warrant Officer 1st Class',
		'short_name' => 'CWO1',
		'image' => 'd-w4',
		'order' => 11,
		'class' => 4),
		
	array(
		'name' => 'Chief Warrant Officer 2nd Class',
		'short_name' => 'CWO2',
		'image' => 'b-w3',
		'order' => 12,
		'class' => 1),
	array(
		'name' => 'Chief Warrant Officer 2nd Class',
		'short_name' => 'CWO2',
		'image' => 's-w3',
		'order' => 12,
		'class' => 2),
	array(
		'name' => 'Chief Warrant Officer 2nd Class',
		'short_name' => 'CWO2',
		'image' => 'm-w3',
		'order' => 12,
		'class' => 3),
	array(
		'name' => 'Chief Warrant Officer 2nd Class',
		'short_name' => 'CWO2',
		'image' => 'd-w3',
		'order' => 12,
		'class' => 4),
		
	array(
		'name' => 'Chief Warrant Officer 3rd Class',
		'short_name' => 'CWO3',
		'image' => 'b-w2',
		'order' => 13,
		'class' => 1),
	array(
		'name' => 'Chief Warrant Officer 3rd Class',
		'short_name' => 'CWO3',
		'image' => 's-w2',
		'order' => 13,
		'class' => 2),
	array(
		'name' => 'Chief Warrant Officer 3rd Class',
		'short_name' => 'CWO3',
		'image' => 'm-w2',
		'order' => 13,
		'class' => 3),
	array(
		'name' => 'Chief Warrant Officer 3rd Class',
		'short_name' => 'CWO3',
		'image' => 'd-w2',
		'order' => 13,
		'class' => 4),
		
	array(
		'name' => 'Master Chief Petty Officer',
		'short_name' => 'MCPO',
		'image' => 'b-e9',
		'order' => 14,
		'class' => 1),
	array(
		'name' => 'Master Chief Petty Officer',
		'short_name' => 'MCPO',
		'image' => 's-e9',
		'order' => 14,
		'class' => 2),
	array(
		'name' => 'Sergeant Major',
		'short_name' => 'SGTM',
		'image' => 'm-e9',
		'order' => 14,
		'class' => 3),
	array(
		'name' => 'Sergeant Major',
		'short_name' => 'SGTM',
		'image' => 'd-e9',
		'order' => 14,
		'class' => 4),
		
	array(
		'name' => 'Senior Chief Petty Officer',
		'short_name' => 'SCPO',
		'image' => 'b-e8',
		'order' => 15,
		'class' => 1),
	array(
		'name' => 'Senior Chief Petty Officer',
		'short_name' => 'SCPO',
		'image' => 's-e8',
		'order' => 15,
		'class' => 2),
	array(
		'name' => 'Master Sergeant',
		'short_name' => 'MSGT',
		'image' => 'm-e8',
		'order' => 15,
		'class' => 3),
	array(
		'name' => 'Master Sergeant',
		'short_name' => 'MSGT',
		'image' => 'd-e8',
		'order' => 15,
		'class' => 4),
		
	array(
		'name' => 'Chief Petty Officer',
		'short_name' => 'CPO',
		'image' => 'b-e7',
		'order' => 16,
		'class' => 1),
	array(
		'name' => 'Chief Petty Officer',
		'short_name' => 'CPO',
		'image' => 's-e7',
		'order' => 16,
		'class' => 2),
	array(
		'name' => 'Sergeant 1st Class',
		'short_name' => 'SGT1',
		'image' => 'm-e7',
		'order' => 16,
		'class' => 3),
	array(
		'name' => 'Sergeant 1st Class',
		'short_name' => 'SGT1',
		'image' => 'd-e7',
		'order' => 16,
		'class' => 4),
		
	array(
		'name' => 'Petty Officer 1st Class',
		'short_name' => 'PO1',
		'image' => 'b-e6',
		'order' => 17,
		'class' => 1),
	array(
		'name' => 'Petty Officer 1st Class',
		'short_name' => 'PO1',
		'image' => 's-e6',
		'order' => 17,
		'class' => 2),
	array(
		'name' => 'Staff Sergeant',
		'short_name' => 'SSGT',
		'image' => 'm-e6',
		'order' => 17,
		'class' => 3),
	array(
		'name' => 'Staff Sergeant',
		'short_name' => 'SSGT',
		'image' => 'd-e6',
		'order' => 17,
		'class' => 4),
		
	array(
		'name' => 'Petty Officer 2nd Class',
		'short_name' => 'PO2',
		'image' => 'b-e5',
		'order' => 18,
		'class' => 1),
	array(
		'name' => 'Petty Officer 2nd Class',
		'short_name' => 'PO2',
		'image' => 's-e5',
		'order' => 18,
		'class' => 2),
	array(
		'name' => 'Sergeant',
		'short_name' => 'SGT',
		'image' => 'm-e5',
		'order' => 18,
		'class' => 3),
	array(
		'name' => 'Sergeant',
		'short_name' => 'SGT',
		'image' => 'd-e5',
		'order' => 18,
		'class' => 4),
		
	array(
		'name' => 'Petty Officer 3rd Class',
		'short_name' => 'PO3',
		'image' => 'b-e4',
		'order' => 19,
		'class' => 1),
	array(
		'name' => 'Petty Officer 3rd Class',
		'short_name' => 'PO3',
		'image' => 's-e4',
		'order' => 19,
		'class' => 2),
	array(
		'name' => 'Corporal',
		'short_name' => 'CPL',
		'image' => 'm-e4',
		'order' => 19,
		'class' => 3),
	array(
		'name' => 'Corporal',
		'short_name' => 'CPL',
		'image' => 'd-e4',
		'order' => 19,
		'class' => 4),
		
	array(
		'name' => 'Crewman',
		'short_name' => 'CR',
		'image' => 'b-e3',
		'order' => 20,
		'class' => 1),
	array(
		'name' => 'Crewman',
		'short_name' => 'CR',
		'image' => 's-e3',
		'order' => 20,
		'class' => 2),
	array(
		'name' => 'Private 1st Class',
		'short_name' => 'PVT1',
		'image' => 'm-e3',
		'order' => 20,
		'class' => 3),
	array(
		'name' => 'Private 1st Class',
		'short_name' => 'PVT1',
		'image' => 'd-e3',
		'order' => 20,
		'class' => 4),
		
	array(
		'name' => 'Crewman Apprentice',
		'short_name' => 'CRA',
		'image' => 'b-e2',
		'order' => 21,
		'class' => 1),
	array(
		'name' => 'Crewman Apprentice',
		'short_name' => 'CRA',
		'image' => 's-e2',
		'order' => 21,
		'class' => 2),
	array(
		'name' => 'Private E-2',
		'short_name' => 'PVT(E2)',
		'image' => 'm-e2',
		'order' => 21,
		'class' => 3),
	array(
		'name' => 'Private E-2',
		'short_name' => 'PVT(E2)',
		'image' => 'd-e2',
		'order' => 21,
		'class' => 4),
		
	array(
		'name' => 'Crewman Recruit',
		'short_name' => 'CRR',
		'image' => 'b-e1',
		'order' => 22,
		'class' => 1),
	array(
		'name' => 'Crewman Recruit',
		'short_name' => 'CRR',
		'image' => 's-e1',
		'order' => 22,
		'class' => 2),
	array(
		'name' => 'Private E-1',
		'short_name' => 'PVT(E1)',
		'image' => 'm-e1',
		'order' => 22,
		'class' => 3),
	array(
		'name' => 'Private E-1',
		'short_name' => 'PVT(E1)',
		'image' => 'd-e1',
		'order' => 22,
		'class' => 4),
		
	array(
		'name' => '',
		'short_name' => '',
		'image' => 'b-blank',
		'order' => 23,
		'class' => 1),
	array(
		'name' => '',
		'short_name' => '',
		'image' => 's-blank',
		'order' => 23,
		'class' => 2),
	array(
		'name' => '',
		'short_name' => '',
		'image' => 'm-blank',
		'order' => 23,
		'class' => 3),
	array(
		'name' => '',
		'short_name' => '',
		'image' => 'd-blank',
		'order' => 23,
		'class' => 4),
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
		'default' => 1,
		'genre' => $g)
);
