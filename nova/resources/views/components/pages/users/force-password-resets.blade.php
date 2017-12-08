<h1>{{ _m('users-password-reset') }}</h1>

{!! Form::open(['route' => 'users.reset-passwords', 'method' => 'patch']) !!}
	<div class="data-table bordered striped">
		<div class="row header align-items-center">
			<div class="col mb-0">
				<label class="custom-control custom-checkbox">
					<input type="checkbox" name="check-all" class="custom-control-input" @change="toggleAll">
					<span class="custom-control-indicator"></span>
					<span class="custom-control-description">{{ _m('name') }}</span>
				</label>
			</div>
			<div class="col col-xs-auto">
				<div class="pull-right" v-show="selected.length > 0">
					<button type="submit" class="btn btn-primary">{!! icon('check') !!}</button>
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
						<avatar :item="user"
								:show-metadata="false"
								:show-status="false"
								type="image"
								size="sm">
						</avatar>
					</span>
				</label>
			</div>
		</div>
	</div>
{!! Form::close() !!}