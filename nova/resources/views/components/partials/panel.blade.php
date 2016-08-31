<div class="modal docked docked-right" id="panel">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header text-center">
				<!--<div class="btn-group">
					<button class="btn btn-default" style="width: 50%;">Notifications</button>

					<button class="btn btn-default" style="width: 50%;">Announcements</button>
				</div>-->

				<h3 class="text-center">Notifications</h3>
			</div>

			<div class="modal-body">
				<!-- List Of Notifications -->
				<div>
					@foreach (user()->unreadNotifications as $notification)
						{!! partial('notification', compact('notification')) !!}
					@endforeach
				</div>
			</div>

			<!-- Modal Actions -->
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>