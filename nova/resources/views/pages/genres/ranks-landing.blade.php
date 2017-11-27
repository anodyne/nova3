@extends('layouts.app')

@section('title', _m('genre-ranks', [2]))

@section('content')
	<h1>{{ _m('genre-ranks', [2]) }}</h1>

	<div class="card-deck">
		<a href="{{ route('ranks.groups.index') }}" class="card">
			<div class="card-body">
				<div class="text-center text-subtle mb-4">
					{{ svg_icon('sitemap') }}
				</div>
				<h4 class="card-title text-center">{{ _m('genre-rank-groups', [2]) }}</h4>
				<p class="card-text">{{ _m('genre-rank-groups-explain') }}</p>
			</div>
		</a>

		<a href="{{ route('ranks.info.index') }}" class="card">
			<div class="card-body">
				<div class="text-center text-subtle mb-4">
					{{ svg_icon('info-circle') }}
				</div>
				<h4 class="card-title text-center">{{ _m('genre-rank-info') }}</h4>
				<p class="card-text">{{ _m('genre-rank-info-explain') }}</p>
			</div>
		</a>

		<a href="{{ route('ranks.items.index') }}" class="card">
			<div class="card-body">
				<div class="text-center text-subtle mb-4">
					{{ svg_icon('angle-double-up') }}
				</div>
				<h4 class="card-title text-center">{{ _m('genre-ranks', [2]) }}</h4>
				<p class="card-text">{{ _m('genre-ranks-explain') }}</p>
			</div>
		</a>
	</div>
@endsection