<?php
/**
 * Genre Install Data (BLK)
 *
 * @package		Install
 * @category	Assets
 * @author		Anodyne Productions
 */

$g = 'blank';

$data = array(
	'departments_'.$g 	=> 'depts',
	'ranks_'.$g			=> 'ranks',
	'positions_'.$g		=> 'positions',
	'catalog_ranks'		=> 'catalog_ranks',
);

$depts = array(
	array(
		'name' => 'Department',
		'desc' => "This is a blank department to be used as an example of what should be included in a department record. Please edit this record to match your sim's style and needs or remove the record altogether.",
		'order' => 0),
);

$ranks = array(
	array(
		'name' => 'Blank',
		'short_name' => 'BLANK',
		'image' => '',
		'order' => 0,
		'class' => 1),
);

$positions = array(
	array(
		'name' => 'Position',
		'desc' => "This is a blank position to be used as an example of what should be included in a position record. Please edit this record to match your sim's style and needs or remove the record altogether.",
		'dept_id' => 1,
		'order' => 0,
		'open' => 1,
		'type' => 'senior'),
);

$catalog_ranks = array(
	array(
		'name' => 'Rank Catalogue',
		'location' => 'default',
		'credits' => "This is a blank rank catalogue record to be used as an example of what should be included in a rank catalogue record. Please edit this record to match your ranks or remove the record altogether.",
		'default' => 1,
		'genre' => $g),
);
