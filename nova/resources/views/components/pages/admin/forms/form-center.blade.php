<div class="row">
	<div class="col-md-3">
		<div class="list-group">
			@foreach ($forms as $form)
				<a href="#" class="list-group-item">{!! $form->present()->name !!}</a>
			@endforeach
		</div>
	</div>

	<div class="col-md-9 form-center-container">
		@php($testForm = $forms->first())
		
		<desktop>
			<div class="btn-toolbar pull-right">
				<div class="btn-group">
					<a href="#" class="btn btn-success">Create New Form Record</a>
				</div>
			</div>
		</desktop>

		<h2>{!! $testForm->present()->name !!}</h2>

		{!! $testForm->present()->message !!}

		@if (count($myForms) > 0)
			<h3>My Records</h3>

			<div class="data-table data-table-striped data-table-bordered">
			@foreach ($myForms as $mf)
				<div class="row">
					<div class="col-md-8">
						<p>{{ ucfirst($mf) }}</p>
					</div>
					<div class="col-md-4">
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
	</div>
</div>