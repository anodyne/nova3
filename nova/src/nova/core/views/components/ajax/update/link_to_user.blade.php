{{ Form::model($user, ['url' => 'admin/user']) }}
	<div class="row">
		<div class="col-lg-6">
			<div class="form-group">
				<label class="control-label">{{ lang('User') }}</label>
				<p>{{ $user->name }}</p>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<div class="form-group">
				<label class="control-label">{{ lang('Character') }}</label>
				{{ Form::characters('character_id', null, ['class' => 'form-control'], Status::UNASSIGNED) }}
			</div>
		</div>
	</div>

	@if (Character::npc()->count() == 0)
		{{ Form::hidden('character_id') }}
	@endif

	{{ Form::token() }}
	{{ Form::hidden('id') }}
	{{ Form::hidden('action', 'link') }}
	{{ Form::button(lang('Action.submit'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
{{ Form::close() }}