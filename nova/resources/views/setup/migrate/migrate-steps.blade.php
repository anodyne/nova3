<?php

$path = Request::path();

$classes = [
	1 => 'class="step"',
	2 => 'class="step"',
	3 => 'class="step"',
	4 => 'class="step"',
	5 => 'class="step"',
	6 => 'class="step"',
];

$nova2Active = [
	'setup/migrate/config-nova2'
];
$nova2Completed = [
	'setup/migrate/config-nova2/success',
	'setup/migrate/config-database',
	'setup/migrate/config-database/success',
	'setup/migrate/config-email',
	'setup/migrate/config-email/success'
];

$dbActive = [
	'setup/migrate/config-database',
	'setup/migrate/config-database/check',
	'setup/migrate/config-database/write',
];

$emailActive = [
	'setup/migrate/config-email',
	'setup/migrate/config-email/write',
];

$migrateActive = [
	'setup/migrate/nova'
];

$accountsActive = [
	'setup/migrate/accounts',
];
$accountsCompleted = [
	'setup/migrate/accounts/success',
	'setup/migrate/settings',
	'setup/migrate/settings/success'
];

if (in_array($path, $nova2Active)) {
	$classes[1] = 'class="step active"';
}
if (File::exists(app()->appConfigPath('nova2.php'))) {
	$classes[1] = 'class="step completed"';
}

if (in_array($path, $dbActive)) {
	$classes[2] = 'class="step active"';
}
if (File::exists(app()->appConfigPath('database.php'))) {
	$classes[2] = 'class="step completed"';
}

if (in_array($path, $emailActive)) {
	$classes[3] = 'class="step active"';
}
if (File::exists(app()->appConfigPath('mail.php'))) {
	$classes[3] = 'class="step completed"';
}

if (in_array($path, $migrateActive)) {
	$classes[4] = 'class="step active"';
}
if (nova()->isInstalled()) {
	$classes[4] = 'class="step completed"';
}

if (in_array($path, $accountsActive)) {
	$classes[5] = 'class="step active"';
}
if (in_array($path, $accountsCompleted)) {
	$classes[5] = 'class="step completed"';
}

/*if (in_array($path, $novaActive)) {
	$classes[3] = 'class="step active"';
}
if (app('filesystem')->disk('local')->has('installed.json')) {
	$classes[3] = 'class="step completed"';
}

if (in_array($path, $userActive)) {
	$classes[4] = 'class="step active"';
}
if (in_array($path, $userCompleted)) {
	$classes[4] = 'class="step completed"';
}

if (in_array($path, $settingsActive)) {
	$classes[5] = 'class="step active"';
}
if (in_array($path, $settingsCompleted)) {
	$classes[5] = 'class="step completed"';
}*/

?><div class="wizard">
	<div {!! $classes[1] !!}>
		@icon('setup/bolt')
		<span class="label">
			<span class="short">Nova 2</span>
			<span class="long">Connect to Nova 2</span>
		</span>
	</div>

	<div {!! $classes[2] !!}>
		@icon('setup/database')
		<span class="label">
			<span class="short">Database</span>
			<span class="long">Database Connection</span>
		</span>
	</div>

	<div {!! $classes[3] !!}>
		@icon('setup/paper-plane')
		<span class="label">
			<span class="short">Email</span>
			<span class="long">Email Settings</span>
		</span>
	</div>

	<div {!! $classes[4] !!}>
		@icon('setup/rocket')
		<span class="label">
			<span class="short">Migrate</span>
			<span class="long">Migrate to {{ config('nova.app.name') }}</span>
		</span>
	</div>

	<div {!! $classes[5] !!}>
		@icon('setup/users')
		<span class="label">
			<span class="short">Accounts</span>
			<span class="long">Update User Accounts</span>
		</span>
	</div>

	<div {!! $classes[6] !!}>
		@icon('setup/cogs')
		<span class="label">
			<span class="short">Settings</span>
			<span class="long">Update Settings</span>
		</span>
	</div>
</div>