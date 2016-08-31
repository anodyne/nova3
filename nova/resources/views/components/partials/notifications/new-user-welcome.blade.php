<figure>
	<span class="fa-stack fa-2x">
		<i class="fa fa-circle fa-stack-2x"></i>
		<i class="fa fa-bolt fa-stack-1x fa-inverse"></i>
	</span>
</figure>

<div class="notification-content">
	<div class="meta">
		<p class="title">Welcome to the Game!</p>

		<div class="date">
			{{ Date::now()->diffForHumans($notification->created_at) }}
		</div>
	</div>

	<div class="notification-body">
		notification.parsed_body
	</div>
</div>