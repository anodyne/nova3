@extends('layouts.app')

@section('title', _m('user-password-reset'))

@section('content')
	<h1>{{ _m('user-password-reset') }}</h1>

	{!! Form::open(['route' => 'users.reset-passwords', 'method' => 'patch']) !!}
		<div class="form-group" v-show="selected.length > 0">
			<button type="submit" class="btn btn-primary">{{ _m('user-password-do-reset') }}</button>
			<a href="{{ route('users.index') }}" class="btn btn-link ml-2">{{ _m('cancel') }}</a>
		</div>
		<div class="form-group" v-show="selected.length == 0">
			<a href="{{ route('users.index') }}" class="btn btn-secondary">{{ _m('users-manage') }}</a>
		</div>

		<table class="table" v-cloak>
			<thead class="thead-default">
				<tr>
					<th>
						<label class="custom-control custom-checkbox">
							<input type="checkbox" name="check-all" class="custom-control-input" @change="toggleAll">
							<span class="custom-control-indicator"></span>
							<span class="custom-control-description">{{ _m('name') }}</span>
						</label>
					</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="user in users">
					<td>
						<label class="custom-control custom-checkbox">
							<input type="checkbox" name="users[]" :value="user.id" class="custom-control-input" v-model="selected">
							<span class="custom-control-indicator"></span>
							<span class="custom-control-description" v-text="user.displayName"></span>
						</label>
					</td>
				</tr>
			</tbody>
		</table>
	{!! Form::close() !!}
@endsection

@section('js')
	<script>
		vue = {
			data: {
				selected: [],
				users: {!! $users !!}
			},

			methods: {
				toggleAll () {
					var self = this

					if (this.selected.length == this.users.length) {
						// Everything is selected and CheckAll is unchecked
						this.selected = []
					} else if (this.selected.length == 0) {
						// Nothing is selected and CheckAll is checked
						_.forEach(this.users, function (user) {
							self.selected.push(user.id)
						})
					} else if (this.selected.length > 0 && this.selected.length < this.users.length) {
						// Something is selected and CheckAll is checked
						_.forEach(this.users, function (user) {
							var find = _.findIndex(self.selected, function (s) {
								return s == user.id
							})

							var inSelected = find >= 0

							if (! inSelected) {
								self.selected.push(user.id)
							}
						})
					}
				}
			},

			watch: {
				selected (newValue, oldValue) {
					let checkAll = $('[name="check-all"]')

					if (newValue.length > 0 && newValue.length < this.users.length) {
						checkAll.prop('checked', false)
								.prop('indeterminate', true)
					}

					if (newValue.length == this.users.length) {
						checkAll.prop('indeterminate', false)
								.prop('checked', true)
					}

					if (newValue.length == 0) {
						checkAll.prop('indeterminate', false)
								.prop('checked', false)
					}
				}
			}
		}
	</script>
@endsection