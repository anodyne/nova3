<nav class="navbar navbar-default">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a href="{{ route('home') }}" class="navbar-brand">{{ $_settings->get('sim_name') }}</a>
		</div>
		<div id="navbar" class="navbar-collapse collapse">
			<ul class="nav navbar-nav">
			@foreach ($menuMainItems as $mainMenuItem)
				@if (array_key_exists($mainMenuItem->id, $menuSubItems))
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ $mainMenuItem->present()->title }} <span class="caret"></span></a>
						<ul class="dropdown-menu">
						@foreach ($menuSubItems[$mainMenuItem->id] as $subMenuItem)
							@if ($subMenuItem->type == "divider")
								<li class="divider"></li>
							@else
								<li>{!! $subMenuItem->present()->anchorTag() !!}</li>
							@endif
						@endforeach
						</ul>
					</li>
				@else
					@if ($mainMenuItem->type == 'divider')
						<li class="divider"></li>
					@else
						<li>{!! $mainMenuItem->present()->anchorTag() !!}</li>
					@endif
				@endif
			@endforeach
			</ul>

			<ul class="nav navbar-nav navbar-right">
				@if (Auth::check())
					<li><a href="{{ route('logout') }}">Log Out</a></li>
				@else
					<li><a href="{{ route('login') }}">Log In</a></li>
				@endif
			</ul>
		</div>
	</div>
</nav>