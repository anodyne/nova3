<div class="row">
@foreach ($_icons as $key => $icon)
	<div class="col-lg-2">
		<button class="btn btn-default btn-block icn-size-16">{{ $icon }}</button>
		<p class="text-muted text-center">{{ $key }}</p>
	</div>
@endforeach
</div>