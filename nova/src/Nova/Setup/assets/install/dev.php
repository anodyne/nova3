<?php
/**
 * This data is intended to be used for development purposes only.
 *
 * @package		Nova
 * @subpackage	Setup
 * @category	Asset
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */

/**
 * Info about how to insert the data and where to find the data.
 */
$data = array(
	array(
		'data' => 'characters',
		'model' => '\\Model_Character',
		'method' => 'createItem'),
	array(
		'data' => 'character_positions',
		'model' => '\\Model_Character_Positions',
		'method' => 'createItem'),
	array(
		'data' => 'users',
		'model' => '\\Model_User',
		'method' => 'createItem'),
	array(
		'data' => 'applications',
		'model' => '\\Model_Application',
		'method' => 'createItem'),
	array(
		'data' => 'application_responses',
		'model' => '\\Model_Application_Response',
		'method' => 'createItem'),
	array(
		'data' => 'application_reviewers',
		'model' => '\\Model_Application_Reviewer',
		'method' => 'createItem'),
);

/**
 * Development data.
 */
$applications = array(
	array('user_id' => 1, 'character_id' => 1, 'position_id' => 2, 'status' => \Status::APPROVED),
	array('user_id' => 2, 'character_id' => 2, 'position_id' => 23, 'status' => \Status::APPROVED),
	array('user_id' => 3, 'character_id' => 3, 'position_id' => 29, 'status' => \Status::APPROVED),
	array('user_id' => 4, 'character_id' => 4, 'position_id' => 9, 'status' => \Status::APPROVED),
	array('user_id' => 5, 'character_id' => 5, 'position_id' => 16, 'status' => \Status::APPROVED),
	array('user_id' => 6, 'character_id' => 6, 'position_id' => 13, 'status' => \Status::IN_PROGRESS),
	array('user_id' => 7, 'character_id' => 7, 'position_id' => 47, 'status' => \Status::REJECTED),
);

