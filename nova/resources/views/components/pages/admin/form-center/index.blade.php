@if ($forms->count() > 0)
	<div class="row">
	@foreach ($forms as $form)
		@can('viewInFormCenter', $form)
			<div class="col-sm-6 col-md-4">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">{!! $form->present()->name !!}</h3>
					</div>
					<div class="panel-body">
						<p><a href="{{ route('admin.form-center.form', [$form->key]) }}" class="btn btn-default btn-lg btn-block"><span>View</span> {!! icon('arrow-forward') !!}</a></p>
					</div>
				</div>
			</div>
		@endcan
	@endforeach
	</div>
@else
	{!! alert('warning', "No Form Center forms found") !!}
@endif