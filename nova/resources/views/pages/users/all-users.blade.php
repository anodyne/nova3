@extends('layouts.app')

@section('title', _m('users'))

@section('content')
	<h1>{{ _m('users') }}</h1>

	@if ($users->count() > 0)
		<div class="alert alert-info" v-show="status == '{{ Status::REMOVED }}'">
			<p>{{ _m('users-deleted-notice') }}</p>
		</div>

		<div class="data-table bordered striped">
			<div class="row header align-items-start align-items-md-center">
				<div class="col-9 col-md-6">
					<div class="input-group">
						<input type="text"
							   class="form-control"
							   placeholder="{{ _m('users-find') }}"
							   v-model="search">
						<span class="input-group-btn">
							<a class="btn btn-secondary" href="#" @click.prevent="search = ''">
								{!! icon('close') !!}
							</a>
						</span>
					</div>
					<div class="mt-2 hidden-md-up">
						<select name="" class="custom-select" v-model="status">
							<option value="">{{ _m('users-status-all') }}</option>
							<option value="{{ Status::ACTIVE }}">{{ _m('users-status-active') }}</option>
							<option value="{{ Status::INACTIVE }}">{{ _m('users-status-inactive') }}</option>
							<option value="{{ Status::REMOVED }}">{{ _m('users-status-removed') }}</option>
						</select>
					</div>
				</div>
				<div class="col hidden-sm-down">
					<select name="" class="custom-select" v-model="status">
						<option value="">{{ _m('users-status-all') }}</option>
						<option value="{{ Status::ACTIVE }}">{{ _m('users-status-active') }}</option>
						<option value="{{ Status::INACTIVE }}">{{ _m('users-status-inactive') }}</option>
						<option value="{{ Status::REMOVED }}">{{ _m('users-status-removed') }}</option>
					</select>
				</div>
				<div class="col col-xs-auto">
					@can('create', $userClass)
						<div class="btn-toolbar pull-right">
							<a href="{{ route('users.create') }}" class="btn btn-success">{!! icon('add') !!}</a>

							@can('update', $userClass)
								<div class="dropdown ml-2">
									<button type="button"
		  									class="btn btn-secondary btn-action"
		  									data-toggle="dropdown"
		  									aria-haspopup="true"
		  									aria-expanded="false">
										{!! icon('more') !!}
									</button>

									<div class="dropdown-menu dropdown-menu-right">
										<a href="{{ route('users.force-password-reset') }}" class="dropdown-item">
											{!! icon('users') !!} {{ _m('users-password-reset') }}
										</a>
									</div>
								</div>
							@endcan
						</div>
					@endcan

					@cannot('create', $userClass)
						@can('update', $userClass)
							<a href="{{ route('users.force-password-reset') }}" class="btn btn-secondary">
								{!! icon('users') !!}
							</a>
						@endcan
					@endcannot
				</div>
			</div>

			<div class="row align-items-center" v-for="user in filteredUsers">
				<div class="col-9">
					<user-avatar :user="user" type="link" :has-label="true" size="xs"></user-avatar>
				</div>
				<div class="col col-xs-auto">
					<div class="dropdown pull-right">
						<button class="btn btn-secondary btn-action"
								type="button"
								id="dropdownMenuButton"
								data-toggle="dropdown"
								aria-haspopup="true"
								aria-expanded="false">
							{!! icon('more') !!}
						</button>
						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
							<a :href="profileLink(user.id)" class="dropdown-item">
								{!! icon('user') !!} {{ _m('users-profile') }}
							</a>

							@can('manage', $userClass)
								<div class="dropdown-divider"></div>
							@endcan
							
							@can('update', $userClass)
								<a :href="editLink(user.id)" class="dropdown-item">{!! icon('edit') !!} {{ _m('edit') }}</a>
							@endcan

							@can('delete', $userClass)
								<a href="#"
								   class="dropdown-item text-danger"
								   @click.prevent="deleteUser(user.id)"
								   v-show="!isTrashed(user)">
									{!! icon('delete') !!} {{ _m('delete') }}
								</a>
							@endcan

							@can('update', $userClass)
								<a href="#"
								   class="dropdown-item text-success"
								   @click.prevent="restoreUser(user.id)"
								   v-show="isTrashed(user)">
									{!! icon('undo') !!} {{ _m('restore') }}
								</a>
							@endcan
						</div>
					</div>
				</div>
			</div>
		</div>
	@else
		<div class="alert alert-warning">
			{{ _m('users-error-not-found') }} <a href="{{ route('users.create') }}" class="alert-link">{{ _m('users-error-add') }}
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
					})
				},

				pendingCount () {
					return this.users.filter(function (user) {
						return user.status == {{ Status::PENDING }}
					}).length
				}
			},

			methods: {
				deleteUser (id) {
					let self = this

					$.confirm({
						title: "{{ _m('users-confirm-delete-title') }}",
						content: "{{ _m('users-confirm-delete-message') }}",
						theme: "dark",
						buttons: {
							confirm: {
								text: "{{ _m('delete') }}",
								btnClass: "btn-danger",
								action () {
									axios.delete(route('users.destroy', {user:id}))
										 .then(function (response) {
										 	let index = _.findIndex(self.users, function (u) {
												return u.id == id
											})

											self.users.splice(index, 1)

											flash(
												'{{ _m('users-flash-deleted-message') }}',
												'{{ _m('users-flash-deleted-title') }}'
											)
										 })
								}
							},
							cancel: {
								text: "{{ _m('cancel') }}"
							}
						}
					})
				},

				editLink (id) {
					return route('users.edit', {user:id})
				},

				isTrashed (user) {
					return user.deleted_at != null
				},

				profileLink (id) {
					return route('profile.show', {user:id})
				},

				restoreUser (id) {
					let self = this

					$.confirm({
						title: "{{ _m('users-restore-title') }}",
						content: "{{ _m('users-restore-message') }}",
						theme: "dark",
						buttons: {
							confirm: {
								text: "{{ _m('restore') }}",
								btnClass: "btn-success",
								action () {
									axios.patch(route('users.restore', {user:id}))
										 .then(function (response) {
										 	let index = _.findIndex(self.users, function (u) {
												return u.id == id
											})

											self.users[index].status = {{ Status::ACTIVE }}

											flash(
												'{{ _m('users-flash-restored-message') }}',
												'{{ _m('users-flash-restored-title') }}'
											)
										 })
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