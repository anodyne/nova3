@extends('layouts.app')

@section('title', _m('user-password-reset'))

@section('content')
	<h1>{{ _m('user-password-reset') }}</h1>

	{!! Form::open(['route' => 'users.reset-passwords', 'method' => 'patch']) !!}
		<div class="form-group">
			<button type="submit" class="btn btn-primary" v-show="selected.length > 0">{{ _m('user-password-do-reset') }}</button>
			<a href="{{ route('users.index') }}" class="btn btn-link ml-2">{{ _m('cancel') }}</a>
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
					if (this.selected.length > 0) {
						this.selected = []
					} else {
						var self = this

						_.forEach(this.users, function (user) {
							self.selected.push(user.id)
						})
					}
				}
			}
		}
	</script>
@endsection