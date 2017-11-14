@extends('layouts.setup')

@section('title', 'Configure Nova 2')

@section('header', 'Configure Nova 2')

@section('content')
	<h1>Configure Nova 2</h1>
	<h3>Tell us a little bit about your Nova 2 site</h3>

	<div v-cloak>
		{!! Form::open(['route' => "setup.{$_setupType}.config.nova2.check"]) !!}
			<div class="row">
				<div class="col-lg-10 mx-auto">
					<fieldset>
						<legend>Nova 2 Genre</legend>

						<div class="row">
							<div class="col-md-5">
								<select name="nova2_genre" class="custom-select">
									<option selected>Select your Nova 2 genre</option>
									<option value="bl5">Babylon 5</option>
									<option value="bln">Blank</option>
									<option value="bsg">Battlestar Galactica</option>
									<option value="dnd">Dungeons and Dragons</option>
									<option value="dsv">seaQuest DSV</option>
									<optgroup label="Star Trek">
										<option value="baj">Bajorans</option>
										<option value="crd">Cardassians</option>
										<option value="ds9">Deep Space Nine</option>
										<option value="ent">Enterprise</option>
										<option value="kli">Klingons</option>
										<option value="mov">Movie era</option>
										<option value="rom">Romulans</option>
										<option value="sto">Star Trek Online</option>
										<option value="tos">The Original Series</option>
									</optgroup>
									<option value="sg1">Stargate SG-1</option>
									<option value="sga">Stargate: Atlantis</option>
								</select>
							</div>
						</div>
					</fieldset>

					<fieldset>
						<legend>Departments &amp; Positions</legend>
						<p>You can choose to use your existing department and position data instead of the default {{ config('nova.app.name') }} department and position data. This provides for a cleaner migration and less work after the migration to verify and correct any character position assignment issues. You can disable this if you want to use {{ config('nova.app.name') }}'s default data.</p>

						<label class="custom-control custom-checkbox">
							<input type="checkbox" name="nova2_use_data" class="custom-control-input" checked>
							<span class="custom-control-indicator"></span>
							<span class="custom-control-description">Use my Nova 2 departments &amp; positions</span>
						</label>
					</fieldset>
				</div>
			</div>

			<div class="form-group row">
				<div class="col-lg-10 mx-auto">
					<h2>Nova 2 Database Connection</h2>
					<p>New to {{ config('nova.app.name') }} is the ability to migrate from one database to another. You no longer need to be running the Nova 2 database from the same database that you'll be running {{ config('nova.app.name') }} from. Enter your Nova 2 database connection information below so we can connect to your Nova 2 site the migrate your data.</p>
				</div>
			</div>

			<div class="row">
				<div class="col-md-9 col-lg-8 offset-lg-1">
					<div class="form-group">
						<label>Host</label>
						<div class="control-wrapper">
							{!! Form::text('nova2_db_host', 'localhost', ['class' => 'form-control form-control-lg']) !!}
							<small class="form-text text-muted">For most web hosts, <code>localhost</code> will be correct. If you aren't sure, refer to the information you received from your web host or contact them directly.</small>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6 col-lg-5 offset-lg-1">
					<div class="form-group">
						<label>Database Name</label>
						<div class="control-wrapper">
							{!! Form::text('nova2_db_name', false, ['class' => 'form-control form-control-lg']) !!}
						</div>
					</div>
				</div>

				<div class="col-md-6 col-lg-5">
					<div class="form-group">
						<label>Table Prefix</label>
						<div class="control-wrapper">
							{!! Form::text('nova2_db_prefix', 'nova_', ['class' => 'form-control form-control-lg']) !!}
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6 col-lg-5 offset-lg-1">
					<div class="form-group">
						<label>Username</label>
						<div class="control-wrapper">
							{!! Form::text('nova2_db_user', false, ['class' => 'form-control form-control-lg']) !!}
						</div>
					</div>
				</div>

				<div class="col-md-6 col-lg-5">
					<div class="form-group">
						<label>Password</label>
						<div class="control-wrapper">
							{!! Form::password('nova2_db_password', ['class' => 'form-control form-control-lg']) !!}
						</div>
					</div>
				</div>
			</div>

			<div class="form-group row">
				<div class="col-lg-10 offset-lg-1">
					{!! Form::button('Configure Nova 2', ['class' => 'btn btn-outline-primary', 'type' => 'submit']) !!}
				</div>
			</div>
		{!! Form::close() !!}
	</div>
@endsection

@section('controls')
	@if (file_exists(app('path.config').'/mail.php'))
		<a href="{{ route('setup.'.$_setupType) }}" class="btn btn-primary btn-lg">Next: Database Connection</a>
	@else
		<a class="btn btn-primary btn-lg disabled">Next: Database Connection</a>
	@endif

	<a href="{{ route('setup.'.$_setupType) }}" class="btn btn-link-secondary btn-lg">Cancel</a>
@endsection

@section('js')
	<script>
		vue = {
			data: {
				'driver': false
			},

			computed: {
				driverClassName () {
					if (this.driver == 'smtp') {
						return 'form-group has-success';
					}

					if (this.driver == 'mail') {
						return 'form-group has-warning';
					}

					if (this.driver == 'log') {
						return 'form-group has-danger';
					}

					return 'form-group';
				}
			}
		};
	</script>
@endsection