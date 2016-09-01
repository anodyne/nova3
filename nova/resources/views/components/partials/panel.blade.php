@if (user())
	<div class="modal docked docked-right" id="notification-panel">
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
						@if (user()->unreadNotifications->count() > 0)
							@foreach (user()->unreadNotifications as $notification)
								{!! partial('notification', compact('notification')) !!}
							@endforeach
						@else
							{!! alert('warning', "You don't have any unread notifications.") !!}
						@endif
					</div>
				</div>

				<!-- Modal Actions -->
				<div class="modal-footer">
					@if (user()->unreadNotifications->count() > 0)
						<button type="button" class="btn btn-default">{!! icon('check') !!} Mark All Read</button>
					@endif

					<button type="button" class="btn btn-default" data-dismiss="modal">{!! icon('close') !!} Close</button>
				</div>
			</div>
		</div>
	</div>
@endif