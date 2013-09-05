@if ($role->id == AccessRole::SYSADMIN)
	{{ partial('common/alert', ['class' => 'alert-danger', 'heading' => lang('short.admin.roles.duplicateSysAdminHeader'), 'content' => lang('short.admin.roles.duplicateSysAdminText', lang('users'))]) }}
@endif
{{ Form::open(['url' => 'admin/role']) }}
	<div class="form-group">
		<label class="control-label">{{ langConcat('Original Role') }}</label>
		{{ $role->name }}
	</div>

	<div class="form-group">
		<label class="control-label">{{ langConcat('New Name') }}</label>
		{{ Form::text('name', $role->name, ['class' => 'form-control']) }}
	</div>

	{{ Form::token() }}
	{{ Form::hidden('id', $role->id) }}
	{{ Form::hidden('formAction', 'duplicate') }}
	{{ Form::button(lang('Action.submit')), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
{{ Form::close() }}