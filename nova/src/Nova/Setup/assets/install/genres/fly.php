<?php
/**
 * Genre Install Data (BAJ)
 *
 * @package		Install
 * @category	Assets
 * @author		Anodyne Productions
 * @author		Indigo (Anodyne forums)
 */

$g = 'fly';

$data = array(
	'departments_'.$g 	=> 'depts',
	'ranks_'.$g			=> 'ranks',
	'positions_'.$g		=> 'positions',
	'catalog_ranks'		=> 'catalog_ranks',
);

$depts = array(
	array(
		'name' => 'Crew',
		'desc' => "Individuals who live and work on the ship.",
		'order' => 0),
	array(
		'name' => 'Passengers',
		'desc' => "Individuals who pay for passage and are not considered part of the crew.",
		'order' => 1)
);

$ranks = array(
	/*
		this rank needs to stay here as it protects against errors being thrown
		in the event that someone's rank field gets blown away
	*/
	array(
		'name' => '',
		'short_name' => '',
		'image' => '',
		'order' => 0,
		'class' => 0)
);

$positions = array(
	array(
		'name' => 'Captain',
		'desc' => "Individual in command of the vessel, usually also the owner of record responsible for management of the ship's operations.",
		'dept_id' => 1,
		'order' => 0,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => 'Executive Officer',
		'desc' => "Second in command of the vessel responsible for management of ship's operations under the direction of the Captain. The XO reports directly to the Captain.",
		'dept_id' => 1,
		'order' => 1,
		'open' => 1,
		'type' => 'senior'),
	array(
		'name' => 'Pilot',
		'desc' => "Individual responsible primarily for navigation and piloting the ship with other duties when the ship has landed such as purchasing fuel. The pilot accepts orders from the XO or the Captain but reports directly to the Captain.",
		'dept_id' => 1,
		'order' => 2,
		'open' => 1,
		'type' => 'crew'),
	array(
		'name' => 'Mechanic',
		'desc' => "Individual responsible for repair and upkeep of the vessel as well as maintaining an inventory of supplies needed for emergency repairs in space. The mechanic accepts orders from the XO or Captain but reports directly to the Captain.",
		'dept_id' => 1,
		'order' => 3,
		'open' => 1,
		'type' => 'crew'),
	array(
		'name' => 'Muscle/Gun Hand',
		'desc' => "Individuals adept with weapons used for protection of the ship and assorted other tasks. Works under the direction of the XO or Captain but reports directly to the Captain.",
		'dept_id' => 1,
		'order' => 4,
		'open' => 2,
		'type' => 'crew'),
	array(
		'name' => 'Companion',
		'desc' => "Guild-registered, the companion rents space on the ship and works independent of the crew. Many worlds will not let a vessel land without a companion on board. The Companion pays for space on the ship and does not report to the Captain. Instead, the Companion must work with the Captain to negotiate ports of call that are mutually beneficial.",
		'dept_id' => 1,
		'order' => 5,
		'open' => 1,
		'type' => 'crew'),
);

$catalog_ranks = array(
	array(
		'name' => 'Canon Ranks',
		'location' => 'default',
		'credits' => "The rank sets used in Nova were created by Kuro-chan of Kuro-RPG. The ranksets can be found at <a href='http://www.kuro-rpg.net' target='_blank'>Kuro-RPG</a>. Please do not copy or modify the images.",
		'default' => 1,
		'genre' => $g)
);
