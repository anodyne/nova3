<?php

return [

	'nova.form.entryCreated'	=> ['FormViewerEventHandler@onFormViewerCreated'],

	'nova.user.created'			=> ['UserEventHandler@onUserCreated'],
	'nova.user.resetPassword'	=> ['UserEventHandler@onUserResetPassword'],

];