<?php

return [

	'nova.form.entryCreated'	=> ['FormViewerEventHandler@onFormViewerCreated'],
	'nova.form.fieldCreated'	=> ['FormFieldEventHandler@onFieldCreated'],
	'nova.form.fieldDeleted'	=> ['FormFieldEventHandler@onFieldDeleted'],
	'nova.form.fieldUpdated'	=> ['FormFieldEventHandler@onFieldUpdated'],
	'nova.form.formCreated'		=> ['FormEventHandler@onFormCreated'],
	'nova.form.formDeleted'		=> ['FormEventHandler@onFormDeleted'],
	'nova.form.formUpdated'		=> ['FormEventHandler@onFormUpdated'],
	'nova.form.sectionCreated'	=> ['FormSectionEventHandler@onSectionCreated'],
	'nova.form.sectionDeleted'	=> ['FormSectionEventHandler@onSectionDeleted'],
	'nova.form.sectionUpdated'	=> ['FormSectionEventHandler@onSectionUpdated'],
	'nova.form.tabCreated'		=> ['FormTabEventHandler@onTabCreated'],
	'nova.form.tabDeleted'		=> ['FormTabEventHandler@onTabDeleted'],
	'nova.form.tabUpdated'		=> ['FormTabEventHandler@onTabUpdated'],
	'nova.form.valueCreated'	=> ['FormValueEventHandler@onValueCreated'],
	'nova.form.valueDeleted'	=> ['FormValueEventHandler@onValueDeleted'],
	'nova.form.valueUpdated'	=> ['FormValueEventHandler@onValueUpdated'],

	'nova.nav.created'			=> ['NavigationEventHandler@onNavCreated'],
	'nova.nav.deleted'			=> ['NavigationEventHandler@onNavDeleted'],
	'nova.nav.duplicated'		=> ['NavigationEventHandler@onNavDuplicated'],
	'nova.nav.updated'			=> ['NavigationEventHandler@onNavUpdated'],

	'nova.route.created'		=> ['SystemRouteEventHandler@onCreated'],
	'nova.route.deleted'		=> ['SystemRouteEventHandler@onDeleted'],
	'nova.route.duplicated'		=> ['SystemRouteEventHandler@onDuplicated'],
	'nova.route.updated'		=> ['SystemRouteEventHandler@onUpdated'],

	'nova.settings.created'		=> ['SettingsEventHandler@onCreated'],
	'nova.settings.deleted'		=> ['SettingsEventHandler@onDeleted'],
	'nova.settings.updated'		=> ['SettingsEventHandler@onUpdated'],

	'nova.sitecontent.created'	=> ['SiteContentEventHandler@onCreated'],
	'nova.sitecontent.deleted'	=> ['SiteContentEventHandler@onDeleted'],
	'nova.sitecontent.updated'	=> ['SiteContentEventHandler@onUpdated'],

	'nova.user.created'			=> ['UserEventHandler@onUserCreated'],
	'nova.user.resetPassword'	=> ['UserEventHandler@onUserResetPassword'],

];