<?php
/**
 * Genre Install Data (KLI)
 *
 * @package		Nova
 * @subpackage	Setup
 * @category	Asset
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */

$g = 'kli';

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
		'desc' => "The Command division on a Klingon vessel is made up of the seniormost Klingon officers. Commanding a ship, base or other vessel is considered an honor worthy of song and carries with it the responsibilities of running the ship, base or vessel and carrying out the orders of the Klingon Defense Force.",
		'order' => 0),
	array(
		'name' => 'Tactical',
		'desc' => "When it comes to space battles, there are no finer tacticians and gunners than Klingons. All officers in the Klingon Defense Force undergo signficant tactical training before being given their officer status by the Klingon Oversight Council. Great honor can come from being an excellent tactical officer.",
		'order' => 1),
	array(
		'name' => 'Navigation',
		'desc' => "Much like any warrior in the Tactical division, the Navigation division are known for their bold and innovative battle maneuvers. Warriors in the Navigation division work closely with the Tactical division and understand battle tactics better than most.",
		'order' => 2),
	array(
		'name' => 'Engineering',
		'desc' => "The Klingon Empire isn't known for its engineers. Despite that though, the Klingon Defense Force Order of Engineers is an honorable one with a long history of keeping vessels in battles for greater glory.",
		'order' => 3),
	array(
		'name' => 'Medical',
		'desc' => "Medical and Science services are sparse in the Klingon Empire and as such are in high demand on ships, bases and vessels near the front lines of a conflict. Besides dealing with medical problems, all Klingon physicians also double as science officers for the ship, base or vessel.",
		'order' => 4),
	array(
		'name' => 'Warriors',
		'desc' => "Klingon Warriors are feared throughout the galaxy for their ferocity. There are few other better warriors than a Klingon, even half drunk. Being a warrior and dying honorably in combat is the highest honor a Klingon can achieve.",
		'order' => 5)
);

$groups = array(
	array('name' => 'Klingon Naval Forces', 'order' => 0),
	array('name' => 'Klingon Ground Forces', 'order' => 1),
);

$info = array(
	array('name' => "Fleet Admiral", 'short_name' => "FADM", 'order' => 0, 'group' => 1),
	array('name' => "Admiral", 'short_name' => "ADM", 'order' => 1, 'group' => 1),
	array('name' => "Vice Admiral", 'short_name' => "VADM", 'order' => 2, 'group' => 1),

	array('name' => "General", 'short_name' => "GEN", 'order' => 0, 'group' => 2),
	array('name' => "Lieutenant General", 'short_name' => "LT GEN", 'order' => 1, 'group' => 2),
	array('name' => "Major General", 'short_name' => "MAJ GEN", 'order' => 2, 'group' => 2),

	array('name' => "Captain", 'short_name' => "CAPT", 'order' => 0, 'group' => 3),
	array('name' => "Commander", 'short_name' => "CMDR", 'order' => 1, 'group' => 3),
	array('name' => "Lieutenant Commander", 'short_name' => "LT CMDR", 'order' => 2, 'group' => 3),
	array('name' => "Lieutenant", 'short_name' => "LT", 'order' => 3, 'group' => 3),
	array('name' => "Lieutenant JG", 'short_name' => "LT(JG)", 'order' => 4, 'group' => 3),
	array('name' => "Ensign", 'short_name' => "ENS", 'order' => 5, 'group' => 3),

	array('name' => "Colonel", 'short_name' => "COL", 'order' => 0, 'group' => 4),
	array('name' => "Lieutenant Colonel", 'short_name' => "LT COL", 'order' => 1, 'group' => 4),
	array('name' => "Major", 'short_name' => "MAJ", 'order' => 2, 'group' => 4),
	array('name' => "Captain", 'short_name' => "CAPT", 'order' => 3, 'group' => 4),
	array('name' => "1st Lieutenant", 'short_name' => "1LT", 'order' => 4, 'group' => 4),
	array('name' => "2nd Lieutenant", 'short_name' => "2LT", 'order' => 5, 'group' => 4),

	array('name' => "Master Specialist", 'short_name' => "MSPEC", 'order' => 0, 'group' => 5),
	array('name' => "Specialist", 'short_name' => "SPEC", 'order' => 1, 'group' => 5),

	array('name' => "Sergeant Major", 'short_name' => "SMAJ", 'order' => 0, 'group' => 6),
	array('name' => "Master Sergeant", 'short_name' => "MSGT", 'order' => 1, 'group' => 6),
	array('name' => "Sergeant", 'short_name' => "SGT", 'order' => 2, 'group' => 6),
	array('name' => "Corporal", 'short_name' => "CPL", 'order' => 3, 'group' => 6),
	array('name' => "Warrior 1st Class", 'short_name' => "WAR1", 'order' => 4, 'group' => 6),
	array('name' => "Warrior", 'short_name' => "WAR", 'order' => 5, 'group' => 6),
);

