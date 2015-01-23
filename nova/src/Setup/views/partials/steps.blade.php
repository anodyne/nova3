<?php

$type = Request::segment(2);
$section = Request::segment(3);

if ($type == 'install')
{
	$classes = [
		1 => '',
		2 => '',
		3 => '',
		4 => '',
		5 => '',
	];

	if (Request::is('setup/install/config-database') or Request::is('setup/install/config-database/check') or Request::is('setup/install/config-database/write'))
	{
		$classes[1] = ' class="step-active"';
	}
	if (file_exists(app('path.config').'/database.php'))
	{
		$classes[1] = ' class="step-completed"';
	}

	if (Request::is('setup/install/config-email') or Request::is('setup/install/config-email/write'))
	{
		$classes[2] = ' class="step-active"';
	}
	if (file_exists(app('path.config').'/mail.php'))
	{
		$classes[2] = ' class="step-completed"';
	}
}

?>

<ol>
	@if ($type == 'install')
		<li{!! $classes[1] !!}>{!! icon($_icons['1']) !!}Database Connection</li>
		<li{!! $classes[2] !!}>{!! icon($_icons['2']) !!}Email Settings</li>
		<li{!! $classes[3] !!}>{!! icon($_icons['3']) !!}Install {{ config('nova.app.name') }}</li>
		<li{!! $classes[4] !!}>{!! icon($_icons['4']) !!}Create User</li>
		<li{!! $classes[5] !!}>{!! icon($_icons['5']) !!}Finalize</li>
	@endif

	@if ($type == 'update')
		<li{!! $classes[1] !!}>{!! icon($_icons['1']) !!}Backup</li>
		<li{!! $classes[2] !!}>{!! icon($_icons['2']) !!}Update {{ config('nova.app.name') }}</li>
		<li{!! $classes[5] !!}>{!! icon($_icons['3']) !!}Finalize</li>
	@endif

	@if ($type == 'migrate')
		<li{!! $classes[1] !!}>{!! icon($_icons['1']) !!}Database Connection</li>
		<li{!! $classes[2] !!}>{!! icon($_icons['2']) !!}Email Settings</li>
		<li{!! $classes[3] !!}>{!! icon($_icons['3']) !!}Install {{ config('nova.app.name') }}</li>
		<li{!! $classes[4] !!}>{!! icon($_icons['4']) !!}Create User</li>
		<li{!! $classes[5] !!}>{!! icon($_icons['5']) !!}Finalize</li>
	@endif
</ol>