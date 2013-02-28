<?php
/**
 * Genre Install Data (DND)
 *
 * @package		Install
 * @category	Assets
 * @author		Anodyne Productions
 * @author		Wade Deurkes
 */

$g = 'dnd';

$data = array(
	'departments_'.$g 	=> 'depts',
	'ranks_'.$g			=> 'ranks',
	'positions_'.$g		=> 'positions',
	'catalog_ranks'		=> 'catalog_ranks',
);

$depts = array(
	array(
		'name' => 'Game Administrators',
		'desc' => "Game Administrators are those who organize and run the various adventures. These are non-playing characters. Posts from a Game Administrator should be viewed as out of character unless otherwise instructed.",
		'order' => 0),
	array(
		'name' => 'Warriors',
		'desc' => "A class made up of characters who have exceptional combat capability and unequaled skill with weapons.",
		'order' => 1),
	array(
		'name' => 'Magic Users',
		'desc' => "A class made up of characters who are schooled in the arcane arts.",
		'order' => 2),
	array(
		'name' => 'Priests',
		'desc' => "A class made up of characters who cast divine spells and are also capable in combat.",
		'order' => 3),
	array(
		'name' => 'Thieves',
		'desc' => "A class made up of characters who primarily rely on stealth rather than brute force or magical ability.",
		'order' => 4),
);

