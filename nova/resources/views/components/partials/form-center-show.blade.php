@php
$selectedForm = $forms->first();
$entries = $myForms->where('form_id', $selectedForm->id);
@endphp

<mobile></mobile>
<desktop>
	<div class="btn-toolbar pull-right">
		<div class="btn-group">
			<a href="#" class="btn btn-success">New</a>
		</div>
	</div>
</desktop>

<h2>{!! $form->present()->name !!}</h2>

{!! $form->present()->message !!}

@if ($entries->count() > 0)
	<h3>My Entries</h3>

	<div class="data-table data-table-striped data-table-bordered">
	@foreach ($entries as $entry)
		<div class="row">
			<div class="col-md-8">
				<p>{{ $entry }}</p>
			</div>
			<div class="col-md-4">
				<mobile></mobile>
				<desktop>
					<div class="btn-toolbar pull-right">
						<div class="btn-group">
							<a href="#" class="btn btn-default">Edit</a>
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