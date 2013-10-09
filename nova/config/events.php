<?php

return [

	'nova.formviewer.created' => ['FormViewerEventHandler@onFormViewerCreated'],

	'nova.user.created' => ['UserEventHandler@onUserCreated'],
	'nova.user.passwordReset' => ['UserEventHandler@onPasswordReset'],

];