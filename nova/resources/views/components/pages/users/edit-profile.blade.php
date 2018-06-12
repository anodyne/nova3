<h1>{{ _m('users-profile-update') }}</h1>

<mobile-view>
	<p><a href="#" class="button is-block" data-toggle="modal" data-target="#changePassword">{{ _m('users-profile-password-change') }}</a></p>
	<p><a href="#" class="button is-danger is-block" data-toggle="modal" data-target="#deleteAccount">Delete My Account</a></p>
</mobile-view>
<desktop-view>
	<div class="button-toolbar">
		<a href="#" class="button" data-toggle="modal" data-target="#changePassword">{{ _m('users-profile-password-change') }}</a>
		<a href="#" class="button is-danger" data-toggle="modal" data-target="#deleteAccount">Delete My Account</a>
	</div>
</desktop-view>

{!! Form::model($user, ['route' => ['profile.update', $user], 'method' => 'patch']) !!}
	<div class="row">
		<div class="md:col-4">
			<text-input label="{{ _m('name') }}" name="name" value="{{ $user->name }}" error="{{ $errors->first('name') }}"></text-input>

			{{-- <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
				<label>{{ _m('name') }}</label>
				{!! Form::text('name', null, ['class' => 'form-control'.($errors->has('name') ? ' form-control-danger' : '')]) !!}
				{!! $errors->first('name', '<p class="form-control-feedback">:message</p>') !!}
			</div> --}}
		</div>
	</div>

	<div class="row">
		<div class="md:col-4">
			<text-input label="{{ _m('email-address') }}" name="email" type="email" value="{{ $user->email }}" error="{{ $errors->first('email') }}"></text-input>
			{{-- <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
				<label>{{ _m('email-address') }}</label>
				{!! Form::email('email', null, ['class' => 'form-control'.($errors->has('email') ? ' form-control-danger' : '')]) !!}
				{!! $errors->first('email', '<p class="form-control-feedback">:message</p>') !!}
			</div> --}}
		</div>
	</div>

	<div class="row">
		<div class="md:col-4">
			<text-input label="{{ _m('users-gender') }}" name="gender" value="{{ $user->gender }}" help="{{ _m('users-gender-explain') }}"></text-input>

			{{-- <div class="form-group">
				<label>{{ _m('users-gender') }}</label>
				<div>
					{!! Form::select('gender', $genders, null, ['class' => 'custom-select']) !!}
				</div>
				<small class="form-text text-muted">{{ _m('users-gender-explain') }}</small>
			</div> --}}
		</div>
	</div>

	<fieldset>
		<legend>{{ _m('image', [1]) }}</legend>
		<media-manager :item="{{ $user }}" type="user" :allow-multiple="false"></media-manager>
	</fieldset>

	<div class="form-group">
		<button type="submit" class="btn btn-primary mr-2">{{ _m('users-profile-update') }}</button>
		<a href="{{ route('profile.show', $user) }}" class="btn btn-link">{{ _m('cancel') }}</a>
	</div>
{!! Form::close() !!}

<div id="changePassword" class="modal fade">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">{{ _m('users-profile-password-change') }}</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="{{ _m('close') }}">
					<span aria-hidden="true">{!! icon('close') !!}</span>
				</button>
			</div>

			{!! Form::open(['route' => ['profile.password', $_user], 'method' => 'patch']) !!}
				<div class="modal-body">
					<div class="form-group">
						<label>{{ _m('password-current') }}</label>
						{!! Form::password('password_current', ['class' => 'form-control']) !!}
					</div>

					<div class="form-group">
						<label>{{ _m('password-new') }}</label>
						{!! Form::password('password_new', ['class' => 'form-control']) !!}
					</div>

					<div class="form-group">
						<label>{{ _m('password-new-confirm') }}</label>
						{!! Form::password('password_new_confirmation', ['class' => 'form-control']) !!}
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">{{ _m('Save') }}</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">{{ _m('close') }}</button>
				</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>
