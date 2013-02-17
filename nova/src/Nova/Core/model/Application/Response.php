<?php
/**
 * Application Response Model
 *
 * @package		Nova
 * @subpackage	Core
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Nova\Core\Model\Application;

class Response extends \Model {
	
	const COMMENT		= 1; // comment on an application
	const VOTE 			= 2; // vote on an application
	const RESPONSE		= 3; // the response sent to the user
	const EMAIL			= 4; // an email to the applicant

	protected $table = 'application_responses';
	
	protected static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 11,
			'auto_increment' => true),
		'app_id' => array(
			'type' => 'int',
			'constraint' => 11),
		'user_id' => array(
			'type' => 'int',
			'constraint' => 11),
		'type' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => 1),
		'content' => array(
			'type' => 'text',
			'null' => true),
		'created_at' => array(
			'type' => 'datetime',
			'null' => true),
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
		'user' => array(
			'model_to' => '\\Model_User',
			'key_to' => 'id',
			'key_from' => 'user_id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);

	/**
	 * Observers
	 */
	protected static $_observers = array(
		'Orm\\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => true,
		),
	);
}
