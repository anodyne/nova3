<?php
/**
 * Sessions Model
 *
 * @package		Nova
 * @subpackage	Core
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Nova\Core\Model;

class Session extends \Model
{
	protected $table = 'sessions';
	
	protected static $_properties = array(
		'session_id' => array(
			'type' => 'string',
			'constraint' => 40),
		'previous_id' => array(
			'type' => 'string',
			'constraint' => 40),
		'user_agent' => array(
			'type' => 'text'),
		'ip_hash' => array(
			'type' => 'char',
			'constraint' => 32),
		'created' => array(
			'type' => 'int',
			'constraint' => 11),
		'updated' => array(
			'type' => 'int',
			'constraint' => 11),
		'payload' => array(
			'type' => 'longtext'),
	);
}
