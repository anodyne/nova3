@extends('layouts.welcome')

@section('content')
	<div class="title m-b-md">
		Status
	</div>

	<div class="card">
		<div class="card-block">
			<h3 class="d-flex align-items-center justify-content-start">
				<span class="mr-auto">Manage Users</span>
				<i class="fal fa-code fa-fw"></i>
			</h3>

			<ul>
				<li>Create user</li>
				<li>Update user</li>
				<li>Delete user</li>
				<li>Restore deleted user</li>
				<li>Authorize access to user managemt</li>
				<li class="text-subtle">Admin-forced password resets</li>
				<li class="text-subtle">User avatars</li>
				<li class="text-subtle">Events around admin-triggered actions on users</li>
			</ul>
		</div>
	</div>

	<div class="card card-outline-success">
		<div class="card-block">
			<h3 class="d-flex align-items-center justify-content-start">
				<span class="mr-auto">Manage Permissions</span>
				<i class="fal fa-check-circle fa-fw"></i>
			</h3>

			<ul>
				<li>Create permission</li>
				<li>Update permission</li>
				<li>Delete permission
					<ul>
						<li>When a permission is deleted, any roles with that permission are updated as well</li>
					</ul>
				</li>
				<li>Authorize access to permission management</li>
				<li class="text-warning">Better handling of permission validation</li>
			</ul>
		</div>
	</div>

	<div class="card card-outline-success">
		<div class="card-block">
			<h3 class="d-flex align-items-center justify-content-start">
				<span class="mr-auto">Manage Roles</span>
				<i class="fal fa-check-circle fa-fw"></i>
			</h3>

			<ul>
				<li>Create role</li>
				<li>Update role</li>
				<li>Delete role
					<ul>
						<li>When a role is deleted, any users with that role are updated</li>
					</ul>
				</li>
				<li>Authorize access to role management</li>
				<li class="text-warning">Better handling of role validation</li>
			</ul>
		</div>
	</div>

	<div class="card card-outline-success">
		<div class="card-block">
			<h3 class="d-flex align-items-center justify-content-start">
				<span class="mr-auto">Authentication</span>
				<i class="fal fa-check-circle fa-fw"></i>
			</h3>

			<ul>
				<li>Users can sign in</li>
				<li>Users can reset their password</li>
				<li>Users are locked out for 30 minutes after 5 unsuccessful sign in attempts</li>
				<li>Users can sign out</li>
				<li class="text-warning">Track a user's last sign in</li>
				<li class="text-warning">Handle admin-forced password resets</li>
			</ul>
		</div>
	</div>
@endsection