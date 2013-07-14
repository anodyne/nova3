<div class="btn-toolbar">
	<div class="btn-group">
		<a href="{{ URL::to('admin/formviewer/'.$formKey.'/view') }}" class="btn btn-default icn-size-16">{{ $_icons['back'] }}</a>
	</div>
</div>

{{ Form::open(['url' => 'admin/formviewer/'.$formKey]) }}
	@if ($formMode == 'edit' or $formMode == 'detail')
		<dl>
			@if ($entry->author !== null)
				<dt>{{ langConcat('Action.created By') }}</dt>
				<dd>{{ $entry->author->name }}</dd>
			@endif

			<dt>{{ lang('Action.submitted') }}</dt>
			<dd>{{ $entry->created_at }}</dd>
		</dl>
	@endif

	{{ $dynamicForm }}

	@if ($formMode == 'add' or $formMode == 'edit')
		<div class="row">
			<div class="col-lg-12">
				{{ Form::token() }}
				{{ Form::hidden('id', $id) }}
				{{ Form::hidden('action', $action) }}
				{{ Form::button(lang('Action.submit'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
			</div>
		</div>
	@endif
{{ Form::close() }}