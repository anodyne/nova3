<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h3 class="modal-title">{{ $header }}</h3>
</div>

<div class="modal-body">{!! $body !!}</div>

@if ($footer)
	<div class="modal-footer">{!! $footer !!}</div>
@endif