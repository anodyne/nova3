<div class="modal-header">
	<h5 class="modal-title">{{ $header }}</h5>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>

<div class="modal-body">
	{!! $body !!}
</div>

@if ($footer)
	<div class="modal-footer">
		{!! $footer !!}
	</div>
@endif