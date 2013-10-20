<?php

return [

	'nova.form.entryCreated'	=> ['FormViewerEventHandler@onFormViewerCreated'],
	'nova.form.formCreated'		=> ['FormHandler@onFormCreated'],
	'nova.form.formDeleted'		=> ['FormHandler@onFormDeleted'],
	'nova.form.formUpdated'		=> ['FormHandler@onFormUpdated'],

	'nova.user.created'			=> ['UserEventHandler@onUserCreated'],
	'nova.user.resetPassword'	=> ['UserEventHandler@onUserResetPassword'],

];