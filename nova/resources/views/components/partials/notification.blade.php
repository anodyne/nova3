<div class="notification">
	@if (Str::contains($notification->type, 'NewUserWelcome'))
		{!! partial('notifications/new-user-welcome', compact('notification')) !!}
	@endif

	@if (Str::contains($notification->type, 'UserUpdated'))
		{!! partial('notifications/account-updated', compact('notification')) !!}
	@endif

	@if (Str::contains($notification->type, 'StoryEntrySaved'))
		{!! partial('notifications/story-entry-saved', compact('notification')) !!}
	@endif
</div>