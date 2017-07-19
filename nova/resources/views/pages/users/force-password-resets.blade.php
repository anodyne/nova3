@extends('layouts.app')

@section('title', _m('users-password-reset'))

@section('content')
	<h1>{{ _m('users-password-reset') }}</h1>

	{!! Form::open(['route' => 'users.reset-passwords', 'method' => 'patch']) !!}
		<div class="data-table bordered striped">
			<div class="row header align-items-center">
				<div class="col-8">
					<label class="custom-control custom-checkbox">
						<input type="checkbox" name="check-all" class="custom-control-input" @change="toggleAll">
						<span class="custom-control-indicator"></span>
						<span class="custom-control-description">{{ _m('name') }}</span>
					</label>
				</div>
				<div class="col col-xs-auto">
					<div class="pull-right" v-show="selected.length > 0">
						<button type="submit" class="btn btn-primary">{!! icon('submit') !!}</button>
						<a href="{{ route('users.index') }}" class="btn btn-secondary ml-1">{!! icon('close') !!}</a>
					</div>
					<div class="pull-right" v-show="selected.length == 0">
						<a href="{{ route('users.index') }}" class="btn btn-secondary">{!! icon('users') !!}</a>
					</div>
				</div>
			</div>
			<div class="row align-items-center" v-for="user in users">
				<div class="col">
					<label class="custom-control custom-checkbox">
						<input type="checkbox" name="users[]" :value="user.id" class="custom-control-input" v-model="selected">
						<span class="custom-control-indicator"></span>
						<span class="custom-control-description">
							<user-avatar :user="user" size="xs" type="image" :has-label="true"></user-avatar>
						</span>
					</label>
				</div>
			</div>
		</div>
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