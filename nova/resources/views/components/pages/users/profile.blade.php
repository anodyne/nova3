<div class="mb-4">
	<avatar :item="{{ $user }}"
			:show-metadata="false"
			:show-status="false"
			size="lg"
			type="image">
	</avatar>
</div>

@can('updateProfile', $user)
	<mobile-view>
		<p><a href="{{ route('profile.edit') }}" class="button is-block">{{ _m('users-profile-update') }}</a></p>
	</mobile-view>

	<desktop-view>
		<div class="button-toolbar">
			<a href="{{ route('profile.edit') }}" class="button">{{ _m('users-profile-update') }}</a>
		</div>
	</desktop-view>
@endcan

<ul>
	<li>Show last 10 story entries</li>
	<li>Show last sign in</li>
	<li>Show some stats</li>
	<li>Show social media links</li>
	<li>Show all characters tied to the account</li>
</ul>
