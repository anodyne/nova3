<?php

$path = Request::path();

$classes = [
	1 => 'class="step"',
	2 => 'class="step"',
	3 => 'class="step"',
	4 => 'class="step"',
	5 => 'class="step"',
];

$dbActive = [
	'setup/install/config-database',
	'setup/install/config-database/check',
	'setup/install/config-database/write',
];

$emailActive = [
	'setup/install/config-email',
	'setup/install/config-email/write',
];

$novaActive = [
	'setup/install/nova',
];

$userActive = [
	'setup/install/user',
];
$userCompleted = [
	'setup/install/user/success',
	'setup/install/settings',
	'setup/install/settings/success',
];

$settingsActive = [
	'setup/install/settings',
];
$settingsCompleted = [
	'setup/install/settings/success',
];

if (in_array($path, $dbActive))
{
	$classes[1] = 'class="step active"';
}
if (Nova::isConfigured('db'))
{
	$classes[1] = 'class="step completed"';
}

if (in_array($path, $emailActive))
{
	$classes[2] = 'class="step active"';
}
if (Nova::isConfigured('mail'))
{
	$classes[2] = 'class="step completed"';
}

if (in_array($path, $novaActive))
{
	$classes[3] = 'class="step active"';
}
if (Nova::isInstalled())
{
	$classes[3] = 'class="step completed"';
}

if (in_array($path, $userActive))
{
	$classes[4] = 'class="step active"';
}
if (in_array($path, $userCompleted))
{
	$classes[4] = 'class="step completed"';
}

if (in_array($path, $settingsActive))
{
	$classes[5] = 'class="step active"';
}
if (in_array($path, $settingsCompleted))
{
	$classes[5] = 'class="step completed"';
}

?><div class="wizard">
	<div {!! $classes[1] !!}>
		@icon('nova/src/Setup/views/design/images/database')
		<span class="label">
			<span class="short">Database</span>
			<span class="long">Database Connection</span>
		</span>
	</div>

	<div {!! $classes[2] !!}>
		@icon('nova/src/Setup/views/design/images/paper-plane')
		<span class="label">
			<span class="short">Email</span>
			<span class="long">Email Settings</span>
		</span>
	</div>

	<div {!! $classes[3] !!}>
		@icon('nova/src/Setup/views/design/images/rocket')
		<span class="label">
			<span class="short">Install</span>
			<span class="long">Install {{ config('nova.app.name') }}</span>
		</span>
	</div>

	<div {!! $classes[4] !!}>
		@icon('nova/src/Setup/views/design/images/user-circle-o')
		<span class="label">
			<span class="short">Account</span>
			<span class="long">Create User &amp; Character</span>
		</span>
	</div>

	<div {!! $classes[5] !!}>
		@icon('nova/src/Setup/views/design/images/cogs')
		<span class="label">
			<span class="short">Settings</span>
			<span class="long">Update Settings</span>
		</span>
	</div>
</div>