<?php

return array(

	'add' 		=> "add :0",
	'clear'		=> "clear :0",
	'create' 	=> "create :0",
	'delete' 	=> "delete :0",
	'duplicate'	=> "duplicate :0",
	'edit' 		=> "edit :0",
	'manage' 	=> "manage :0",
	'new' 		=> "new :0",
	'remove'	=> "remove :0",
	'search'	=> "search :0",
	'show'		=> "show :0",
	'update' 	=> "update :0",
	'validate'	=> "validation :0",
	'view'		=> "view :0",

	'alert' => array(
		'failure' => array(
			'add' 		=> ":0 addition failed, please try again.",
			'create' 	=> ":0 creation failed, please try again.",
			'delete' 	=> ":0 deletion failed, please try again.",
			'duplicate'	=> ":0 duplication failed, please try again.",
			'save'		=> ":0 save failed, please try again.",
			'submit'	=> ":0 submission failed, please try again.",
			'update'	=> ":0 update failed, please try again.",
		),
		'success' => array(
			'add' 		=> ":0 added.",
			'create' 	=> ":0 created.",
			'delete' 	=> ":0 deleted.",
			'duplicate'	=> ":0 duplicated.",
			'save'	 	=> ":0 saved.",
			'sent'		=> ":0 sent.",
			'submit'	=> ":0 submitted.",
			'update' 	=> ":0 updated.",
		),
	),

	'admin' => [
		'forms' => [
			'changeFormKey' => "<strong>Warning:</strong> Changing a form key can cause issues with a form. Do so only if you know what you're doing!",
			'tabUpdateSections' => "Select the new tab that sections in the :0 tab will be moved to.",
			'tabLinkId' => "Link IDs are used to link a tab with its content on the page. They must be unique and contain no spaces (camelCase is fine) (e.g. one, html, general, characterThings).",
			'order' => "The order can also be changed by dragging-and-dropping the items on the previous page.",

			'valueCreation' => "Dropdown menu values can be added once you've created the field.",
			'valuesDropdownOnly' => "You can only move values from one dropdown menu to another.",
			'valuesContent' => "The content is what will appear to the user in the dropdown menu.",
			'valuesValue' => "The value is what will be stored in the database and appear on the page.",
			'sectionUpdateFields' => "Select the new section you'd like any fields in the :0 section to be moved to.",
			'fieldRestriction' => "Fields can be restricted so only someone with the above role (or anyone who has a role that inherits the above role) can edit the data."
		],

		'pages' => [
			'removeConfirm' => "Are you sure you want to delete the :0 <strong>:1</strong>? While this won't remove any custom page, it will remove the ability to navigate to the page. If you want to restore the route to your custom page, you will need to create a new page route.",
			'uri' => "Optional URI parameters can be specified with a question mark: <code>{id?}</code>",
			'resource' => "Resources must include the namespace: <code>App\Controllers\Foo@method</code>",
			'name' => "If you are overriding an existing page, make sure the name matches exactly.",
		],
	],

	'arc' => array(
		'admin' => array(
			'users' => "Be careful not to remove a decision maker from the review.",
		),
		'addComment' => "Enter your :0 on the :1 here",
		'email' => "You can send an email to the applicant to request additional information or tell them about the status of their application. This email will be added to the Review History and will be viewable by all members of the review.",
		'involved' => ":0 involved in this review",
		'voted' => ":0 voted :1 on this application.",
	),

	'backToIndex' => 'Back to index',
	'backToSite' => 'Back to site',
	'back' => "Back to :0",
	
	'cancelPasswordReset' => "Cancel password reset",

	'deleteConfirm' => "Are you sure you want to delete the :0 <strong>:1</strong>? This action is permanent and cannot be undone!",

	'duplicateConfirm' => "This will duplicate the :0 <strong>:1</strong>. Are you sure you want to proceed?",

	'forgotPassword' => "Forgot your password?",

	'javascript' => "You need to have Javascript turned on to use all of Nova 3's features.",

	'join' => array(
		'userInfo' => ":0 information (including :1 and :2) is only viewable by members of the :3 when they are logged in to the site. None of your information can be seen by visitors to the site or anyone who is not logged in.",
		'userFound' => "Your :0 record was found. If you're trying to apply with a new :1, you can continue to the :1 section. If you're trying to re-activate an existing :1, please contact the :2.",
		'userFormReset' => 'Made a mistake? <a href="#" id="userFormReset">Reset the :0 form</a>.',
		'welcomeBack' => "welcome back!",
	),

	'pleaseNote' => "please note",

	'refresh' => "Please refresh the page to view your changes.",

	'flash' => array(
		'failure' => ":0 :1 failed, please try again.",
		'success' => ":0 :1!",
	),

	'login' => array(
		'resetSuccess' => "Your password reset was accepted. You'll receive an email shortly with a confirmation link. Once you've confirmed your password reset, your new password will be active.",

		'logout' => "You have successfully logged out. You can return to the <a href=':0'>main page</a> or <a href=':1'>log in</a> again.",
	),

	'ranks' => array(
		'changeGroup' => "Select the new :0 group for any :1 currently in this :0 group.",
		'changeInfo' => "Select the new :0 info item for any :1 currently using this :0 info record.",
		'infoGroupExplain' => "Info groups are used solely for presentation purposes.",
	),

	'roles' => array(
		'duplicateSysAdminHeader' => "With Great Power Comes Great Responsibility!",
		'duplicateSysAdminText' => "You are about to duplicate the System Administrator role. Make sure you understand the impact of assigning :0 to this role.",
		'removeRole' => "Select the new role you would like any :0 in the :1 role to be moved to.",
		'chooseTaskComponent' => "Choose from one of the existing task components or create your own.",
		'chooseTaskAction' => "Choose from one of the existing task actions (create, read, update, delete) or create your own.",
		'chooseTaskLevel' => "Task levels can be used to further differentiate access within an action.",
		'inheritedTask' => "Inherited from the <strong>:0</strong> role.",
		'inheritedTaskProcessing' => "Processing inherited role tasks. Please wait...",
	),

	'users' => array(
		'add' => "You can add a new :0 to the system by entering their :1 and :2 and clicking submit. During creation, a :3 will be generated for the :0 and emailed to them. Once the :0 is created, you can associate :4 with their account.",
		'doneSearching' => "Done searching? Head <a href='#' rel='change_user_view' id='show_actives'>back</a> to the list of :0 :1.",
		'remove' => "Are you sure you want to remove <strong>:0</strong>? In addition to removing :0, this will also remove all :1 associated with :0. This action is permanent and cannot be done. Are you sure you want to continue?",
		'override' => "Overriding the existing associations will change the ownership of the :0 to the new :1.",
	),

	'help' => array(
		'user_account' => "Edit your user details and bio, change your preferences and request an LOA from your account page"
	),

);