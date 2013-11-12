<?php

return [

	'nova.form.entryCreated'	=> ['FormEventHandler@onFormViewerCreated'],
	'nova.form.fieldCreated'	=> ['FormEventHandler@onFieldCreated'],
	'nova.form.fieldDeleted'	=> ['FormEventHandler@onFieldDeleted'],
	'nova.form.fieldUpdated'	=> ['FormEventHandler@onFieldUpdated'],
	'nova.form.formCreated'		=> ['FormEventHandler@onFormCreated'],
	'nova.form.formDeleted'		=> ['FormEventHandler@onFormDeleted'],
	'nova.form.formUpdated'		=> ['FormEventHandler@onFormUpdated'],
	'nova.form.sectionCreated'	=> ['FormEventHandler@onSectionCreated'],
	'nova.form.sectionDeleted'	=> ['FormEventHandler@onSectionDeleted'],
	'nova.form.sectionUpdated'	=> ['FormEventHandler@onSectionUpdated'],
	'nova.form.tabCreated'		=> ['FormEventHandler@onTabCreated'],
	'nova.form.tabDeleted'		=> ['FormEventHandler@onTabDeleted'],
	'nova.form.tabUpdated'		=> ['FormEventHandler@onTabUpdated'],
	'nova.form.valueCreated'	=> ['FormEventHandler@onValueCreated'],
	'nova.form.valueDeleted'	=> ['FormEventHandler@onValueDeleted'],
	'nova.form.valueUpdated'	=> ['FormEventHandler@onValueUpdated'],

	'nova.nav.created'			=> ['NavigationEventHandler@onNavCreated'],
	'nova.nav.deleted'			=> ['NavigationEventHandler@onNavDeleted'],
	'nova.nav.duplicated'		=> ['NavigationEventHandler@onNavDuplicated'],
	'nova.nav.updated'			=> ['NavigationEventHandler@onNavUpdated'],

	'nova.route.created'		=> ['SystemRouteEventHandler@onCreated'],
	'nova.route.deleted'		=> ['SystemRouteEventHandler@onDeleted'],
	'nova.route.duplicated'		=> ['SystemRouteEventHandler@onDuplicated'],
	'nova.route.updated'		=> ['SystemRouteEventHandler@onUpdated'],

	//'nova.settings.created'		=> ['SettingsEventHandler@onCreated'],
	//'nova.settings.deleted'		=> ['SettingsEventHandler@onDeleted'],
	//'nova.settings.updated'		=> ['SettingsEventHandler@onUpdated'],

	'nova.sitecontent.created'	=> ['SiteContentEventHandler@onCreated'],
	'nova.sitecontent.deleted'	=> ['SiteContentEventHandler@onDeleted'],
	'nova.sitecontent.updated'	=> ['SiteContentEventHandler@onUpdated'],

	'nova.user.created'			=> ['UserEventHandler@onUserCreated'],
	'nova.user.resetPassword'	=> ['UserEventHandler@onUserResetPassword'],

];