@extends('layouts.app')

@section('title', _m('dashboard-characters'))

@section('content')
	<h1>{{ _m('dashboard-characters') }}</h1>

	<div class="row">
		@foreach ($characters as $character)
			<div class="col-md-6 col-lg-4">
				<div class="card">
					<div class="card-body">
						<div class="d-flex justify-content-around">
							<character-avatar :character="{{ $character }}" :has-content="false" size="lg"></character-avatar>
						</div>
						<div class="d-flex justify-content-around mt-3">
							@if ($character->rank)
								<rank :item="{{ $character->rank }}"></rank>
							@else
								<rank></rank>
							@endif
						</div>
						<p class="text-center mt-3 mb-0">{{ $character->present()->name }}</p>
						<small class="d-block text-muted text-center">{{ $character->position->name }}</small>
					</div>
					<div class="card-footer">
						<div class="row">
							<div class="col-lg-6">
								<a href="#" class="btn btn-secondary btn-block mb-3 mb-lg-0">View</a>
							</div>
							<div class="col-lg-6">
								<a href="{{ route('characters.edit', $character) }}" class="btn btn-secondary btn-block">Edit</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		@endforeach
	</div>
@endsection