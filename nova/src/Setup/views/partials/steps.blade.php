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

	if ($section == 'config-database')
	{
		$classes[1] = ' class="step-active"';
	}
}

?>

<ol>
	@if ($type == 'install')
		<li{!! $classes[1] !!}><span class="icn icn-size-sm" data-icon="1"></span>Database Connection</li>
		<li{!! $classes[2] !!}><span class="icn icn-size-sm" data-icon="2"></span>Email Settings</li>
		<li{!! $classes[3] !!}><span class="icn icn-size-sm" data-icon="3"></span>Install {{ config('nova.app.name') }}</li>
		<li{!! $classes[4] !!}><span class="icn icn-size-sm" data-icon="4"></span>Create User</li>
		<li{!! $classes[5] !!}><span class="icn icn-size-sm" data-icon="5"></span>Finalize</li>
	@endif

	@if ($type == 'update')
		<li{!! $classes[1] !!}><span class="icn icn-size-sm" data-icon="1"></span>Backup</li>
		<li{!! $classes[2] !!}><span class="icn icn-size-sm" data-icon="2"></span>Update {{ config('nova.app.name') }}</li>
		<li{!! $classes[5] !!}><span class="icn icn-size-sm" data-icon="3"></span>Finalize</li>
	@endif

	@if ($type == 'migrate')
		<li{!! $classes[1] !!}><span class="icn icn-size-sm" data-icon="1"></span>Database Connection</li>
		<li{!! $classes[2] !!}><span class="icn icn-size-sm" data-icon="2"></span>Email Settings</li>
		<li{!! $classes[3] !!}><span class="icn icn-size-sm" data-icon="3"></span>Install {{ config('nova.app.name') }}</li>
		<li{!! $classes[4] !!}><span class="icn icn-size-sm" data-icon="4"></span>Create User</li>
		<li{!! $classes[5] !!}><span class="icn icn-size-sm" data-icon="5"></span>Finalize</li>
	@endif
</ol>