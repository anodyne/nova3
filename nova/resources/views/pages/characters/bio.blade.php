@extends('layouts.app')

@section('title', 'Bio')

@section('content')
	<div class="row">
		<div class="col-md-3">
			<div class="mb-3">
				<img src="{{ $character->present()->avatarImage }}" alt="" class="img-fluid rounded">
			</div>

			<a href="#" class="btn btn-secondary btn-block d-flex align-items-center justify-content-around"><span>{!! icon('edit') !!} Edit</span></a>
			<a href="#" class="btn btn-secondary btn-block d-flex align-items-center justify-content-around"><span>{!! icon('images') !!} View Images</span></a>
		</div>

		<div class="col-md-9">
			<fieldset>
				<legend>{{ $character->name }}</legend>

				@if ($character->rank)
					<div class="d-flex align-items-center mb-4">
						<rank :item="{{ $character->rank }}"></rank>
						<p class="mb-0 ml-3">{{ $character->rank->info->name }}</p>
					</div>
				@endif

				<div class="form-group">
					@if ($character->positions->count() > 1)
						<label class="form-control-label">Primary Position</label>
					@else
						<label class="form-control-label">Position</label>
					@endif
					<p>{{ $character->primaryPosition->name }}</p>
				</div>

				@if ($character->positions->count() > 1)
					<div class="form-group">
						<label class="form-control-label">Other Positions</label>
						@foreach ($character->positions as $position)
							<p>{{ $position->name }}</p>
						@endforeach
					</div>
				@endif
			</fieldset>
		</div>
	</div>
@endsection