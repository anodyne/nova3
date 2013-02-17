<?php
/**
 * Application Rule Model
 *
 * @package		Nova
 * @subpackage	Core
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Nova\Core\Model\Application;

class Rule extends \Model {
	
	protected $table = 'application_rules';
	
	protected static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 11,
			'auto_increment' => true),
		'type' => array(
			'type' => 'string',
			'constraint' => 50,
			'default' => 'global'),
		'condition' => array(
			'type' => 'text',
			'null' => true),
		'users' => array(
			'type' => 'text',
			'null' => true),
	);
}
