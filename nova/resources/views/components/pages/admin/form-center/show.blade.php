<div v-cloak>
	<mobile>
		<p><a href="{{ route('admin.form-center.index') }}" class="btn btn-default btn-lg btn-block">Back to Form Center</a></p>
	</mobile>
	<desktop>
		<div class="btn-toolbar">
			<div class="btn-group">
				<a href="{{ route('admin.form-center.index') }}" class="btn btn-default">Back to Form Center</a>
			</div>
		</div>
	</desktop>

	<h2>{!! $form->present()->name !!}</h2>

	{!! $form->present()->message !!}

	<mobile>
		<div class="row">
			<div class="col-sm-6">
				<p><a href="#" class="btn btn-success btn-lg btn-block" @click.prevent="switchToForm">Fill Out Form</a></p>
			</div>
			<div class="col-sm-6">
				<p><a href="#" class="btn btn-default btn-lg btn-block" @click.prevent="switchToEntries">Show My Entries</a></p>
			</div>
		</div>
	</mobile>
	<desktop>
		<div class="btn-toolbar">
			<div class="btn-group">
				<a href="#" class="btn btn-success" @click.prevent="switchToForm">Fill Out Form</a>
			</div>
			<div class="btn-group">
				<a href="#" class="btn btn-default" @click.prevent="switchToEntries">Show My Entries</a>
			</div>
		</div>
	</desktop>

	<div v-if="showEntries">
		@if ($entries->count() > 0)
			<h3>My Entries</h3>

			<div class="data-table data-table-striped data-table-bordered">
			@foreach ($entries as $entry)
				<div class="row">
					<div class="col-md-8">
						<p>{{ $entry->present()->identifier }}</p>
						<p class="text-sm text-muted">{{ $entry->present()->createdAt }}</p>
					</div>
					<div class="col-md-4">
						<mobile>
							@can('editFormCenterEntry', $form)
								<p><a href="#" class="btn btn-default btn-lg btn-block" data-form-key="{{ $form->key }}" data-form-state="edit" data-id="{{ $entry->id }}">Edit</a></p>
							@endcan

							@can('removeFormCenterEntry', $form)
								<p><a href="#" class="btn btn-danger btn-lg btn-block" data-form-key="{{ $form->key }}" data-id="{{ $entry->id }}" @click.prevent="removeEntry">Remove</a></p>
							@endcan
						</mobile>
						<desktop>
							<div class="btn-toolbar pull-right">
								<div class="btn-group">
									<a href="#" class="btn btn-default" data-id="{{ $entry->id }}" @click.prevent="switchToViewEntry">View</a>
									
									@can('editFormCenterEntry', $form)
										<a href="#" class="btn btn-default" data-id="{{ $entry->id }}" @click.prevent="switchToEditEntry">Edit</a>
									@endcan
								</div>

								@can('removeFormCenterEntry', $form)
									<div class="btn-group">
										<a href="#" class="btn btn-danger" data-form-key="{{ $form->key }}" data-id="{{ $entry->id }}" @click.prevent="removeEntry">Remove</a>
									</div>
								@endcan
							</div>
						</desktop>
					</div>
				</div>
			@endforeach
			</div>
		@else
			{!! alert('warning', "You don't have any entries for this form") !!}
		@endif
	</div>

	<div v-if="showForm">
		{!! $form->present()->renderNewForm() !!}
	</div>

	<div v-if="showEntry" id="formCenterEntry"></div>
</div>

@can('removeFormCenterEntry', $form)
	{!! modal(['id' => "removeFormEntry", 'header' => "Remove Form Entry"]) !!}
@endcan