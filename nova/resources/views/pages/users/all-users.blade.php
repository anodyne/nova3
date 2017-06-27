@extends('layouts.app')

@section('title', _m('users'))

@section('content')
	<h1>{{ _m('users') }}</h1>

	<div class="btn-toolbar">
		@can('create', $userClass)
			<div class="btn-group">
				<a href="{{ route('users.create') }}" class="btn btn-success">{{ _m('user-add') }}</a>
			</div>
		@endcan
	</div>

	@if ($users->count() > 0)
		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<div class="input-group">
						<input type="text" class="form-control" placeholder="{{ _m('user-find') }}" v-model="searchUsers">
						<span class="input-group-btn">
							<a class="btn btn-secondary" href="#" @click.prevent="searchUsers = ''"><i class="fa fa-fw fa-close"></i></a>
						</span>
					</div>
				</div>
			</div>
		</div>

		<table class="table">
			<thead class="thead-default">
				<tr>
					<th colspan="2">{{ _m('name') }}</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="user in filteredUsers">
					<td>@{{ user.name }}</td>
					<td>
						<div class="btn-toolbar">
							@can('update', $userClass)
								<div class="btn-group">
									<a :href="'/admin/users/' + user.id + '/edit'" class="btn btn-sm btn-secondary">{{ _m('edit') }}</a>
								</div>
							@endcan

							@can('delete', $userClass)
								<div class="btn-group" v-if="!isTrashed(user)">
									<a href="#" class="btn btn-sm btn-outline-danger" :data-user="user.id" @click.prevent="deleteUser">{{ _m('delete') }}</a>
								</div>
							@endcan

							@can('update', $userClass)
								<div class="btn-group" v-if="isTrashed(user)">
									<a href="#" class="btn btn-sm btn-outline-success" :data-user="user.id" @click.prevent="restoreUser">{{ _m('restore') }}</a>
								</div>
							@endcan
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
				searchUsers: ''
			},

			computed: {
				filteredUsers () {
					let self = this

					return self.users.filter(function (user) {
						let regex = new RegExp(self.searchUsers, 'i')

						return regex.test(user.name)
							|| regex.test(user.email)
							|| regex.test(user.nickname)
					})
				}
			},

			methods: {
				deleteUser (event) {
					let confirm = window.confirm("{{ _m('user-delete') }}")

					if (confirm) {
						let user = event.target.getAttribute('data-user')

						axios.delete('/admin/users/' + user)

						window.location.replace('/admin/users')
					}
				},

				isTrashed (user) {
					return user.deleted_at != null
				},

				restoreUser (event) {
					let user = event.target.getAttribute('data-user')

					axios.patch('/admin/users/' + user + '/restore')

					window.location.replace('/admin/users')
				}
			}
		}
	</script>
@endsection