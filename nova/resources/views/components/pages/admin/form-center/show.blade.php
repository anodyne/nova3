<div class="page-header">
	<h1>{!! $form->present()->name !!} Entry</h1>
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

	<div class="row">
		<div class="col-md-4">
			<div class="well">
				<dl>
					<dt>Submitted By</dt>
					<dd>{!! $entry->present()->submitter !!}</dd>

					<dt>Submitted On</dt>
					<dd>{!! $entry->present()->createdAt !!}</dd>
				</dl>
			</div>
		</div>
	</div>
</div>

{!! $form->present()->renderViewForm($entry->id) !!}