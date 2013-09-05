<div class="row">
	<div class="col-lg-4">
		<div class="thumbnail">
			@if ($db)
				<div class="icn text-success" data-icon="k"></div>
			@else
				<div class="icn text-error" data-icon="-"></div>
			@endif

			<h4>Database Connection</h4>

			@if ( ! $db and ! $email)
				<p><a href="{{ URL::to('setup/config/db') }}" class="btn btn-primary btn-block">Start</a></p>
			@else
				<p><a href="{{ URL::to('setup/config/db') }}" class="btn btn-block">Start Over</a></p>
			@endif
		</div>
	</div>

	<div class="col-lg-4">
		<div class="thumbnail">
			@if ($email)
				<div class="icn text-success" data-icon="k"></div>
			@else
				<div class="icn text-error" data-icon="-"></div>
			@endif

			<h4>Email Setup</h4>

			@if ( ! $db and ! $email)
				<p><div class="btn btn-block disabled">Start</div></p>
			@elseif ($db and ! $email)
				<p><a href="{{ URL::to('setup/config/email') }}" class="btn btn-primary btn-block">Start</a></p>
			@else
				<p><a href="{{ URL::to('setup/config/email') }}" class="btn btn-block">Start Over</a></p>
			@endif
		</div>
	</div>

	<div class="col-lg-4">
		<div class="thumbnail">
			<div class="icn text-muted" data-icon="-"></div>

			<h4>{{ Config::get('nova.app.name') }} {{ Config::get('nova.app.version') }} Setup</h4>

			@if ($db and $email)
				<p><a href="{{ URL::to('setup/start') }}" class="btn btn-primary btn-block">Start</a></p>
			@else
				<p><div class="btn btn-block disabled">Start</div></p>
			@endif
		</div>
	</div>
</div>