<div v-cloak>
	<mobile>
		<p><a href="{{ route('admin.form-center.index') }}" class="btn btn-default btn-lg btn-block">{!! icon('arrow-back') !!}<span>Back to Form Center</span></a></p>
	</mobile>
	<desktop>
		<div class="btn-toolbar">
			<div class="btn-group">
				<a href="{{ route('admin.form-center.index') }}" class="btn btn-default">{!! icon('arrow-back') !!}<span>Back to Form Center</span></a>
			</div>
		</div>
	</desktop>

	<h2>{!! $form->present()->name !!}</h2>

	{!! $form->present()->message !!}

	<mobile>
		@if ($_user->canAddFormEntry($form) and $form->allow_multiple_submissions)
			<div class="row">
				<div class="col-sm-6">
					<p><a href="#" class="btn btn-success btn-lg btn-block" @click.prevent="switchToForm">{!! icon('add') !!}<span>Fill Out Form</span></a></p>
				</div>
				<div class="col-sm-6">
					<p><a href="#" class="btn btn-default btn-lg btn-block" @click.prevent="switchToEntries">{!! icon('user') !!}<span>Show My {{ Str::plural('Entry', $entries->count()) }}</span></a></p>
				</div>
			</div>
		@endif
	</mobile>
	<desktop>
		@if ($_user->canAddFormEntry($form) and $form->allow_multiple_submissions)
			<div class="btn-toolbar">
				<div class="btn-group">
					<a href="#" class="btn btn-success" @click.prevent="switchToForm">{!! icon('add') !!}<span>Fill Out Form</span></a>
				</div>

				<div class="btn-group">
					<a href="#" class="btn btn-default" @click.prevent="switchToEntries">{!! icon('user') !!}<span>Show My {{ Str::plural('Entry', $entries->count()) }}</span></a>
				</div>
			</div>
		@endif
	</desktop>

	<div v-show="loading">
		<h4 class="text-center">{!! HTML::image('nova/resources/images/ajax-loader.gif') !!}</h4>
	</div>

	<div v-show="showEntries">
		@if ($entries->count() > 0)
			<h3>My {{ Str::plural('Entry', $entries->count()) }}</h3>

			<div class="data-table data-table-striped data-table-bordered">
			@foreach ($entries as $entry)
				<div class="row">
					<div class="col-md-8">
						<p>{{ $entry->present()->identifier }}</p>
						<p class="text-sm text-muted">{{ $entry->present()->createdAt }}</p>
					</div>
					<div class="col-md-4">
						<mobile>
							<p><a href="#" class="btn btn-default btn-lg btn-block" data-form-key="{{ $form->key }}" data-id="{{ $entry->id }}" @click.prevent="switchToViewEntry">{!! icon('visible') !!}<span>View</span></a></p>

							@can('editFormCenterEntry', $form)
								<p><a href="#" class="btn btn-default btn-lg btn-block" data-form-key="{{ $form->key }}" data-id="{{ $entry->id }}" @click.prevent="switchToEditEntry">{!! icon('edit') !!}<span>Edit</span></a></p>
							@endcan

							@can('removeFormCenterEntry', $form)
								<p><a href="#" class="btn btn-danger btn-lg btn-block" data-form-key="{{ $form->key }}" data-id="{{ $entry->id }}" @click.prevent="removeEntry">{!! icon('delete') !!}<span>Remove</span></a></p>
							@endcan
						</mobile>
						<desktop>
							<div class="btn-toolbar pull-right">
								<div class="btn-group">
									<a href="#" class="btn btn-default" data-form-key="{{ $form->key }}" data-id="{{ $entry->id }}" @click.prevent="switchToViewEntry">{!! icon('visible') !!}<span>View</span></a>
									
									@can('editFormCenterEntry', $form)
										<a href="#" class="btn btn-default" data-form-key="{{ $form->key }}" data-id="{{ $entry->id }}" @click.prevent="switchToEditEntry">{!! icon('edit') !!}<span>Edit</span></a>
									@endcan
								</div>

								@can('removeFormCenterEntry', $form)
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
		@else
			{!! alert('warning', "You don't have any entries for this form") !!}
		@endif
	</div>

	<div v-show="showForm">
		@if ($_user->canAddFormEntry($form) and ($form->allow_multiple_submissions or ( ! $form->allow_multiple_submissions and $entries->count() == 0)))
			{!! $form->present()->renderNewForm() !!}
		@else
			{!! alert('danger', "You cannot add entries to this form") !!}
		@endif
	</div>

	<div v-show="showEntry" id="formCenterEntry"></div>
</div>

@can('removeFormCenterEntry', $form)
	{!! modal(['id' => "removeFormEntry", 'header' => "Remove Form Entry"]) !!}
@endcan