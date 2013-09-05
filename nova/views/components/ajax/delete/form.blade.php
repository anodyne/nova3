<p>{{ lang('short.deleteConfirm', lang('form'), $form->name) }}</p>

{{ Form::model($form, ['url' => 'admin/form']) }}
	{{ Form::button(lang('Action.delete'), ['type' => 'submit', 'class' => 'btn btn-danger']) }}
	{{ Form::token() }}
	{{ Form::hidden('id') }}
	{{ Form::hidden('formAction', 'delete') }}
{{ Form::close() }}