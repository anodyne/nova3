<div class="row">
@foreach ($_icons as $key => $icon)
	<div class="col-6 col-sm-4 col-lg-2">
		{{ Form::button($icon, ['class' => 'btn btn-default btn-block icn-size-16']) }}
		<p class="text-muted text-center">{{ $key }}</p>
	</div>
@endforeach
</div>