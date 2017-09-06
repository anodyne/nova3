@extends('layouts.welcome')

@section('content')
	<h1>Test</h1>

	<h2>Tiny</h2>
	<div class="row">
		<div class="col">
			<div class="mb-4">
				<avatar :item="{{ $character1 }}"
						layout="stacked"
						size="xs"
						:show-status="true"></avatar>
			</div>
		</div>
		<div class="col">
			<div class="mb-4">
				<avatar :item="{{ $character1 }}"
						layout="spread"
						size="xs"
						:show-status="true"></avatar>
			</div>
		</div>
	</div>

	<h2>Small</h2>
	<div class="row">
		<div class="col">
			<div class="mb-4">
				<avatar :item="{{ $character1 }}"
						layout="stacked"
						size="sm"
						:show-status="true"></avatar>
			</div>
		</div>
		<div class="col">
			<div class="mb-4">
				<avatar :item="{{ $character1 }}"
						layout="spread"
						size="sm"
						:show-status="true"></avatar>
			</div>
		</div>
	</div>

	<h2>Normal</h2>
	<div class="row">
		<div class="col">
			<div class="mb-4">
				<avatar :item="{{ $character1 }}"
						layout="stacked"
						:show-status="true"></avatar>
			</div>
		</div>
		<div class="col">
			<div class="mb-4">
				<avatar :item="{{ $character1 }}"
						layout="spread"
						:show-status="true"></avatar>
			</div>
		</div>
	</div>

	<h2>Medium</h2>
	<div class="row">
		<div class="col">
			<div class="mb-4">
				<avatar :item="{{ $character1 }}"
						layout="stacked"
						size="md"
						:show-status="true"></avatar>
			</div>
		</div>
		<div class="col">
			<div class="mb-4">
				<avatar :item="{{ $character1 }}"
						layout="spread"
						size="md"
						:show-status="true"></avatar>
			</div>
		</div>
	</div>

	<h2>Large</h2>
	<div class="row">
		<div class="col">
			<div class="mb-4">
				<avatar :item="{{ $character1 }}"
						layout="stacked"
						size="lg"
						:show-status="true"></avatar>
			</div>
		</div>
		<div class="col">
			<div class="mb-4">
				<avatar :item="{{ $character1 }}"
						layout="spread"
						size="lg"
						:show-status="true"></avatar>
			</div>
		</div>
	</div>

	<h2>Jumbo</h2>
	<div class="row">
		<div class="col">
			<div class="mb-4">
				<avatar :item="{{ $character1 }}"
						layout="stacked"
						size="xl"
						:show-status="true"></avatar>
			</div>
		</div>
		<div class="col">
			<div class="mb-4">
				<avatar :item="{{ $character1 }}"
						layout="spread"
						size="xl"
						:show-status="true"></avatar>
			</div>
		</div>
	</div>
@endsection