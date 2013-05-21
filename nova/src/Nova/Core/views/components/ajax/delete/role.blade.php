<p>{{ lang('short.deleteConfirm', lang('role'), $name) }}</p>

{{ Form::open(array('url' => 'admin/role/index', 'method' => 'delete')) }}
	@if (count($roles) > 0)
		<div class="control-group">
			<label class="control-label"></label>
			<div class="controls">
				{{ Form::select('new_role_id', $roles->toSimpleArray()) }}
				<p class="help-block">{{ lang('short.roles.removeRole', lang('users'), $name) }}</p>
			</div>
		</div>
	@else
		{{ Form::hidden('new_role_id', 0) }}
	@endif

	<div class="form-actions">
		{{ Form::button(ucfirst(lang('action.submit')), array('type' => 'submit', 'class' => 'btn btn-primary')) }}
		{{ Form::hidden('id', $id) }}
	</div>
</form>