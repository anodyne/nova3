@extends('layouts.app')

@section('content')
	<h1>Write Story Entry</h1>

	<div class="row">
		<div class="col">
			<div class="form-group">
				<label>Title</label>
				<input type="text" class="form-control">
			</div>

			<div class="form-group">
				<label>Location</label>
				<input type="text" class="form-control">
			</div>

			<div class="form-group">
				<label>Body</label>
				<textarea class="form-control" rows="15"></textarea>
			</div>

			<div class="form-group">
				<button class="btn btn-primary">Submit</button>
			</div>
		</div>

		<div class="col-auto">
			<div class="d-flex align-items-center mb-3">
				<i class="fa fa-check-circle fa-fw fa-lg text-success"></i>
				<span class="ml-2">
					<avatar :item="{{ Nova\Characters\Character::find(1) }}" :show-status="false" size="sm"></avatar>
				</span>
			</div>

			<div class="d-flex align-items-center mb-3">
				<i class="fa fa-exclamation-circle fa-fw fa-lg text-warning"></i>
				<span class="ml-2">
					<avatar :item="{{ Nova\Characters\Character::find(2) }}" :show-status="false" size="sm"></avatar>
				</span>
			</div>

			<div class="d-flex align-items-center mb-3">
				<i class="fa fa-check-circle fa-fw fa-lg text-success"></i>
				<span class="ml-2">
					<avatar :item="{{ Nova\Characters\Character::find(3) }}" :show-status="false" size="sm"></avatar>
				</span>
			</div>

			<div class="mt-4">
				<button class="btn btn-sm btn-secondary">Add author</button>
			</div>
		</div>
	</div>
@endsection