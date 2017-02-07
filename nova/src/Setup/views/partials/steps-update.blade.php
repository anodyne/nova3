<?php

$path = Request::path();

$classes = [
	1 => 'class="step"',
	2 => 'class="step"',
	3 => 'class="step"',
];

$summaryActive = [
	'setup/update/changes',
];

$summaryCompleted = [
	'setup/update/backup',
	'setup/update/backup/success',
	'setup/update/backup/failed',
	'setup/update/run',
	'setup/update/success',
];

$backupActive = [
	'setup/update/backup',
];

$backupCompleted = [
	'setup/update/backup/success',
];

$updateActive = [
	'setup/update/run',
];

$updateCompleted = [
	'setup/update/success'
];

if (in_array($path, $summaryActive))
{
	$classes[1] = 'class="step active"';
}
if (in_array($path, $summaryCompleted))
{
	$classes[1] = 'class="step completed"';
}

if (in_array($path, $backupActive))
{
	$classes[2] = 'class="step active"';
}
if (session('backupStatus') == 'success')
{
	$classes[2] = 'class="step completed"';
}
if (session('backupStatus') == 'failed')
{
	$classes[2] = 'class="step failed"';
}

if (in_array($path, $updateActive))
{
	$classes[3] = 'class="step active"';
}
if (in_array($path, $updateCompleted))
{
	$classes[3] = 'class="step completed"';
}

?><div class="row">
	<div class="col-md-8 offset-md-2 col-lg-6 offset-lg-3">
		<div class="wizard space-around">
			<div {!! $classes[1] !!}>
				@icon('nova/src/Setup/views/design/images/list-ol')
				<span class="label">
					<span class="short">Changes</span>
					<span class="long">Summary of Changes</span>
				</span>
			</div>

			<div {!! $classes[2] !!}>
				@icon('nova/src/Setup/views/design/images/download')
				<span class="label">
					<span class="short">Backup</span>
					<span class="long">Backup Your Site</span>
				</span>
			</div>

			<div {!! $classes[3] !!}>
				@icon('nova/src/Setup/views/design/images/rocket')
				<span class="label">
					<span class="short">Update</span>
					<span class="long">Update to {{ config('nova.app.name') }} 3.0.1</span>
				</span>
			</div>
		</div>
	</div>
</div>