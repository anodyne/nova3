@extends('layouts.welcome')

@section('content')
	<div class="title m-b-md">
		Status
	</div>

	<ul class="nav nav-pills nav-justified mb-3" role="tablist">
		<li class="nav-item">
			<a class="nav-link active" data-toggle="tab" href="#aries" role="tab">NextGen Aries</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" data-toggle="tab" href="#gemini" role="tab">NextGen Gemini</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" data-toggle="tab" href="#orion" role="tab">NextGen Orion</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" data-toggle="tab" href="#beta1" role="tab">3.0 Beta 1</a>
		</li>
	</ul>

	<div class="tab-content">
		<div id="aries" class="tab-pane active" role="tabpanel">
			<div class="card">
				<div class="card-body">
					<h3 class="d-flex align-items-center justify-content-start mb-0">
						<span class="mr-auto">Setup</span>
						<i class="fa fa-code fa-fw"></i>
					</h3>

					<ul>
						<li>Update Nova</li>
						<li>Migrate from Nova 2</li>
						<li>Uninstall Nova</li>
					</ul>
				</div>
			</div>

			<div class="card">
				<div class="card-body">
					<h3 class="d-flex align-items-center justify-content-start mb-0">
						<span class="mr-auto">Characters</span>
						<i class="fa fa-code fa-fw"></i>
					</h3>

					<ul>
						<li>Card-style manifest</li>
						<li>Character bio</li>
					</ul>
				</div>
			</div>

			<div class="card text-white bg-success">
				<div class="card-body">
					<h3 class="d-flex align-items-center justify-content-start mb-0">
						<span class="mr-auto">Genre Assets</span>
						<i class="fa fa-check-circle fa-fw"></i>
					</h3>
				</div>
			</div>

			<div class="card text-white bg-success">
				<div class="card-body">
					<h3 class="d-flex align-items-center justify-content-start mb-0">
						<span class="mr-auto">Users</span>
						<i class="fa fa-check-circle fa-fw"></i>
					</h3>
				</div>
			</div>

			<div class="card text-white bg-success">
				<div class="card-body">
					<h3 class="d-flex align-items-center justify-content-start mb-0">
						<span class="mr-auto">Authorization</span>
						<i class="fa fa-check-circle fa-fw"></i>
					</h3>
				</div>
			</div>

			<div class="card text-white bg-success">
				<div class="card-body">
					<h3 class="d-flex align-items-center justify-content-start mb-0">
						<span class="mr-auto">Authentication</span>
						<i class="fa fa-check-circle fa-fw"></i>
					</h3>
				</div>
			</div>
		</div>

		<div id="orion" class="tab-pane">
			<div class="card">
				<div class="card-body">
					<h3 class="d-flex align-items-center justify-content-start mb-0">
						<span class="mr-auto">Dynamic Forms</span>
						<i class="fa fa-road fa-fw"></i>
					</h3>
				</div>
			</div>

			<div class="card">
				<div class="card-body">
					<h3 class="d-flex align-items-center justify-content-start mb-0">
						<span class="mr-auto">Settings</span>
						<i class="fa fa-road fa-fw"></i>
					</h3>
				</div>
			</div>

			<div class="card">
				<div class="card-body">
					<h3 class="d-flex align-items-center justify-content-start mb-0">
						<span class="mr-auto">Application Review Center</span>
						<i class="fa fa-road fa-fw"></i>
					</h3>
				</div>
			</div>
		</div>

		<div id="gemini" class="tab-pane">
			<div class="card">
				<div class="card-body">
					<h3 class="d-flex align-items-center justify-content-start mb-0">
						<span class="mr-auto">Themes</span>
						<i class="fa fa-road fa-fw"></i>
					</h3>
				</div>
			</div>

			<div class="card">
				<div class="card-body">
					<h3 class="d-flex align-items-center justify-content-start mb-0">
						<span class="mr-auto">Stories</span>
						<i class="fa fa-road fa-fw"></i>
					</h3>
				</div>
			</div>

			<div class="card">
				<div class="card-body">
					<h3 class="d-flex align-items-center justify-content-start mb-0">
						<span class="mr-auto">Private Messages</span>
						<i class="fa fa-road fa-fw"></i>
					</h3>
				</div>
			</div>
		</div>

		<div id="beta1" class="tab-pane">
			<div class="card">
				<div class="card-body">
					<h3 class="d-flex align-items-center justify-content-start mb-0">
						<span class="mr-auto">Extensions</span>
						<i class="fa fa-road fa-fw"></i>
					</h3>
				</div>
			</div>

			<div class="card">
				<div class="card-body">
					<h3 class="d-flex align-items-center justify-content-start mb-0">
						<span class="mr-auto">Menus</span>
						<i class="fa fa-road fa-fw"></i>
					</h3>
				</div>
			</div>
		</div>
	</div>
@endsection