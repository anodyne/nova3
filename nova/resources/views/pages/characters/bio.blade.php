@extends('layouts.app')

@section('title', $character->name)

@section('content')
	<div class="row">
		<div class="col-md-3">
			<div class="mb-3">
				<a href="{{ $character->present()->avatarImage }}" data-lightbox="gallery">
					<img src="{{ $character->present()->avatarImage }}" alt="" class="img-fluid rounded">
				</a>

				@if ($images->count() > 0)
					<div class="d-none">
						@foreach ($images as $image)
							<a href="{{ $image->url }}" data-lightbox="gallery">
								<img src="{{ $image->url }}" alt="" class="img-fluid rounded">
							</a>
						@endforeach
					</div>
				@endif
			</div>

			{{-- <a href="#" class="btn btn-secondary btn-block d-flex align-items-center justify-content-around"><span>{!! icon('edit') !!} Edit</span></a>
			<a href="#" class="btn btn-secondary btn-block d-flex align-items-center justify-content-around"><span>{!! icon('images') !!} View Images</span></a> --}}
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
						<label>{{ _m('characters-position-primary') }}</label>
					@else
						<label>{{ _m('genre-positions', [1]) }}</label>
					@endif
					<p>{{ $character->primaryPosition->name }}</p>
				</div>

				@if ($character->positions->count() > 1)
					<div class="form-group">
						<label>{{ _m('characters-position-other') }}</label>
						@foreach ($character->positions as $position)
							<p>{{ $position->name }}</p>
						@endforeach
					</div>
				@endif
			</fieldset>
		</div>
	</div>
@endsection