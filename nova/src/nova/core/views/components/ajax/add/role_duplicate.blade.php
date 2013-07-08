@if ($role->id == AccessRole::SYSADMIN)
	{{ partial('common/alert', ['class' => 'alert-danger', 'heading' => lang('short.admin.roles.duplicateSysAdminHeader'), 'content' => lang('short.admin.roles.duplicateSysAdminText', lang('users'))]) }}
@endif
{{ Form::open(['url' => 'admin/role']) }}
	<div class="control-group">
		<label class="control-label">{{ langConcat('Original Role') }}</label>
		<div class="controls">{{ $role->name }}</div>
	</div>

	<div class="control-group">
		<label class="control-label">{{ langConcat('New Name') }}</label>
		<div class="controls">
			{{ Form::text('name', $role->name) }}
		</div>
	</div>

	{{ Form::token() }}
	{{ Form::hidden('id', $role->id) }}
	{{ Form::hidden('action', 'duplicate') }}
	{{ Form::button(lang('Action.submit')), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
{{ Form::close() }}