$ranks = array(
	array(
		'name' => 'Dungeon Master',
		'short_name' => 'DM',
		'image' => 'dm',
		'order' => 0,
		'class' => 1),
	array(
		'name' => 'Game Master',
		'short_name' => 'GM',
		'image' => 'gm',
		'order' => 1,
		'class' => 1),
	array(
		'name' => 'Referee',
		'short_name' => 'REF',
		'image' => 'ref',
		'order' => 2,
		'class' => 1),
		
	array(
		'name' => 'Fighter (Level 20)',
		'short_name' => 'F20',
		'image' => 'fighter-20',
		'order' => 0,
		'class' => 2),
	array(
		'name' => 'Fighter (Level 19)',
		'short_name' => 'F19',
		'image' => 'fighter-19',
		'order' => 1,
		'class' => 2),
	array(
		'name' => 'Fighter (Level 18)',
		'short_name' => 'F18',
		'image' => 'fighter-18',
		'order' => 2,
		'class' => 2),
	array(
		'name' => 'Fighter (Level 17)',
		'short_name' => 'F17',
		'image' => 'fighter-17',
		'order' => 3,
		'class' => 2),
	array(
		'name' => 'Fighter (Level 16)',
		'short_name' => 'F16',
		'image' => 'fighter-16',
		'order' => 4,
		'class' => 2),
	array(
		'name' => 'Fighter (Level 15)',
		'short_name' => 'F15',
		'image' => 'fighter-15',
		'order' => 5,
		'class' => 2),
	array(
		'name' => 'Fighter (Level 14)',
		'short_name' => 'F14',
		'image' => 'fighter-14',
		'order' => 6,
		'class' => 2),
	array(
		'name' => 'Fighter (Level 13)',
		'short_name' => 'F13',
		'image' => 'fighter-13',
		'order' => 7,
		'class' => 2),
	array(
		'name' => 'Fighter (Level 12)',
		'short_name' => 'F12',
		'image' => 'fighter-12',
		'order' => 8,
		'class' => 2),
	array(
		'name' => 'Fighter (Level 11)',
		'short_name' => 'F11',
		'image' => 'fighter-11',
		'order' => 9,
		'class' => 2),
	array(
		'name' => 'Fighter (Level 10)',
		'short_name' => 'F10',
		'image' => 'fighter-10',
		'order' => 10,
		'class' => 2),
	array(
		'name' => 'Fighter (Level 9)',
		'short_name' => 'F9',
		'image' => 'fighter-9',
		'order' => 11,
		'class' => 2),
	array(
		'name' => 'Fighter (Level 8)',
		'short_name' => 'F8',
		'image' => 'fighter-8',
		'order' => 12,
		'class' => 2),
	array(
		'name' => 'Fighter (Level 7)',
		'short_name' => 'F7',
		'image' => 'fighter-7',
		'order' => 13,
		'class' => 2),
	array(
		'name' => 'Fighter (Level 6)',
		'short_name' => 'F6',
		'image' => 'fighter-6',
		'order' => 14,
		'class' => 2),
	array(
		'name' => 'Fighter (Level 5)',
		'short_name' => 'F5',
		'image' => 'fighter-5',
		'order' => 15,
		'class' => 2),
	array(
		'name' => 'Fighter (Level 4)',
		'short_name' => 'F4',
		'image' => 'fighter-4',
		'order' => 16,
		'class' => 2),
	array(
		'name' => 'Fighter (Level 3)',
		'short_name' => 'F3',
		'image' => 'fighter-3',
		'order' => 17,
		'class' => 2),
	array(
		'name' => 'Fighter (Level 2)',
		'short_name' => 'F2',
		'image' => 'fighter-2',
		'order' => 18,
		'class' => 2),
	array(
		'name' => 'Fighter (Level 1)',
		'short_name' => 'F1',
		'image' => 'fighter-1',
		'order' => 19,
		'class' => 2),
		
	array(
		'name' => 'Wizard (Level 20)',
		'short_name' => 'W20',
		'image' => 'wizard-20',
		'order' => 0,
		'class' => 3),
	array(
		'name' => 'Wizard (Level 19)',
		'short_name' => 'W19',
		'image' => 'wizard-19',
		'order' => 1,
		'class' => 3),
	array(
		'name' => 'Wizard (Level 18)',
		'short_name' => 'W18',
		'image' => 'wizard-18',
		'order' => 2,
		'class' => 3),
	array(
		'name' => 'Wizard (Level 17)',
		'short_name' => 'W17',
		'image' => 'wizard-17',
		'order' => 3,
		'class' => 3),
	array(
		'name' => 'Wizard (Level 16)',
		'short_name' => 'W16',
		'image' => 'wizard-16',
		'order' => 4,
		'class' => 3),
	array(
		'name' => 'Wizard (Level 15)',
		'short_name' => 'W15',
		'image' => 'wizard-15',
		'order' => 5,
		'class' => 3),
	array(
		'name' => 'Wizard (Level 14)',
		'short_name' => 'W14',
		'image' => 'wizard-14',
		'order' => 6,
		'class' => 3),
	array(
		'name' => 'Wizard (Level 13)',
		'short_name' => 'W13',
		'image' => 'wizard-13',
		'order' => 7,
		'class' => 3),
	array(
		'name' => 'Wizard (Level 12)',
		'short_name' => 'W12',
		'image' => 'wizard-12',
		'order' => 8,
		'class' => 3),
	array(
		'name' => 'Wizard (Level 11)',
		'short_name' => 'W11',
		'image' => 'wizard-11',
		'order' => 9,
		'class' => 3),
	array(
		'name' => 'Wizard (Level 10)',
		'short_name' => 'W10',
		'image' => 'wizard-10',
		'order' => 10,
		'class' => 3),
	array(
		'name' => 'Wizard (Level 9)',
		'short_name' => 'W9',
		'image' => 'wizard-9',
		'order' => 11,
		'class' => 3),
	array(
		'name' => 'Wizard (Level 8)',
		'short_name' => 'W8',
		'image' => 'wizard-8',
		'order' => 12,
		'class' => 3),
	array(
		'name' => 'Wizard (Level 7)',
		'short_name' => 'W7',
		'image' => 'wizard-7',
		'order' => 13,
		'class' => 3),
	array(
		'name' => 'Wizard (Level 6)',
		'short_name' => 'W6',
		'image' => 'wizard-6',
		'order' => 14,
		'class' => 3),
	array(
		'name' => 'Wizard (Level 5)',
		'short_name' => 'W5',
		'image' => 'wizard-5',
		'order' => 15,
		'class' => 3),
	array(
		'name' => 'Wizard (Level 4)',
		'short_name' => 'W4',
		'image' => 'wizard-4',
		'order' => 16,
		'class' => 3),
	array(
		'name' => 'Wizard (Level 3)',
		'short_name' => 'W3',
		'image' => 'wizard-3',
		'order' => 17,
		'class' => 3),
	array(
		'name' => 'Wizard (Level 2)',
		'short_name' => 'W2',
		'image' => 'wizard-2',
		'order' => 18,
		'class' => 3),
	array(
		'name' => 'Wizard (Level 1)',
		'short_name' => 'W1',
		'image' => 'wizard-1',
		'order' => 19,
		'class' => 3),
		
	array(
		'name' => 'Priest (Level 20)',
		'short_name' => 'P20',
		'image' => 'priest-20',
		'order' => 0,
		'class' => 4),
	array(
		'name' => 'Priest (Level 19)',
		'short_name' => 'P19',
		'image' => 'priest-19',
		'order' => 1,
		'class' => 4),
	array(
		'name' => 'Priest (Level 18)',
		'short_name' => 'P18',
		'image' => 'priest-18',
		'order' => 2,
		'class' => 4),
	array(
		'name' => 'Priest (Level 17)',
		'short_name' => 'P17',
		'image' => 'priest-17',
		'order' => 3,
		'class' => 4),
	array(
		'name' => 'Priest (Level 16)',
		'short_name' => 'P16',
		'image' => 'priest-16',
		'order' => 4,
		'class' => 4),
	array(
		'name' => 'Priest (Level 15)',
		'short_name' => 'P15',
		'image' => 'priest-15',
		'order' => 5,
		'class' => 4),
	array(
		'name' => 'Priest (Level 14)',
		'short_name' => 'P14',
		'image' => 'priest-14',
		'order' => 6,
		'class' => 4),
	array(
		'name' => 'Priest (Level 13)',
		'short_name' => 'P13',
		'image' => 'priest-13',
		'order' => 7,
		'class' => 4),
	array(
		'name' => 'Priest (Level 12)',
		'short_name' => 'P12',
		'image' => 'priest-12',
		'order' => 8,
		'class' => 4),
	array(
		'name' => 'Priest (Level 11)',
		'short_name' => 'P11',
		'image' => 'priest-11',
		'order' => 9,
		'class' => 4),
	array(
		'name' => 'Priest (Level 10)',
		'short_name' => 'P10',
		'image' => 'priest-10',
		'order' => 10,
		'class' => 4),
	array(
		'name' => 'Priest (Level 9)',
		'short_name' => 'P9',
		'image' => 'priest-9',
		'order' => 11,
		'class' => 4),
	array(
		'name' => 'Priest (Level 8)',
		'short_name' => 'P8',
		'image' => 'priest-8',
		'order' => 12,
		'class' => 4),
	array(
		'name' => 'Priest (Level 7)',
		'short_name' => 'P7',
		'image' => 'priest-7',
		'order' => 13,
		'class' => 4),
	array(
		'name' => 'Priest (Level 6)',
		'short_name' => 'P6',
		'image' => 'priest-6',
		'order' => 14,
		'class' => 4),
	array(
		'name' => 'Priest (Level 5)',
		'short_name' => 'P5',
		'image' => 'priest-5',
		'order' => 15,
		'class' => 4),
	array(
		'name' => 'Priest (Level 4)',
		'short_name' => 'P4',
		'image' => 'priest-4',
		'order' => 16,
		'class' => 4),
	array(
		'name' => 'Priest (Level 3)',
		'short_name' => 'P3',
		'image' => 'priest-3',
		'order' => 17,
		'class' => 4),
	array(
		'name' => 'Priest (Level 2)',
		'short_name' => 'P2',
		'image' => 'priest-2',
		'order' => 18,
		'class' => 4),
	array(
		'name' => 'Priest (Level 1)',
		'short_name' => 'P1',
		'image' => 'priest-1',
		'order' => 19,
		'class' => 4),
		
	array(
		'name' => 'Thief (Level 20)',
		'short_name' => 'T20',
		'image' => 'thief-20',
		'order' => 0,
		'class' => 5),
	array(
		'name' => 'Thief (Level 19)',
		'short_name' => 'T19',
		'image' => 'thief-19',
		'order' => 1,
		'class' => 5),
	array(
		'name' => 'Thief (Level 18)',
		'short_name' => 'T18',
		'image' => 'thief-18',
		'order' => 2,
		'class' => 5),
	array(
		'name' => 'Thief (Level 17)',
		'short_name' => 'T17',
		'image' => 'thief-17',
		'order' => 3,
		'class' => 5),
	array(
		'name' => 'Thief (Level 16)',
		'short_name' => 'T16',
		'image' => 'thief-16',
		'order' => 4,
		'class' => 5),
	array(
		'name' => 'Thief (Level 15)',
		'short_name' => 'T15',
		'image' => 'thief-15',
		'order' => 5,
		'class' => 5),
	array(
		'name' => 'Thief (Level 14)',
		'short_name' => 'T14',
		'image' => 'thief-14',
		'order' => 6,
		'class' => 5),
	array(
		'name' => 'Thief (Level 13)',
		'short_name' => 'T13',
		'image' => 'thief-13',
		'order' => 7,
		'class' => 5),
	array(
		'name' => 'Thief (Level 12)',
		'short_name' => 'T12',
		'image' => 'thief-12',
		'order' => 8,
		'class' => 5),
	array(
		'name' => 'Thief (Level 11)',
		'short_name' => 'T11',
		'image' => 'thief-11',
		'order' => 9,
		'class' => 5),
	array(
		'name' => 'Thief (Level 10)',
		'short_name' => 'T10',
		'image' => 'thief-10',
		'order' => 10,
		'class' => 5),
	array(
		'name' => 'Thief (Level 9)',
		'short_name' => 'T9',
		'image' => 'thief-9',
		'order' => 11,
		'class' => 5),
	array(
		'name' => 'Thief (Level 8)',
		'short_name' => 'T8',
		'image' => 'thief-8',
		'order' => 12,
		'class' => 5),
	array(
		'name' => 'Thief (Level 7)',
		'short_name' => 'T7',
		'image' => 'thief-7',
		'order' => 13,
		'class' => 5),
	array(
		'name' => 'Thief (Level 6)',
		'short_name' => 'T6',
		'image' => 'thief-6',
		'order' => 14,
		'class' => 5),
	array(
		'name' => 'Thief (Level 5)',
		'short_name' => 'T5',
		'image' => 'thief-5',
		'order' => 15,
		'class' => 5),
	array(
		'name' => 'Thief (Level 4)',
		'short_name' => 'T4',
		'image' => 'thief-4',
		'order' => 16,
		'class' => 5),
	array(
		'name' => 'Thief (Level 3)',
		'short_name' => 'T3',
		'image' => 'thief-3',
		'order' => 17,
		'class' => 5),
	array(
		'name' => 'Thief (Level 2)',
		'short_name' => 'T2',
		'image' => 'thief-2',
		'order' => 18,
		'class' => 5),
	array(
		'name' => 'Thief (Level 1)',
		'short_name' => 'T1',
		'image' => 'thief-1',
		'order' => 19,
		'class' => 5)
);

