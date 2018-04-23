<h1>Extensions</h1>

<div class="button-toolbar">
	<div class="dropdown">
		<div class="dropdown-trigger">
			<button class="button is-primary" aria-haspopup="true" aria-controls="dropdown-menu">
				<icon name="add" classes="mr-2"></icon>
				<span>Add Extension</span>
				<icon name="chevron-down" size="small" classes="ml-1"></icon>
			</button>
	  	</div>

	  	<div class="dropdown-menu" id="dropdown-menu" role="menu">
			<div class="dropdown-content">
				<a href="#" class="dropdown-item">Create extension</a>
				<div class="dropdown-item is-subtle"><em>Create a record in the database for an existing extension.</em></div>
				<hr class="dropdown-divider">
				<a href="#" class="dropdown-item">Generate extension framework</a>
				<div class="dropdown-item is-subtle"><em>Generate everything you need to start developing your own extension.</em></div>
			</div>
		</div>
	</div>
</div>

@if ($extensionsToBeInstalled->count() > 0)
	<div class="w-2/5 card">
		<div class="card-header">
			<div class="flex items-center">
				<icon name="info" :wrapper="{ class: 'card-icon is-info' }"></icon>
				<div class="card-title">Extensions to be Installed</div>
			</div>
		</div>
		<div class="card-content">
			@foreach ($extensionsToBeInstalled as $path)
				<div class="py-2 px-2 flex items-center justify-between rounded">
					<div>{{ $path }}</div>
					<div class="flex-shrink">
						<button class="bg-transparent border-2 border-grey-light text-grey-dark py-1 px-2 text-sm button">Install</button>
					</div>
				</div>
			@endforeach
			<div class="py-2 px-2 flex items-center justify-between rounded">
				<div>{{ $path }}</div>
				<div class="flex-shrink">
					<button class="bg-transparent border-2 border-grey-light text-grey-dark py-1 px-2 text-sm button">Install</button>
				</div>
			</div>
			<div class="py-2 px-2 flex items-center justify-between rounded">
				<div>{{ $path }}</div>
				<div class="flex-shrink">
					<button class="bg-transparent border-2 border-grey-light text-grey-dark py-1 px-2 text-sm button">Install</button>
				</div>
			</div>
		</div>
	</div>
@endif

@if ($extensions->count() > 0)
@else
	<div class="alert is-warning">
		<p>There are no extensions installed. You can find extensions at <a href="https://xtras.anodyne-productions.com" target="_blank" rel="noopener" class="alert-link">AnodyneXtras</a>.</p>
	</div>
@endif