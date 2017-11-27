@extends('layouts.setup-landing')

@section('title', $title)

@section('header', $header)

@section('content')
	<div class="row">
		<div class="col-md-8 offset-md-2">
			<div class="card no-border text-center">
				<div class="card-topper-danger"></div>
				<div class="card-body">
					<h1>{{ $header }}</h1>
					<div>
						@icon('setup/exclamation-triangle')
					</div>
					<p class="lead text-center">{{ $message }}</p>
				</div>
			</div>
		</div>
	</div>
@endsection