$application_responses = array(
	array(
		'app_id' => 1,
		'user_id' => 8,
		'type' => \Model_Application_Response::RESPONSE,
		'content' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin quis scelerisque urna. Nulla dapibus diam at nunc suscipit vitae auctor mauris sodales. Nam lobortis lorem sit amet arcu dignissim convallis. Nullam aliquam est facilisis justo sollicitudin ac iaculis mi lobortis. Fusce rutrum hendrerit erat, non sollicitudin urna malesuada nec. Maecenas leo est, pretium ut lobortis at, venenatis quis diam. Suspendisse viverra elit tristique nibh convallis quis facilisis tortor pretium. In tincidunt tempor elementum. Morbi varius justo nec mauris cursus eu rutrum erat egestas. Integer non lacus sed sem pharetra tempus. Donec id imperdiet dui. Cras elementum congue lorem, nec convallis augue scelerisque id. Vivamus eu eros erat. Maecenas sed pulvinar leo. Vestibulum non porttitor tellus.

Cras odio enim, fringilla et sodales sed, varius ut justo. Fusce semper risus at mi rhoncus vitae mollis turpis pretium. Integer volutpat, odio non aliquam ultrices, libero nisi ullamcorper quam, eget congue arcu dolor non diam. Suspendisse cursus leo vitae augue tincidunt pretium. Suspendisse volutpat leo non mi mattis accumsan. Suspendisse quis magna mi, sed consectetur risus. Proin sit amet libero felis. Sed vel mauris sit amet nisi malesuada scelerisque. Curabitur erat urna, laoreet eget sodales eu, pellentesque sit amet mi. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Sed est elit, mattis vitae ornare ac, facilisis ac lacus.

Vestibulum iaculis fermentum massa, nec molestie eros molestie at. Duis tincidunt est quis leo accumsan imperdiet. Aliquam erat volutpat. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent et eros id eros porta aliquet nec condimentum sapien. Aenean convallis, orci nec bibendum lacinia, tortor nisi ultrices ante, id facilisis ante erat eu libero. Donec interdum ultrices justo, ac fermentum velit aliquam non. In hac habitasse platea dictumst. Phasellus non velit vel risus hendrerit ultrices eu vel massa. Cras pharetra imperdiet porttitor. Suspendisse risus nunc, cursus vel elementum a, auctor eget odio. Morbi aliquam nibh id diam egestas bibendum. Aenean ac nulla odio. Suspendisse potenti. Quisque eleifend ligula lacus, et mollis nulla."),

	array(
		'app_id' => 2,
		'user_id' => 1,
		'type' => \Model_Application_Response::VOTE,
		'content' => "yes"),
	array(
		'app_id' => 2,
		'user_id' => 1,
		'type' => \Model_Application_Response::COMMENT,
		'content' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin quis scelerisque urna. Nulla dapibus diam at nunc suscipit vitae auctor mauris sodales. Nam lobortis lorem sit amet arcu dignissim convallis. Nullam aliquam est facilisis justo sollicitudin ac iaculis mi lobortis."),
	array(
		'app_id' => 2,
		'user_id' => 8,
		'type' => \Model_Application_Response::VOTE,
		'content' => "yes"),
	array(
		'app_id' => 2,
		'user_id' => 8,
		'type' => \Model_Application_Response::RESPONSE,
		'content' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin quis scelerisque urna. Nulla dapibus diam at nunc suscipit vitae auctor mauris sodales. Nam lobortis lorem sit amet arcu dignissim convallis. Nullam aliquam est facilisis justo sollicitudin ac iaculis mi lobortis. Fusce rutrum hendrerit erat, non sollicitudin urna malesuada nec. Maecenas leo est, pretium ut lobortis at, venenatis quis diam. Suspendisse viverra elit tristique nibh convallis quis facilisis tortor pretium. In tincidunt tempor elementum. Morbi varius justo nec mauris cursus eu rutrum erat egestas. Integer non lacus sed sem pharetra tempus. Donec id imperdiet dui. Cras elementum congue lorem, nec convallis augue scelerisque id. Vivamus eu eros erat. Maecenas sed pulvinar leo. Vestibulum non porttitor tellus.

Cras odio enim, fringilla et sodales sed, varius ut justo. Fusce semper risus at mi rhoncus vitae mollis turpis pretium. Integer volutpat, odio non aliquam ultrices, libero nisi ullamcorper quam, eget congue arcu dolor non diam. Suspendisse cursus leo vitae augue tincidunt pretium. Suspendisse volutpat leo non mi mattis accumsan. Suspendisse quis magna mi, sed consectetur risus. Proin sit amet libero felis. Sed vel mauris sit amet nisi malesuada scelerisque. Curabitur erat urna, laoreet eget sodales eu, pellentesque sit amet mi. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Sed est elit, mattis vitae ornare ac, facilisis ac lacus.

Vestibulum iaculis fermentum massa, nec molestie eros molestie at. Duis tincidunt est quis leo accumsan imperdiet. Aliquam erat volutpat. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent et eros id eros porta aliquet nec condimentum sapien. Aenean convallis, orci nec bibendum lacinia, tortor nisi ultrices ante, id facilisis ante erat eu libero. Donec interdum ultrices justo, ac fermentum velit aliquam non. In hac habitasse platea dictumst. Phasellus non velit vel risus hendrerit ultrices eu vel massa. Cras pharetra imperdiet porttitor. Suspendisse risus nunc, cursus vel elementum a, auctor eget odio. Morbi aliquam nibh id diam egestas bibendum. Aenean ac nulla odio. Suspendisse potenti. Quisque eleifend ligula lacus, et mollis nulla."),

	array(
		'app_id' => 3,
		'user_id' => 1,
		'type' => \Model_Application_Response::VOTE,
		'content' => "yes"),
	array(
		'app_id' => 3,
		'user_id' => 1,
		'type' => \Model_Application_Response::COMMENT,
		'content' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin quis scelerisque urna. Nulla dapibus diam at nunc suscipit vitae auctor mauris sodales. Nam lobortis lorem sit amet arcu dignissim convallis. Nullam aliquam est facilisis justo sollicitudin ac iaculis mi lobortis."),
	array(
		'app_id' => 3,
		'user_id' => 2,
		'type' => \Model_Application_Response::VOTE,
		'content' => "yes"),
	array(
		'app_id' => 3,
		'user_id' => 2,
		'type' => \Model_Application_Response::COMMENT,
		'content' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin quis scelerisque urna. Nulla dapibus diam at nunc suscipit vitae auctor mauris sodales. Nam lobortis lorem sit amet arcu dignissim convallis. Nullam aliquam est facilisis justo sollicitudin ac iaculis mi lobortis."),
	array(
		'app_id' => 3,
		'user_id' => 8,
		'type' => \Model_Application_Response::VOTE,
		'content' => "yes"),
	array(
		'app_id' => 3,
		'user_id' => 8,
		'type' => \Model_Application_Response::RESPONSE,
		'content' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin quis scelerisque urna. Nulla dapibus diam at nunc suscipit vitae auctor mauris sodales. Nam lobortis lorem sit amet arcu dignissim convallis. Nullam aliquam est facilisis justo sollicitudin ac iaculis mi lobortis. Fusce rutrum hendrerit erat, non sollicitudin urna malesuada nec. Maecenas leo est, pretium ut lobortis at, venenatis quis diam. Suspendisse viverra elit tristique nibh convallis quis facilisis tortor pretium. In tincidunt tempor elementum. Morbi varius justo nec mauris cursus eu rutrum erat egestas. Integer non lacus sed sem pharetra tempus. Donec id imperdiet dui. Cras elementum congue lorem, nec convallis augue scelerisque id. Vivamus eu eros erat. Maecenas sed pulvinar leo. Vestibulum non porttitor tellus.

Cras odio enim, fringilla et sodales sed, varius ut justo. Fusce semper risus at mi rhoncus vitae mollis turpis pretium. Integer volutpat, odio non aliquam ultrices, libero nisi ullamcorper quam, eget congue arcu dolor non diam. Suspendisse cursus leo vitae augue tincidunt pretium. Suspendisse volutpat leo non mi mattis accumsan. Suspendisse quis magna mi, sed consectetur risus. Proin sit amet libero felis. Sed vel mauris sit amet nisi malesuada scelerisque. Curabitur erat urna, laoreet eget sodales eu, pellentesque sit amet mi. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Sed est elit, mattis vitae ornare ac, facilisis ac lacus.

Vestibulum iaculis fermentum massa, nec molestie eros molestie at. Duis tincidunt est quis leo accumsan imperdiet. Aliquam erat volutpat. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent et eros id eros porta aliquet nec condimentum sapien. Aenean convallis, orci nec bibendum lacinia, tortor nisi ultrices ante, id facilisis ante erat eu libero. Donec interdum ultrices justo, ac fermentum velit aliquam non. In hac habitasse platea dictumst. Phasellus non velit vel risus hendrerit ultrices eu vel massa. Cras pharetra imperdiet porttitor. Suspendisse risus nunc, cursus vel elementum a, auctor eget odio. Morbi aliquam nibh id diam egestas bibendum. Aenean ac nulla odio. Suspendisse potenti. Quisque eleifend ligula lacus, et mollis nulla."),

	array(
		'app_id' => 4,
		'user_id' => 1,
		'type' => \Model_Application_Response::VOTE,
		'content' => "yes"),
	array(
		'app_id' => 4,
		'user_id' => 1,
		'type' => \Model_Application_Response::COMMENT,
		'content' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin quis scelerisque urna. Nulla dapibus diam at nunc suscipit vitae auctor mauris sodales. Nam lobortis lorem sit amet arcu dignissim convallis. Nullam aliquam est facilisis justo sollicitudin ac iaculis mi lobortis."),
	array(
		'app_id' => 4,
		'user_id' => 3,
		'type' => \Model_Application_Response::VOTE,
		'content' => "no"),
	array(
		'app_id' => 4,
		'user_id' => 2,
		'type' => \Model_Application_Response::VOTE,
		'content' => "yes"),
	array(
		'app_id' => 4,
		'user_id' => 2,
		'type' => \Model_Application_Response::COMMENT,
		'content' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin quis scelerisque urna. Nulla dapibus diam at nunc suscipit vitae auctor mauris sodales. Nam lobortis lorem sit amet arcu dignissim convallis. Nullam aliquam est facilisis justo sollicitudin ac iaculis mi lobortis."),
	array(
		'app_id' => 4,
		'user_id' => 8,
		'type' => \Model_Application_Response::VOTE,
		'content' => "yes"),
	array(
		'app_id' => 4,
		'user_id' => 8,
		'type' => \Model_Application_Response::RESPONSE,
		'content' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin quis scelerisque urna. Nulla dapibus diam at nunc suscipit vitae auctor mauris sodales. Nam lobortis lorem sit amet arcu dignissim convallis. Nullam aliquam est facilisis justo sollicitudin ac iaculis mi lobortis. Fusce rutrum hendrerit erat, non sollicitudin urna malesuada nec. Maecenas leo est, pretium ut lobortis at, venenatis quis diam. Suspendisse viverra elit tristique nibh convallis quis facilisis tortor pretium. In tincidunt tempor elementum. Morbi varius justo nec mauris cursus eu rutrum erat egestas. Integer non lacus sed sem pharetra tempus. Donec id imperdiet dui. Cras elementum congue lorem, nec convallis augue scelerisque id. Vivamus eu eros erat. Maecenas sed pulvinar leo. Vestibulum non porttitor tellus.

Cras odio enim, fringilla et sodales sed, varius ut justo. Fusce semper risus at mi rhoncus vitae mollis turpis pretium. Integer volutpat, odio non aliquam ultrices, libero nisi ullamcorper quam, eget congue arcu dolor non diam. Suspendisse cursus leo vitae augue tincidunt pretium. Suspendisse volutpat leo non mi mattis accumsan. Suspendisse quis magna mi, sed consectetur risus. Proin sit amet libero felis. Sed vel mauris sit amet nisi malesuada scelerisque. Curabitur erat urna, laoreet eget sodales eu, pellentesque sit amet mi. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Sed est elit, mattis vitae ornare ac, facilisis ac lacus.

Vestibulum iaculis fermentum massa, nec molestie eros molestie at. Duis tincidunt est quis leo accumsan imperdiet. Aliquam erat volutpat. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent et eros id eros porta aliquet nec condimentum sapien. Aenean convallis, orci nec bibendum lacinia, tortor nisi ultrices ante, id facilisis ante erat eu libero. Donec interdum ultrices justo, ac fermentum velit aliquam non. In hac habitasse platea dictumst. Phasellus non velit vel risus hendrerit ultrices eu vel massa. Cras pharetra imperdiet porttitor. Suspendisse risus nunc, cursus vel elementum a, auctor eget odio. Morbi aliquam nibh id diam egestas bibendum. Aenean ac nulla odio. Suspendisse potenti. Quisque eleifend ligula lacus, et mollis nulla."),

	array(
		'app_id' => 5,
		'user_id' => 1,
		'type' => \Model_Application_Response::VOTE,
		'content' => "yes"),
	array(
		'app_id' => 5,
		'user_id' => 1,
		'type' => \Model_Application_Response::COMMENT,
		'content' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin quis scelerisque urna. Nulla dapibus diam at nunc suscipit vitae auctor mauris sodales. Nam lobortis lorem sit amet arcu dignissim convallis. Nullam aliquam est facilisis justo sollicitudin ac iaculis mi lobortis."),
	array(
		'app_id' => 5,
		'user_id' => 3,
		'type' => \Model_Application_Response::VOTE,
		'content' => "no"),
	array(
		'app_id' => 5,
		'user_id' => 2,
		'type' => \Model_Application_Response::VOTE,
		'content' => "no"),
	array(
		'app_id' => 5,
		'user_id' => 2,
		'type' => \Model_Application_Response::COMMENT,
		'content' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin quis scelerisque urna. Nulla dapibus diam at nunc suscipit vitae auctor mauris sodales. Nam lobortis lorem sit amet arcu dignissim convallis. Nullam aliquam est facilisis justo sollicitudin ac iaculis mi lobortis."),
	array(
		'app_id' => 5,
		'user_id' => 8,
		'type' => \Model_Application_Response::VOTE,
		'content' => "yes"),
	array(
		'app_id' => 5,
		'user_id' => 8,
		'type' => \Model_Application_Response::COMMENT,
		'content' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin quis scelerisque urna. Nulla dapibus diam at nunc suscipit vitae auctor mauris sodales. Nam lobortis lorem sit amet arcu dignissim convallis. Nullam aliquam est facilisis justo sollicitudin ac iaculis mi lobortis."),
	array(
		'app_id' => 5,
		'user_id' => 8,
		'type' => \Model_Application_Response::RESPONSE,
		'content' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin quis scelerisque urna. Nulla dapibus diam at nunc suscipit vitae auctor mauris sodales. Nam lobortis lorem sit amet arcu dignissim convallis. Nullam aliquam est facilisis justo sollicitudin ac iaculis mi lobortis. Fusce rutrum hendrerit erat, non sollicitudin urna malesuada nec. Maecenas leo est, pretium ut lobortis at, venenatis quis diam. Suspendisse viverra elit tristique nibh convallis quis facilisis tortor pretium. In tincidunt tempor elementum. Morbi varius justo nec mauris cursus eu rutrum erat egestas. Integer non lacus sed sem pharetra tempus. Donec id imperdiet dui. Cras elementum congue lorem, nec convallis augue scelerisque id. Vivamus eu eros erat. Maecenas sed pulvinar leo. Vestibulum non porttitor tellus.

Cras odio enim, fringilla et sodales sed, varius ut justo. Fusce semper risus at mi rhoncus vitae mollis turpis pretium. Integer volutpat, odio non aliquam ultrices, libero nisi ullamcorper quam, eget congue arcu dolor non diam. Suspendisse cursus leo vitae augue tincidunt pretium. Suspendisse volutpat leo non mi mattis accumsan. Suspendisse quis magna mi, sed consectetur risus. Proin sit amet libero felis. Sed vel mauris sit amet nisi malesuada scelerisque. Curabitur erat urna, laoreet eget sodales eu, pellentesque sit amet mi. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Sed est elit, mattis vitae ornare ac, facilisis ac lacus.

Vestibulum iaculis fermentum massa, nec molestie eros molestie at. Duis tincidunt est quis leo accumsan imperdiet. Aliquam erat volutpat. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent et eros id eros porta aliquet nec condimentum sapien. Aenean convallis, orci nec bibendum lacinia, tortor nisi ultrices ante, id facilisis ante erat eu libero. Donec interdum ultrices justo, ac fermentum velit aliquam non. In hac habitasse platea dictumst. Phasellus non velit vel risus hendrerit ultrices eu vel massa. Cras pharetra imperdiet porttitor. Suspendisse risus nunc, cursus vel elementum a, auctor eget odio. Morbi aliquam nibh id diam egestas bibendum. Aenean ac nulla odio. Suspendisse potenti. Quisque eleifend ligula lacus, et mollis nulla."),

	array(
		'app_id' => 6,
		'user_id' => 1,
		'type' => \Model_Application_Response::VOTE,
		'content' => "no"),
	array(
		'app_id' => 6,
		'user_id' => 1,
		'type' => \Model_Application_Response::COMMENT,
		'content' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin quis scelerisque urna. Nulla dapibus diam at nunc suscipit vitae auctor mauris sodales. Nam lobortis lorem sit amet arcu dignissim convallis. Nullam aliquam est facilisis justo sollicitudin ac iaculis mi lobortis."),
	array(
		'app_id' => 6,
		'user_id' => 3,
		'type' => \Model_Application_Response::VOTE,
		'content' => "no"),
	array(
		'app_id' => 6,
		'user_id' => 2,
		'type' => \Model_Application_Response::VOTE,
		'content' => "yes"),
	array(
		'app_id' => 6,
		'user_id' => 2,
		'type' => \Model_Application_Response::COMMENT,
		'content' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin quis scelerisque urna. Nulla dapibus diam at nunc suscipit vitae auctor mauris sodales. Nam lobortis lorem sit amet arcu dignissim convallis. Nullam aliquam est facilisis justo sollicitudin ac iaculis mi lobortis."),
	array(
		'app_id' => 6,
		'user_id' => 8,
		'type' => \Model_Application_Response::VOTE,
		'content' => "yes"),
	
	array(
		'app_id' => 6,
		'user_id' => 8,
		'type' => \Model_Application_Response::VOTE,
		'content' => "no"),
	array(
		'app_id' => 6,
		'user_id' => 8,
		'type' => \Model_Application_Response::COMMENT,
		'content' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin quis scelerisque urna. Nulla dapibus diam at nunc suscipit vitae auctor mauris sodales. Nam lobortis lorem sit amet arcu dignissim convallis. Nullam aliquam est facilisis justo sollicitudin ac iaculis mi lobortis."),
	
	array(
		'app_id' => 7,
		'user_id' => 3,
		'type' => \Model_Application_Response::VOTE,
		'content' => "no"),
	array(
		'app_id' => 7,
		'user_id' => 2,
		'type' => \Model_Application_Response::VOTE,
		'content' => "yes"),
	array(
		'app_id' => 7,
		'user_id' => 2,
		'type' => \Model_Application_Response::COMMENT,
		'content' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin quis scelerisque urna. Nulla dapibus diam at nunc suscipit vitae auctor mauris sodales. Nam lobortis lorem sit amet arcu dignissim convallis. Nullam aliquam est facilisis justo sollicitudin ac iaculis mi lobortis."),
	array(
		'app_id' => 7,
		'user_id' => 8,
		'type' => \Model_Application_Response::VOTE,
		'content' => "no"),
	array(
		'app_id' => 7,
		'user_id' => 8,
		'type' => \Model_Application_Response::RESPONSE,
		'content' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin quis scelerisque urna. Nulla dapibus diam at nunc suscipit vitae auctor mauris sodales. Nam lobortis lorem sit amet arcu dignissim convallis. Nullam aliquam est facilisis justo sollicitudin ac iaculis mi lobortis. Fusce rutrum hendrerit erat, non sollicitudin urna malesuada nec. Maecenas leo est, pretium ut lobortis at, venenatis quis diam. Suspendisse viverra elit tristique nibh convallis quis facilisis tortor pretium. In tincidunt tempor elementum. Morbi varius justo nec mauris cursus eu rutrum erat egestas. Integer non lacus sed sem pharetra tempus. Donec id imperdiet dui. Cras elementum congue lorem, nec convallis augue scelerisque id. Vivamus eu eros erat. Maecenas sed pulvinar leo. Vestibulum non porttitor tellus.

Cras odio enim, fringilla et sodales sed, varius ut justo. Fusce semper risus at mi rhoncus vitae mollis turpis pretium. Integer volutpat, odio non aliquam ultrices, libero nisi ullamcorper quam, eget congue arcu dolor non diam. Suspendisse cursus leo vitae augue tincidunt pretium. Suspendisse volutpat leo non mi mattis accumsan. Suspendisse quis magna mi, sed consectetur risus. Proin sit amet libero felis. Sed vel mauris sit amet nisi malesuada scelerisque. Curabitur erat urna, laoreet eget sodales eu, pellentesque sit amet mi. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Sed est elit, mattis vitae ornare ac, facilisis ac lacus."),
);

$application_reviewers = array(
	array('app_id' => 1, 'user_id' => 8),
	array('app_id' => 2, 'user_id' => 8),
	array('app_id' => 2, 'user_id' => 1),
	array('app_id' => 3, 'user_id' => 8),
	array('app_id' => 3, 'user_id' => 1),
	array('app_id' => 3, 'user_id' => 2),
	array('app_id' => 4, 'user_id' => 8),
	array('app_id' => 4, 'user_id' => 1),
	array('app_id' => 4, 'user_id' => 2),
	array('app_id' => 4, 'user_id' => 3),
	array('app_id' => 5, 'user_id' => 8),
	array('app_id' => 5, 'user_id' => 1),
	array('app_id' => 5, 'user_id' => 2),
	array('app_id' => 5, 'user_id' => 3),
	array('app_id' => 6, 'user_id' => 8),
	array('app_id' => 6, 'user_id' => 1),
	array('app_id' => 6, 'user_id' => 2),
	array('app_id' => 6, 'user_id' => 3),
	array('app_id' => 7, 'user_id' => 8),
	array('app_id' => 7, 'user_id' => 1),
	array('app_id' => 7, 'user_id' => 2),
	array('app_id' => 7, 'user_id' => 3),
);

$characters = array(
	array(
		'user_id' 		=> 1,
		'status' 		=> \Status::ACTIVE,
		'first_name'	=> 'William',
		'last_name'		=> 'Riker',
		'activated' 	=> \Carbon::now('UTC')->toDateTimeString(),
		'rank_id' 		=> 12),
	array(
		'user_id' 		=> 2,
		'status' 		=> \Status::ACTIVE,
		'first_name'	=> 'Data',
		'activated' 	=> \Carbon::now('UTC')->toDateTimeString(),
		'rank_id' 		=> 33),
	array(
		'user_id' 		=> 3,
		'status' 		=> \Status::ACTIVE,
		'first_name'	=> 'Geordi',
		'last_name'		=> 'La Forge',
		'activated' 	=> \Carbon::now('UTC')->toDateTimeString(),
		'rank_id' 		=> 33),
	array(
		'user_id' 		=> 4,
		'status' 		=> \Status::ACTIVE,
		'first_name'	=> 'Wesley',
		'last_name'		=> 'Crusher',
		'activated' 	=> \Carbon::now('UTC')->toDateTimeString(),
		'rank_id' 		=> 16),
	array(
		'user_id' 		=> 5,
		'status' 		=> \Status::INACTIVE,
		'first_name'	=> 'Tasha',
		'last_name'		=> 'Yar',
		'activated' 	=> \Carbon::now('UTC')->toDateTimeString(),
		'rank_id' 		=> 34),
	array(
		'user_id' 		=> 6,
		'status' 		=> \Status::PENDING,
		'first_name'	=> 'Worf',
		'activated' 	=> \Carbon::now('UTC')->toDateTimeString(),
		'rank_id' 		=> 13),
	array(
		'user_id' 		=> 7,
		'status' 		=> \Status::REMOVED,
		'first_name'	=> 'Deanna',
		'last_name'		=> 'Troi',
		'activated' 	=> \Carbon::now('UTC')->toDateTimeString(),
		'rank_id' 		=> 53),
);

$character_positions = array(
	array('character_id' => 1, 'position_id' => 2, 'primary' => 1),
	array('character_id' => 2, 'position_id' => 23, 'primary' => 1),
	array('character_id' => 2, 'position_id' => 3, 'primary' => 0),
	array('character_id' => 3, 'position_id' => 29, 'primary' => 1),
	array('character_id' => 4, 'position_id' => 9, 'primary' => 1),
	array('character_id' => 5, 'position_id' => 16, 'primary' => 1),
	array('character_id' => 6, 'position_id' => 13, 'primary' => 1),
	array('character_id' => 7, 'position_id' => 47, 'primary' => 1),
);

$users = array(
	array(
		'status'		=> \Status::ACTIVE,
		'name'			=> 'Admin',
		'email'			=> 'admin@example.com',
		'password'		=> 'password',
		'character_id'	=> 1,
		'role_id'		=> \Model_Access_Role::ADMIN),
	array(
		'status'		=> \Status::ACTIVE,
		'name'			=> 'Power User',
		'email'			=> 'poweruser@example.com',
		'password'		=> 'password',
		'character_id'	=> 2,
		'role_id'		=> \Model_Access_Role::POWERUSER),
	array(
		'status'		=> \Status::ACTIVE,
		'name'			=> 'Active',
		'email'			=> 'active@example.com',
		'password'		=> 'password',
		'character_id'	=> 3,
		'role_id'		=> \Model_Access_Role::ACTIVE),
	array(
		'status'		=> \Status::ACTIVE,
		'name'			=> 'User',
		'email'			=> 'user@example.com',
		'password'		=> 'password',
		'character_id'	=> 4,
		'role_id'		=> \Model_Access_Role::USER),
	array(
		'status'		=> \Status::INACTIVE,
		'name'			=> 'Inactive',
		'email'			=> 'inactive@example.com',
		'password'		=> 'password',
		'character_id'	=> 5,
		'role_id'		=> \Model_Access_Role::INACTIVE),
	array(
		'status'		=> \Status::PENDING,
		'name'			=> 'In Progress',
		'email'			=> 'inprogress@example.com',
		'password'		=> 'password',
		'character_id'	=> 6,
		'role_id'		=> \Model_Access_Role::USER),
	array(
		'status'		=> \Status::REMOVED,
		'name'			=> 'Rejected',
		'email'			=> 'rejected@example.com',
		'password'		=> 'password',
		'character_id'	=> 7,
		'role_id'		=> \Model_Access_Role::INACTIVE),
);
