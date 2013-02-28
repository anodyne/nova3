<p>From here, you can see the status of genres and install or uninstall them as needed. The only limitation you have is that you can't uninstall the current active genre. If you want to uninstall the current active genre, first change the genre code in your Nova config file <code>app/config/nova.php</code>, save and upload the file, then come back here to uninstall that genre.</p>

<hr>

@if (isset($genres))
	<ul class="thumbnails">
	@foreach ($genres as $key => $genre)
		<li class="span4">
			<div class="thumbnail">
				<h4>{{ $genre['name'] }} <small>{{ strtoupper($key) }}</small></h4>

				<p>
					@if ($key == Config::get('nova.genre'))
						<span class="label label-info">Active Genre</span>
					@endif

					@if ( ! $genre['installed'])
						<span class="label">Not Installed</span>
					@else
						<span class="label label-success">Installed</span>
					@endif
				</p>

				<p>
					@if ( ! $genre['installed'])
						<button data-genre="{{ $key }}" class="js-do-install btn btn-primary btn-small">Install</button>
					@else
						@if ($key != Config::get('nova.genre'))
							<button data-genre="{{ $key }}" class="js-do-uninstall btn btn-danger btn-small">Uninstall</button>
						@else
							<button data-genre="{{ $key }}" class="js-do-uninstall btn btn-primary btn-small" disabled="disabled">Uninstall</button>
						@endif
					@endif
				</p>
			</div>
		</li>
	@endforeach
	</ul>

	<h3>Additional Genres</h3>

	<ul class="thumbnails">
	@foreach ($additional as $key => $genre)
		<li class="span4">
			<div class="thumbnail">
				<h4>{{ $genre['name'] }}</h4>

				<p>
					@if ($key == Config::get('nova.genre'))
						<span class="label label-info">Active Genre</span>
					@endif

					@if ( ! $genre['installed'])
						<span class="label">Not Installed</span>
					@else
						<span class="label label-success">Installed</span>
					@endif
				</p>

				<p>
					@if ( ! $genre['installed'])
						<button data-genre="{{ $key }}" class="js-do-install btn btn-primary btn-small">Install</button>
					@else
						@if ($key != Config::get('nova.genre'))
							<button data-genre="{{ $key }}" class="js-do-uninstall btn btn-danger btn-small">Uninstall</button>
						@else
							<button data-genre="{{ $key }}" class="js-do-uninstall btn btn-primary btn-small" disabled="disabled">Uninstall</button>
						@endif
					@endif
				</p>
			</div>
		</li>
	@endforeach
	</ul>
@endif