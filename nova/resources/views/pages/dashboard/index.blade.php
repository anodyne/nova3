@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
	<h1>Dashboard</h1>

	<div class="alert alert-warning d-flex align-items-center">
		{!! icon('settings-alt', 'fa-3x mr-3') !!}
		<span>Welcome to Nova NextGen's dashboard! The dashboard is currently under construction and will be built out through the development process. If you have suggestions about things that should be on the dashboard, let us know.</span>
	</div>

	{{-- @include('pages.dashboard._checklist-install')
	@include('pages.dashboard._checklist-migrate') --}}
@endsection

@section('js')
	<script>
		vue = {
			data: {
				showInstallChecklist: true,
				showMigrateChecklist: true
			},

			methods: {
				finishInstallation () {
					axios.post(route('dashboard.finish-install'));

					this.showInstallChecklist = false;
				},

				finishMigration () {
					axios.post(route('dashboard.finish-migrate'));

					this.showMigrateChecklist = false;
				},

				sendTestEmail () {
					axios.post(route('dashboard.send-test-email'))
						.then(function (response) {
							$.alert({
								title: "{{ _m('dashboard-test-email-confirm-header') }}",
								content: "{{ _m('dashboard-test-email-confirm-message') }}",
								theme: "dark"
							});
						})
						.catch(function (error) {
							//
						});
				}
			}
		};
	</script>
@endsection