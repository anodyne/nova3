<?php
/**
 * Sim Type Model
 *
 * @package		Nova
 * @subpackage	Core
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Nova\Core\Model;

class SimType extends \Model
{
	protected $table = 'sim_types';
	
	protected static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 2,
			'auto_increment' => true),
		'name' => array(
			'type' => 'string',
			'constraint' => 50),
	);
}
