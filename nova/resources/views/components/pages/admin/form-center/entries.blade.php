<div class="page-header">
	<h1>{!! $form->present()->name !!} Entries</h1>
</div>

@if ($entries->total() > 0)
	{!! $entries->render() !!}

	<div class="data-table data-table-bordered data-table-striped">
		<div class="row">
			<div class="col-md-6">
				<p><strong>Entry</strong></p>
			</div>
			<div class="col-md-3">
				<p><strong>Submission Info</strong></p>
			</div>
			<div class="col-md-3"></div>
		</div>
		@foreach ($entries as $entry)
			<div class="row">
				<div class="col-md-6">
					<p>{!! $entry->present()->identifier !!}</p>
					<p class="text-sm text-muted">{!! $entry->present()->createdAtRelative !!}</p>
				</div>
				<div class="col-md-3">
					<p>{!! $entry->present()->submitter !!}</p>
				</div>
				<div class="col-md-3" v-cloak>
					<mobile>
						<p><a href="{{ route('admin.form-center.show', [$form->key, $entry->id]) }}" class="btn btn-secondary btn-lg btn-block">{!! icon('visible') !!}<span>View</span></a></p>

						@can('editEntries', $form)
							<p><a href="{{ route('admin.form-center.edit', [$form->key, $entry->id]) }}" class="btn btn-secondary btn-lg btn-block">{!! icon('edit') !!}<span>Edit</span></a></p>
						@endcan

						@can('removeEntries', $form)
							<p><a href="#" class="btn btn-danger btn-lg btn-block" data-form-key="{{ $form->key }}" data-id="{{ $entry->id }}" @click.prevent="removeEntry">{!! icon('delete') !!}<span>Remove</span></a></p>
						@endcan
					</mobile>
					<desktop>
						<div class="btn-toolbar pull-right">
							<div class="btn-group">
								<a href="{{ route('admin.form-center.show', [$form->key, $entry->id]) }}" class="btn btn-secondary">{!! icon('visible') !!}<span>View</span></a>

								@can('editEntries', $form)
									<a href="{{ route('admin.form-center.edit', [$form->key, $entry->id]) }}" class="btn btn-secondary">{!! icon('edit') !!}<span>Edit</span></a>
								@endcan
							</div>

							@can('removeEntries', $form)
								<div class="btn-group">
									<a href="#" class="btn btn-danger" data-form-key="{{ $form->key }}" data-id="{{ $entry->id }}" @click.prevent="removeEntry">{!! icon('delete') !!}<span>Remove</span></a>
								</div>
							@endcan
						</div>
					</desktop>
				</div>
			</div>
		@endforeach
	</div>

	{!! $entries->render() !!}
@else
	{!! alert('warning', "No form entries found") !!}
@endif

@can('removeEntries', $form)
	{!! modal(['id' => "removeFormEntry", 'header' => "Remove Form Entry"]) !!}
@endcan