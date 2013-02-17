<?php
/**
 * Comments Model
 *
 * @package		Nova
 * @subpackage	Core
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Nova\Core\Model;

class Comment extends \Model
{
	protected $table = 'comments';
	
	protected static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 11,
			'auto_increment' => true),
		'user_id' => array(
			'type' => 'int',
			'constraint' => 11),
		'character_id' => array(
			'type' => 'int',
			'constraint' => 11),
		'type' => array(
			'type' => 'string',
			'constraint' => 100,
			'null' => true),
		'item_id' => array(
			'type' => 'int',
			'constraint' => 11),
		'content' => array(
			'type' => 'text',
			'null' => true),
		'status' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => \Status::ACTIVE),
		'created_at' => array(
			'type' => 'datetime'),
	);
}
