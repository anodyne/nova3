{{ Form::open(['url' => 'admin/formviewer']) }}
	{{ $form }}

	<div class="row">
		<div class="col-lg-12">
			{{ Form::token() }}
			{{ Form::hidden('id', $id) }}
			{{ Form::hidden('action', $action) }}
			{{ Form::button(lang('Action.submit'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
		</div>
	</div>
{{ Form::close() }}