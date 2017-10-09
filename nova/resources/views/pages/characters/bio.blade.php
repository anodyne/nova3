@extends('layouts.app')

@section('title', 'Bio')

@section('content')
	<div class="row">
		<div class="col-md-3">
			<div class="mb-3">
				<img src="{{ $character->present()->avatarImage }}" alt="" class="img-fluid rounded">
			</div>

			<a href="#" class="btn btn-secondary btn-block">Edit</a>
			<a href="#" class="btn btn-secondary btn-block">View Images</a>
		</div>

		<div class="col-md-9">
			<h1 class="mt-0 mb-2">{{ $character->name }}</h1>

			@if ($character->rank)
				<div class="d-flex align-items-center mb-4">
					<rank :item="{{ $character->rank }}"></rank>
					<p class="lead mb-0 ml-3">{{ $character->rank->info->name }}</p>
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
		</div>
	</div>
@endsection