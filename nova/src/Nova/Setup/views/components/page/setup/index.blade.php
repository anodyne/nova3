<ul class="thumbnails">
	<li class="span4">
		<div class="thumbnail">
			@if ($db)
				<div class="icn text-success" data-icon="k"></div>
			@else
				<div class="icn muted" data-icon="-"></div>
			@endif

			<h4>Database Connection <small>Setup Nova's connection to the database.</small></h4>

			@if ( ! $db and ! $email)
				<p><a href="{{ URL::to('setup/config/db') }}" class="btn btn-primary btn-block">Start</a></p>
			@else
				<p><a href="{{ URL::to('setup/config/db') }}" class="btn btn-block">Start Over</a></p>
			@endif
		</div>
	</li>

	<li class="span4">
		<div class="thumbnail">
			@if ($email)
				<div class="icn text-success" data-icon="k"></div>
			@else
				<div class="icn muted" data-icon="-"></div>
			@endif

			<h4>Email Setup <small>Setup how Nova sends emails to players.</small></h4>

			@if ($db and ! $email)
				<p><a href="{{ URL::to('setup/config/email') }}" class="btn btn-primary btn-block">Start</a></p>
			@else
				<p><a href="{{ URL::to('setup/config/email') }}" class="btn btn-block">Start Over</a></p>
			@endif
		</div>
	</li>

	<li class="span4">
		<div class="thumbnail">
			<div class="icn muted" data-icon="-"></div>

			<h4>{{ Config::get('nova.app.name') }} {{ Config::get('nova.app.version') }} Setup <small>Install Nova or migrate from Nova 2.</small></h4>

			@if ($db and $email)
				<p><a href="{{ URL::to('setup/start') }}" class="btn btn-primary btn-block">Start</a></p>
			@else
				<p><div class="btn btn-block disabled">Start</div></p>
			@endif
		</div>
	</li>
</ul>