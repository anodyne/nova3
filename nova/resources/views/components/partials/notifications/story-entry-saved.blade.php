<figure>
	<span class="fa-stack fa-2x">
		<i class="fa fa-circle fa-stack-2x text-success"></i>
		<i class="fa fa-pencil fa-stack-1x fa-inverse"></i>
	</span>
</figure>

<div class="notification-content">
	<div class="meta">
		<p class="title">Story Entry Updated</p>

		<div class="date">
			{{ Date::now()->diffForHumans($notification->created_at) }}
		</div>
	</div>

	<div class="notification-body">
		Jane Doe updated your story entry <em>Pink Dolphins in the River</em>. Keep the story going by adding to the entry!
	</div>

	<!-- Notification Action -->
	<a href="notification.action_url" class="btn btn-primary">Continue the Story</a>
</div>