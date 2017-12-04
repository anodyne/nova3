<div class="container">
	<div class="row justify-content-around">
		<div class="col-xs-12 col-md-8 col-lg-5">
			@if (session()->has('flash'))
				<div class="alert alert-{{ session('flash.level') }}">
					@if (session('flash.title'))
						<h4 class="alert-heading">{{ session('flash.title') }}</h4>
					@endif

					<p>{{ session('flash.message') }}</p>
				</div>
			@endif

			{!! $content or false !!}
		</div>
	</div>
</div>