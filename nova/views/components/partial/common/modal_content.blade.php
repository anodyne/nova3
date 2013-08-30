<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h3 class="modal-title">{{ $modalHeader }}</h3>
		</div>

		<div class="modal-body">{{ $modalBody }}</div>

		@if ($modalFooter)
			<div class="modal-footer">{{ $modalFooter }}</div>
		@endif
	</div>
</div>