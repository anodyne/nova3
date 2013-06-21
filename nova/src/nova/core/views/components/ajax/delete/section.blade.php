<p><?php echo lang('short.deleteConfirm', lang('section'), $name);?></p>

{{ Form::open(['url' => 'admin/form/sections/'.$formKey]) }}
	@if (count($sections) > 0 and $fields > 0)
		<div class="row">
			<div class="col-lg-6">
				{{ Form::select('new_section_id', $sections) }}
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<p class="help-block">{{ lang('short.admin.forms.deleteUpdates', lang('section'), lang('fields'), $name) }}</p>
			</div>
		</div>
	@else
		{{ Form::hidden('new_section_id', 0) }}
	@endif

	{{ Form::token() }}
	{{ Form::hidden('id', $id) }}
	{{ Form::hidden('action', 'delete') }}
	{{ Form::button(lang('Action.submit'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
{{ Form::close() }}