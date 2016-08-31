<div v-cloak>
	<mobile>
		<p><a href="{{ route('admin.users') }}" class="btn btn-default btn-lg btn-block">{!! icon('arrow-back') !!}<span>Back to Users</span></a></p>
		<p><a role="button" class="btn btn-default btn-lg btn-block" @click="resetPassword">{!! icon('unlock') !!}<span>Reset Password</span></a></p>
	</mobile>
	<desktop>
		<div class="btn-toolbar">
			<div class="btn-group">
				<a href="{{ route('admin.users') }}" class="btn btn-default">{!! icon('arrow-back') !!}<span>Back to Users</span></a>
			</div>
			<div class="btn-group">
				<a role="button" class="btn btn-default" @click="resetPassword">{!! icon('unlock') !!}<span>Reset Password</span></a>
			</div>
		</div>
	</desktop>
</div>