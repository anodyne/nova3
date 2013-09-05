<p>{{ lang('short.deleteConfirm', lang('role'), $name) }}</p>

{{ Form::open(['url' => 'admin/role']) }}
	@if (count($roles) > 0)
		<div class="form-group">
			<label class="control-label"></label>
			{{ Form::select('new_role_id', $roles->toSimpleArray(), null, ['class' => 'form-control']) }}
			<p class="help-block">{{ lang('short.admin.roles.removeRole', lang('users'), $name) }}</p>
		</div>
	@else
		{{ Form::hidden('new_role_id', 0) }}
	@endif

	{{ Form::token() }}
	{{ Form::hidden('id', $id) }}
	{{ Form::hidden('formAction', 'delete') }}
	{{ Form::button(lang('Action.delete'), ['type' => 'submit', 'class' => 'btn btn-danger']) }}
{{ Form::close() }}