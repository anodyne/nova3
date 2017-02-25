<div id="{{ $id }}" class="modal fade">
	<div class="modal-dialog {{ $size or '' }}" role="document">
		<div class="modal-content">
			{!! partial('modal-content', compact('header', 'body', 'footer')) !!}
		</div>
	</div>
</div>