$positions = array(
	array(
		'name' => 'Dungeon Master',
		'desc' => "The Dungeon Master is the highest ranking Game Administrators. They have final say in all things happening on this sim.",
		'dept_id' => 1,
		'order' => 0,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => 'Game Master',
		'desc' => "The difference between the Dungeon Master and the Game Master is the Game Master is the person in charge of a specific adventure.",
		'dept_id' => 1,
		'order' => 1,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => 'Referee',
		'desc' => "Referees maybe appointed by Game Masters or the Dungeon Master to oversee smaller portions of an adventure as needed.",
		'dept_id' => 1,
		'order' => 2,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => 'Fighter',
		'desc' => "A class made up of characters who have exceptional combat capability and unequaled skill with weapons.",
		'dept_id' => 2,
		'order' => 0,
		'open' => 2,
		'type' => 'officer'),
	array(
		'name' => 'Paladin',
		'desc' => "A class made up of characters who are champions of justice and destroyers of evil, with an array of divine powers.",
		'dept_id' => 2,
		'order' => 1,
		'open' => 2,
		'type' => 'officer'),
	array(
		'name' => 'Ranger',
		'desc' => "A class made up of characters who are particularly skilled at adventuring in the wilderness.",
		'dept_id' => 2,
		'order' => 2,
		'open' => 2,
		'type' => 'officer'),
	array(
		'name' => 'Barbarian',
		'desc' => "A class made up of ferocious warriors who use inborn fury and instinct to bring down foes.",
		'dept_id' => 2,
		'order' => 3,
		'open' => 2,
		'type' => 'officer'),
	array(
		'name' => 'Illusionist',
		'desc' => "A class made up of characters who use Illusion spells to deceive the senses or minds of others.",
		'dept_id' => 3,
		'order' => 0,
		'open' => 2,
		'type' => 'officer'),
	array(
		'name' => 'Sorcerer',
		'desc' => "A class made up of characters who have inborn magical ability.",
		'dept_id' => 3,
		'order' => 1,
		'open' => 2,
		'type' => 'officer'),
	array(
		'name' => 'Wizard',
		'desc' => "A class made up of characters who are schooled in the arcane arts.",
		'dept_id' => 3,
		'order' => 2,
		'open' => 2,
		'type' => 'officer'),
	array(
		'name' => 'Necromancer',
		'desc' => "A class made up of characters who use Necromancy spells to manipulate the power of death, unlife, and the life force. Spells involving undead creatures make up a large part of this school.",
		'dept_id' => 3,
		'order' => 3,
		'open' => 2,
		'type' => 'officer'),
	array(
		'name' => 'Abjurer',
		'desc' => "A class made up of characters who use protective spells.",
		'dept_id' => 3,
		'order' => 4,
		'open' => 2,
		'type' => 'officer'),
	array(
		'name' => 'Transmuter',
		'desc' => "A class made up of characters who use Transmutation spells to change the properties of some creature, thing, or condition.",
		'dept_id' => 3,
		'order' => 5,
		'open' => 2,
		'type' => 'officer'),
	array(
		'name' => 'Conjurer',
		'desc' => "A class made up of characters who use spells to bring manifestations of objects, creatures, or some form of energy.",
		'dept_id' => 3,
		'order' => 6,
		'open' => 2,
		'type' => 'officer'),
	array(
		'name' => 'Enchanter',
		'desc' => "A class made up of characters who use Enchantment spells to affect the minds of others, influencing or controlling their behavior.",
		'dept_id' => 3,
		'order' => 7,
		'open' => 2,
		'type' => 'officer'),
	array(
		'name' => 'Cleric',
		'desc' => "A class made up of characters who cast divine spells and are also capable in combat.",
		'dept_id' => 4,
		'order' => 0,
		'open' => 2,
		'type' => 'officer'),
	array(
		'name' => 'Druid',
		'desc' => "A class made up of characters who draw energy from the natural world to cast divine spells and gain special magical powers.",
		'dept_id' => 4,
		'order' => 1,
		'open' => 2,
		'type' => 'officer'),
	array(
		'name' => 'Monk',
		'desc' => "A class made up of characters who are masters of the martial arts and have a number of exotic powers.",
		'dept_id' => 4,
		'order' => 2,
		'open' => 2,
		'type' => 'officer'),
	array(
		'name' => 'Bard',
		'desc' => "A class made up of performers whose music and poetics produce magical effects.",
		'dept_id' => 5,
		'order' => 0,
		'open' => 2,
		'type' => 'officer'),
	array(
		'name' => 'Rogue',
		'desc' => "A class made up of characters who primarily rely on stealth rather than brute force or magical ability.",
		'dept_id' => 5,
		'order' => 1,
		'open' => 2,
		'type' => 'officer'),
);

$catalog_ranks = array(
	array(
		'name' => 'Standard Ranks',
		'location' => 'default',
		'credits' => "The Dungeons and Dragons rank used in Nova were created by David VanScott with assistance from Wade Duerkes. Please do not copy or modify the images.",
		'default' => 1,
		'genre' => $g),
);
