<?php
/**
 * Application Reviewer Model
 *
 * @package		Nova
 * @subpackage	Core
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Nova\Core\Model\Application;

class Reviewer extends \Model {
	
	protected $table = 'application_reviewers';
	
	protected static $_properties = array(
		'id' => array(
			'type' => 'bigint',
			'constraint' => 20,
			'auto_increment' => true),
		'app_id' => array(
			'type' => 'int',
			'constraint' => 11),
		'user_id' => array(
			'type' => 'int',
			'constraint' => 11),
	);

	/**
	 * Relationships
	 */
	protected static $_belongs_to = array(
		'app' => array(
			'model_to' => '\\Model_Application',
			'key_to' => 'id',
			'key_from' => 'app_id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);
}
