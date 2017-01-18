<?php

$path = Request::path();

$classes = [
	1 => '',
	2 => '',
	3 => '',
	4 => '',
	5 => '',
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
	$classes[1] = ' class="step-active"';
}
if (File::exists(app('path.config').'/database.php'))
{
	$classes[1] = ' class="step-completed"';
}

if (in_array($path, $emailActive))
{
	$classes[2] = ' class="step-active"';
}
if (File::exists(app('path.config').'/mail.php'))
{
	$classes[2] = ' class="step-completed"';
}

if (in_array($path, $novaActive))
{
	$classes[3] = ' class="step-active"';
}
if (app('filesystem')->disk('local')->has('installed.json'))
{
	$classes[3] = ' class="step-completed"';
}

if (in_array($path, $userActive))
{
	$classes[4] = ' class="step-active"';
}
if (in_array($path, $userCompleted))
{
	$classes[4] = ' class="step-completed"';
}

if (in_array($path, $settingsActive))
{
	$classes[5] = ' class="step-active"';
}
if (in_array($path, $settingsCompleted))
{
	$classes[5] = ' class="step-completed"';
}

$setup = app('nova.setup');

?><ol>
	<li{!! $classes[1] !!}>
		{!! HTML::image('nova/src/Setup/views/design/images/database.svg') !!}
		<span class="visible-md">Database</span>
		<span class="hidden-md">Database Connection</span>
	</li>
	<li{!! $classes[2] !!}><i class="fa fa-fw fa-2x fa-envelope"></i> Email Settings</li>
	<li{!! $classes[3] !!}>
		<i class="fa fa-fw fa-2x fa-rocket"></i>
		<span class="visible-md">Install Nova</span>
		<span class="hidden-md">Install {{ config('nova.app.name') }}</span>
	</li>
	<li{!! $classes[4] !!}>
		<i class="fa fa-fw fa-2x fa-user-circle"></i>
		<span class="visible-md">User &amp; Character</span>
		<span class="hidden-md">Create User &amp; Character</span>
	</li>
	<li{!! $classes[5] !!}><i class="fa fa-fw fa-2x fa-cogs"></i> Update Settings</li>
</ol>