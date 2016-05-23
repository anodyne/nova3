<div class="page-header">
	<h1>Edit {!! $form->present()->name !!} Entry</h1>
</div>

<div v-cloak>
	<mobile>
		<p><a href="{{ route('admin.form-center.entries', [$form->key]) }}" class="btn btn-default btn-lg btn-block">{!! icon('arrow-back') !!}<span>Back to Entries</span></a></p>
	</mobile>
	<desktop>
		<div class="btn-toolbar">
			<div class="btn-group">
				<a href="{{ route('admin.form-center.entries', [$form->key]) }}" class="btn btn-default">{!! icon('arrow-back') !!}<span>Back to Entries</span></a>
			</div>
		</div>
	</desktop>

	{!! Form::open(['route' => ['admin.form-center.update', $form->key, $entryId], 'method' => 'put']) !!}
		{!! $form->present()->renderEditForm($entryId, false) !!}
	{!! Form::close() !!}
</div>