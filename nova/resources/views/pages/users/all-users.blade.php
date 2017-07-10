@extends('layouts.app')

@section('title', _m('users'))

@section('content')
	<h1>{{ _m('users') }}</h1>

	<mobile>
		<div class="row">
			@can('create', $userClass)
				<div class="col">
					<p><a href="{{ route('users.create') }}" class="btn btn-success btn-block">{{ _m('user-add') }}</a></p>
					<p><a href="{{ route('users.force-password-reset') }}" class="btn btn-secondary btn-block">{{ _m('user-password-reset') }}</a></p>
				</div>
			@endcan
		</div>
	</mobile>

	<desktop>
		<div class="btn-toolbar">
			@can('create', $userClass)
				<div class="btn-group">
					<a href="{{ route('users.create') }}" class="btn btn-success">{{ _m('user-add') }}</a>
				</div>
			@endcan

			@can('update', $userClass)
				<div class="btn-group">
					<a href="{{ route('users.force-password-reset') }}" class="btn btn-secondary">{{ _m('user-password-reset') }}</a>
				</div>
			@endcan
		</div>
	</desktop>

	@if ($users->count() > 0)
		<div class="row">
			<div class="col-md-4">
				<div class="form-group input-group">
					<input type="text"
						   class="form-control"
						   placeholder="{{ _m('user-find') }}"
						   v-model="search">
					<span class="input-group-btn">
						<a class="btn btn-secondary" href="#" @click.prevent="search = ''">
							{!! icon('close') !!}
						</a>
					</span>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<select name="" class="custom-select" v-model="status">
						<option value="">{{ _m('user-status-all') }}</option>
						<option value="{{ Status::ACTIVE }}">{{ _m('user-status-active') }}</option>
						<option value="{{ Status::INACTIVE }}">{{ _m('user-status-inactive') }}</option>
						{{-- <option value="{{ Status::PENDING }}">{{ _m('user-status-pending') }}</option> --}}
						<option value="{{ Status::REMOVED }}">{{ _m('user-status-removed') }}</option>
					</select>

					{{-- <span class="badge badge-warning ml-2" v-show="pendingCount > 0">There are @{{ pendingCount }} pending users</span> --}}
				</div>
			</div>
		</div>

		<div class="alert alert-info" v-show="status == '{{ Status::REMOVED }}'">
			<p>{{ _m('user-deleted-notice') }}</p>
		</div>

		<table class="table" v-cloak>
			<thead class="thead-default">
				<tr>
					<th colspan="2">{{ _m('name') }}</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="user in filteredUsers">
					<td>
						<avatar :user="user" type="link" :has-label="true" size="xs"></avatar>
					</td>
					<td>
						<div class="dropdown pull-right">
							<button class="btn btn-secondary"
									type="button"
									id="dropdownMenuButton"
									data-toggle="dropdown"
									aria-haspopup="true"
									aria-expanded="false">
								{!! icon('more') !!}
							</button>
							<div class="dropdown-menu dropdown-menu-right"
								 aria-labelledby="dropdownMenuButton">
								<a :href="'/profile/' + user.id" class="dropdown-item">{!! icon('user') !!} {{ _m('user-profile') }}</a>

								@can('manage', $userClass)
									<div class="dropdown-divider"></div>
								@endcan
								
								@can('update', $userClass)
									<a :href="'/admin/users/' + user.id + '/edit'" class="dropdown-item">{!! icon('edit') !!} {{ _m('edit') }}</a>
								@endcan

								@can('delete', $userClass)
									<a href="#" class="dropdown-item text-danger" :data-user="user.id" @click.prevent="deleteUser" v-show="!isTrashed(user)">{!! icon('delete') !!} {{ _m('delete') }}</a>
								@endcan

								@can('update', $userClass)
									<a href="#" class="dropdown-item text-success" :data-user="user.id" @click.prevent="restoreUser" v-show="isTrashed(user)">{!! icon('undo') !!} {{ _m('restore') }}</a>
								@endcan
							</div>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
	@else
		<div class="alert alert-warning">
			{{ _m('user-error-not-found') }} <a href="{{ route('users.create') }}" class="alert-link">{{ _m('user-error-add') }}
		</div>
	@endif
@endsection

@section('js')
	<script>
		vue = {
			data: {
				users: {!! $users !!},
				search: '',
				status: {{ Status::ACTIVE }}
			},

			computed: {
				filteredUsers () {
					let self = this
					let filteredUsers = this.users

					if (this.status != '') {
						filteredUsers = filteredUsers.filter(function (user) {
							return user.status == self.status
						})
					}

					return filteredUsers.filter(function (user) {
						let regex = new RegExp(self.search, 'i')

						return regex.test(user.name)
							|| regex.test(user.email)
							|| regex.test(user.nickname)
							// || regex.test(user.status)
					})
				},

				pendingCount () {
					return this.users.filter(function (user) {
						return user.status == {{ Status::PENDING }}
					}).length
				}
			},

			methods: {
				deleteUser (event) {
					$.confirm({
						title: "{{ _m('user-delete-title') }}",
						content: "{{ _m('user-delete-message') }}",
						theme: "dark",
						buttons: {
							confirm: {
								text: "{{ _m('delete') }}",
								btnClass: "btn-danger",
								action () {
									let user = event.target.getAttribute('data-user')

									axios.delete('/admin/users/' + user)

									window.setTimeout(() => {
										window.location.replace('/admin/users')
									}, 2000)
								}
							},
							cancel: {
								text: "{{ _m('cancel') }}"
							}
						}
					})
				},

				isTrashed (user) {
					return user.deleted_at != null
				},

				restoreUser (event) {
					$.confirm({
						title: "{{ _m('user-restore-title') }}",
						content: "{{ _m('user-restore-message') }}",
						theme: "dark",
						buttons: {
							confirm: {
								text: "{{ _m('restore') }}",
								btnClass: "btn-success",
								action () {
									let user = event.target.getAttribute('data-user')

									axios.patch('/admin/users/' + user + '/restore')

									window.setTimeout(() => {
										window.location.replace('/admin/users')
									}, 2000)
								}
							},
							cancel: {
								text: "{{ _m('cancel') }}"
							}
						}
					})
				}
			}
		}
	</script>
@endsection