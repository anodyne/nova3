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
		<li{!! $classes[1] !!}>Database Connection</li>
		<li{!! $classes[2] !!}>Email Settings</li>
		<li{!! $classes[3] !!}>Install Nova</li>
		<li{!! $classes[4] !!}>Create User</li>
		<li{!! $classes[5] !!}>Finalize</li>
	@endif
</ol>