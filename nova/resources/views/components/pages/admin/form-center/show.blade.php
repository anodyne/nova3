<div class="page-header">
	<h1>{!! $form->present()->name !!} Entry</h1>
</div>

<div v-cloak>
	<mobile>
		<p><a href="{{ route('admin.form-center.entries', [$form->key]) }}" class="btn btn-default btn-lg btn-block">Back to Entries</a></p>
	</mobile>
	<desktop>
		<div class="btn-toolbar">
			<div class="btn-group">
				<a href="{{ route('admin.form-center.entries', [$form->key]) }}" class="btn btn-default">Back to Entries</a>
			</div>
		</div>
	</desktop>
</div>

<div class="row">
	<div class="col-md-4">
		<div class="well">
			<dl>
				<dt>Submitted By</dt>
				<dd>{!! $entry->user->present()->name !!}</dd>

				<dt>Submitted On</dt>
				<dd>{!! $entry->present()->createdAt !!}</dd>
			</dl>
		</div>
	</div>
</div>

{!! $form->present()->renderViewForm($entry->id) !!}