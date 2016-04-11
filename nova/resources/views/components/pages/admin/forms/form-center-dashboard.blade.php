<h2>{!! $form->present()->name !!}</h2>

{!! $form->present()->message !!}

<div v-cloak>
	<mobile>
		<p><a href="#" data-form-key="{{ $form->key }}" data-form-state="create" class="btn btn-success btn-lg btn-block" @click.prevent="switchView">Fill Out the Form</a></p>
	</mobile>
	<desktop>
		<div class="btn-toolbar">
			<div class="btn-group">
				<a href="#" data-form-key="{{ $form->key }}" data-form-state="create" class="btn btn-success" @click.prevent="switchView">Fill Out the Form</a>
			</div>
		</div>
	</desktop>
</div>

@if ($entries->count() > 0)
	<hr>

	<h3>My Entries</h3>

	<div class="data-table data-table-striped data-table-bordered">
	@foreach ($entries as $entry)
		<div class="row">
			<div class="col-md-8">
				<p>{{ $entry->present()->createdAt }}</p>
			</div>
			<div class="col-md-4">
				<mobile>
					<p><a href="#" class="btn btn-default btn-lg btn-block" data-form-key="{{ $form->key }}" data-form-state="edit" data-id="{{ $entry->id }}">Edit</a></p>

					<p><a href="#" class="btn btn-danger btn-lg btn-block">Remove</a></p>
				</mobile>
				<desktop>
					<div class="btn-toolbar pull-right">
						<div class="btn-group">
							<a href="#" class="btn btn-default" data-form-key="{{ $form->key }}" data-form-state="edit" data-id="{{ $entry->id }}">Edit</a>
						</div>
						<div class="btn-group">
							<a href="#" class="btn btn-danger">Remove</a>
						</div>
					</div>
				</desktop>
			</div>
		</div>
	@endforeach
	</div>
@endif