$ranks = array(
	array('info_id' => 1, 'group_id' => 1, 'base' => 'n-a3'),
	array('info_id' => 2, 'group_id' => 1, 'base' => 'n-a2'),
	array('info_id' => 3, 'group_id' => 1, 'base' => 'n-a1'),
	array('info_id' => 7, 'group_id' => 1, 'base' => 'n-o6'),
	array('info_id' => 8, 'group_id' => 1, 'base' => 'n-o5'),
	array('info_id' => 9, 'group_id' => 1, 'base' => 'n-o4'),
	array('info_id' => 10, 'group_id' => 1, 'base' => 'n-o3'),
	array('info_id' => 11, 'group_id' => 1, 'base' => 'n-o2'),
	array('info_id' => 12, 'group_id' => 1, 'base' => 'n-o1'),
	array('info_id' => 19, 'group_id' => 1, 'base' => 'n-w2'),
	array('info_id' => 20, 'group_id' => 1, 'base' => 'n-w1'),
	array('info_id' => 21, 'group_id' => 1, 'base' => 'n-e6'),
	array('info_id' => 22, 'group_id' => 1, 'base' => 'n-e5'),
	array('info_id' => 23, 'group_id' => 1, 'base' => 'n-e4'),
	array('info_id' => 24, 'group_id' => 1, 'base' => 'n-e3'),
	array('info_id' => 25, 'group_id' => 1, 'base' => 'n-e2'),
	array('info_id' => 26, 'group_id' => 1, 'base' => 'n-e1'),

	array('info_id' => 4, 'group_id' => 2, 'base' => 'm-a3'),
	array('info_id' => 5, 'group_id' => 2, 'base' => 'm-a2'),
	array('info_id' => 6, 'group_id' => 2, 'base' => 'm-a1'),
	array('info_id' => 13, 'group_id' => 2, 'base' => 'm-o6'),
	array('info_id' => 14, 'group_id' => 2, 'base' => 'm-o5'),
	array('info_id' => 15, 'group_id' => 2, 'base' => 'm-o4'),
	array('info_id' => 16, 'group_id' => 2, 'base' => 'm-o3'),
	array('info_id' => 17, 'group_id' => 2, 'base' => 'm-o2'),
	array('info_id' => 18, 'group_id' => 2, 'base' => 'm-o1'),
	array('info_id' => 19, 'group_id' => 2, 'base' => 'm-w2'),
	array('info_id' => 20, 'group_id' => 2, 'base' => 'm-w1'),
	array('info_id' => 21, 'group_id' => 2, 'base' => 'm-e6'),
	array('info_id' => 22, 'group_id' => 2, 'base' => 'm-e5'),
	array('info_id' => 23, 'group_id' => 2, 'base' => 'm-e4'),
	array('info_id' => 24, 'group_id' => 2, 'base' => 'm-e3'),
	array('info_id' => 25, 'group_id' => 2, 'base' => 'm-e2'),
	array('info_id' => 26, 'group_id' => 2, 'base' => 'm-e1'),
);

