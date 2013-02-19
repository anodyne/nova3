<?php
/**
 * Announcement Categories Model
 *
 * @package		Nova
 * @subpackage	Core
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */
 
namespace Nova\Core\Model;

use Model;
use Status;
use AnnouncementModel;

class AnnouncementCategory extends Model {

	protected $table = 'announcement_categories';
	
	protected static $properties = array(
		'id' => array('type' => 'int', 'constraint' => 11, 'auto_increment' => true),
		'name' => array('type' => 'string', 'constraint' => 255, 'default' => ''),
		'status' => array('type' => 'tinyint', 'constraint' => 1, 'default' => Status::ACTIVE),
	);

	/**
	 * Has Many: Announcements
	 */
	public function announcements()
	{
		return $this->hasMany('AnnouncementModel');
	}
}