$positions = array(
	array(
		'name' => 'Commanding Officer',
		'desc' => "The commanding officer is the seniormost Klingon aboard a vessel. The position of commanding a ship, base or vessel is seen as an honorable one that carries with it the responsibility of leading warriors into battle and carrying out the orders of the Klingon Defense Force.",
		'dept_id' => 1,
		'order' => 0,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => 'First Officer',
		'desc' => "The first officer is the second in command to the commanding officer and assists them in carrying out their duties. According to Klingon tradition, it is the responsibility of the first officer to assassinate his captain if the captain becomes weak or unable to perform.",
		'dept_id' => 1,
		'order' => 1,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => 'Second Officer',
		'desc' => "The second officer is the third in command to the commanding officer and assists the first officer in carrying out the necessary duties on the ship, base or vessel. According to Klingon tradition, it is the responsibility of the second officer to assassinate the first officer if they becomes weak or unable to perform.",
		'dept_id' => 1,
		'order' => 1,
		'open' => 1,
		'type' => 'officer'),
	
	array(
		'name' => 'Chief Tactical Officer',
		'desc' => "The Chief Tactical Officer is the seniormost tactician aboard a Klingon vessel. The position of Chief Tactical Officer is one of the few positions a Klingon Commanding Officer is allowed to pick themselves. It is considered a high honor to be selected to be the Chief Tactical Officer aboard a Klingon vessel. In addition to laying out tactical strategies with the Command officers, the Chief Tactical Officer oversees all weapons and armaments on the ship, base or vessel.",
		'dept_id' => 2,
		'order' => 0,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => 'Second Tactical Officer',
		'desc' => "The Second Tactical Officer assists the Chief Tactical Officer with their duties in maintaining the weapons and armaments of the ship, base or vessel, whether that's ship weapons or the armory.",
		'dept_id' => 2,
		'order' => 1,
		'open' => 1,
		'type' => 'officer'),
	array(
		'name' => 'Tactical Officer',
		'desc' => "Tactical Officers are one of the most widely available positions in the Klingon Defense Force. Distinguished Tactical Officers can often go on to become Second Tactical Officers. Duties of the tactical officers is mainly carrying out the orders of their superiors and helping train and develop gunners into tactical officers.",
		'dept_id' => 2,
		'order' => 2,
		'open' => 1,
		'type' => 'officer'),
	array(
		'name' => 'Gunner',
		'desc' => "The gunner is primarily responsible for manning the weapons systems on a Klingon ship, base or vessel. In most cases, gunners go on to become tactical officers. Because of the quest for honor, it isn't uncommon for tactical officers to relieve the gunners during battle.",
		'dept_id' => 2,
		'order' => 3,
		'open' => 1,
		'type' => 'enlisted'),
	array(
		'name' => "Gunner's Mate",
		'desc' => "Usually a young warrior on their first assignments, the gunner's mate is on the ship, base or vessel to learn the ins and outs of life aboard a Klingon vessel and get a taste of their first battles.",
		'dept_id' => 2,
		'order' => 4,
		'open' => 4,
		'type' => 'enlisted'),
		
	array(
		'name' => 'Chief Navigator',
		'desc' => "After the Tactical division, the Navigation division is one of the most important on a Klingon Vessel. The Chief Navigator is responsible for piloting the vessel and working with the Tactical division for optimal tactical effectiveness during battle. Klingon navigators are known for their bold and innovative navigational tactics during battle and are often known to be unpredictable, lending to their successes during combat.",
		'dept_id' => 3,
		'order' => 0,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => 'Second Navigator',
		'desc' => "The Second Navigator is an experienced navigator who assists the Chief Navigator in their duties piloting the Klingon vessel. In most instances, the Chief Navigator will take over the helm controls during battle, but highly skilled Second Navigators can also be entrusted with the duties. In addition, Second Navigators oversee all auxiliary craft on the ship, base or vessel under the oversight of the Chief Navigator.",
		'dept_id' => 3,
		'order' => 1,
		'open' => 1,
		'type' => 'officer'),
	array(
		'name' => 'Navigator',
		'desc' => "Navigators are usually warriors who wish to move up into the officer ranks and pursue other honorable avenues to ultimate glory. Most navigators have little to know experience piloting and are trained on auxiliary craft and when the vessel isn't engaged in battle. It is rare for a navigator to ever pilot a vessel during combat.",
		'dept_id' => 3,
		'order' => 2,
		'open' => 1,
		'type' => 'enlisted'),
		
	array(
		'name' => 'Chief Engineer',
		'desc' => "The Chief Engineer is the seniormost Klingon engineer aboard a ship, base or vessel and is a member of the Order of Engineers. Klingon engineers have one job: keep the vessel's damage from interfering with continuing the battle. Because of the long history of doing so, most engineers are highly respected and honored on Klingon vessels.",
		'dept_id' => 4,
		'order' => 0,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => 'Second Engineer',
		'desc' => "The Second Engineer is often an aspiring Chief Engineer who has not been granted admission to the Order of Engineers. During their assignment, they are usually evaluated by the Chief Engineer for admission into the order. The Second Engineer's duties are assisting the Chief Engineer in maintaining the ship, base or vessel both leading up to and during battle.",
		'dept_id' => 4,
		'order' => 1,
		'open' => 1,
		'type' => 'officer'),
	array(
		'name' => 'Engineer',
		'desc' => "Klingon engineers are usually young officers on some of their first assignments. Due to the limitd number of engineers available in the Klingon Defense Force, they're often promoted to Second Engineer more rapidly than in other departments. Engineers report to the Chief Engineer and are responsible for maintaining the ship, base or vessel in and out of combat.",
		'dept_id' => 4,
		'order' => 2,
		'open' => 6,
		'type' => 'officer'),
	array(
		'name' => 'Damage Control Specialist',
		'desc' => "A Klingon Damage Control Specialist is responsible for reporting all damage to the Chief Engineer and assisting in triaging and repairing damaged systems before they force the Klingon vessel to retreat from battle.",
		'dept_id' => 4,
		'order' => 3,
		'open' => 4,
		'type' => 'officer'),
	array(
		'name' => 'Cloaking Technician',
		'desc' => "Cloaking devices are one of the most difficult pieces of technology for Klingons to deal with. Cloaking Technicians are proficient in repairs and optimization of the cloaking device and often go on to become Chief Engineers in the Klingon Defense Force.",
		'dept_id' => 4,
		'order' => 4,
		'open' => 2,
		'type' => 'officer'),
	array(
		'name' => 'Weapons Systems Specialist',
		'desc' => "One of the most integral engineers on any Klingon ship, base or vessel, the Weapons Systems Specialist is responsible for the maintainence of the tactical hardware found throughout the ship, whether it's shipboard weapons or the armory.",
		'dept_id' => 4,
		'order' => 5,
		'open' => 4,
		'type' => 'officer'),
		
	array(
		'name' => 'Chief Physician',
		'desc' => "The Chief Physician is tasked with the physical well-being of the crew and providing medical assistance where needed. In many cases, the Chief Physician will be charged with assisting wounded warriors in attaining a more honorable death than lying on a bed waiting to die. In addition, physicians carry the added responsibility of being the science officers aboard a Klingon vessel.",
		'dept_id' => 5,
		'order' => 0,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => 'Physician',
		'desc' => "While rare on smaller vessels, some Klingon vessels and bases have more than one physician who aids the Chief Physician in their medical and scientific duties. On medium-sized vessels, a physician will usually take on the duties the Chief Physician prefers not to do. Like Chief Physicians, normal physicians carry the added responsibility of being the science officers aboard a Klingon ship, base or vessel.",
		'dept_id' => 5,
		'order' => 1,
		'open' => 3,
		'type' => 'officer'),
		
	array(
		'name' => 'Chief Warrior',
		'desc' => "While most warriors on a Klingon ship, base or vessel are enlisted, the Chief Warrior is an officer and highly decorated warrior with a vast amount of combat experience. In many cases, Chief Warriors have been admitted to the Order of the Bat'leth during their time as a Chief Warrior.\r\n\r\nThe Chief Warrior is responsible for ground combat tactical decisions and leading Klingon warriors into battle, be it on a planet or on another vessel.",
		'dept_id' => 6,
		'order' => 0,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => 'Second Warrior',
		'desc' => "The Second Warrior is a respected officer and warrior who reports to the Chief Warrior and is responsible for assisting the Chief Warrior in their duties. In some rare cases, Second Warriors are also members of the Order of the Bat'leth. In addition to assisting with tactical decisions, the Second Warrior is most often responsible for shipboard security as well under the oversight of the Chief Warrior.",
		'dept_id' => 6,
		'order' => 1,
		'open' => 1,
		'type' => 'officer'),
	array(
		'name' => 'Squad Leader',
		'desc' => "Warriors are broken down into squads that are commanded by junior officers with combat experience or highly senior enlisted warriors. Working with the Chief and Second Warriors, they are responsible for executing battle orders.",
		'dept_id' => 6,
		'order' => 2,
		'open' => 1,
		'type' => 'officer'),
	array(
		'name' => 'Master-at-Arms',
		'desc' => "The Master-at-Arms is primarily responsible for training warriors on the things they need most. In many cases, this includes continued training on hand-to-hand combat, but can also include training on explosives, infiltration and more technical matters of an upcoming assignment.",
		'dept_id' => 6,
		'order' => 3,
		'open' => 1,
		'type' => 'enlisted'),
	array(
		'name' => 'Warrior',
		'desc' => "Comprising the highest majority of Klingons on a ship, warriors are the lifeblood of the Klingon Defense Force and strive to bring glory and honor to their houses through battle.",
		'dept_id' => 6,
		'order' => 4,
		'open' => 20,
		'type' => 'enlisted')
);

$catalog_ranks = array(
	array(
		'name' => 'Duty Uniform',
		'location' => 'default',
		'credits' => "The Klingon rank sets was created by Kuro-chan of Kuro-RPG. The rankset (and others) can be found at <a href='http://www.kuro-rpg.net' target='_blank'>Kuro-RPG</a>. Please do not copy or modify the images.",
		'default' => 1,
		'genre' => $g)
);