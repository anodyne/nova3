<p>The database tables have been created and some basic data put into them. Now, just fill out the information below to update the system with it.</p>

{{ Form::open(['url' => 'setup/install/settings']) }}
	<fieldset>
		<legend>Sim Information</legend>
		
		<div class="row">
			<div class="col-lg-6">
				<div class="form-group{{ ($errors->has('sim_name')) ? ' has-error' : '' }}">
					<label>Sim Name</label>
					{{ Form::text('sim_name', Input::old('sim_name'), ['class' => 'form-control input-with-feedback']) }}
					{{ $errors->first('sim_name', '<p class="help-block">:message</p>') }}
				</div>
			</div>
		</div>
	</fieldset>
	
	<fieldset>
		<legend>Your Information</legend>
		
		<div class="row">
			<div class="col-lg-6">
				<div class="form-group{{ ($errors->has('name')) ? ' has-error' : '' }}">
					<label>Your Name</label>
					{{ Form::text('name', Input::old('name'), ['class' => 'form-control input-with-feedback']) }}
					{{ $errors->first('name', '<p class="help-block">:message</p>') }}
				</div>
			</div>

			<div class="col-lg-6">
				<div class="form-group{{ ($errors->has('email')) ? ' has-error' : '' }}">
					<label>Your Email Address</label>
					{{ Form::email('email', Input::old('email'), ['class' => 'form-control input-with-feedback']) }}
					{{ $errors->first('email', '<p class="help-block">:message</p>') }}
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-lg-6">
				<div class="form-group{{ ($errors->has('password')) ? ' has-error' : '' }}">
					<label>Your Password</label>
					{{ Form::password('password', ['class' => 'form-control input-with-feedback', 'id' => 'password']) }}
					{{ $errors->first('password', '<p class="help-block">:message</p>') }}
				</div>
			</div>
			
			<div class="col-lg-6">
				<div class="form-group{{ ($errors->has('password_confirm')) ? ' has-error' : '' }}">
					<label>Confirm Your Password</label>
					{{ Form::password('password_confirm', ['class' => 'form-control input-with-feedback']) }}
					{{ $errors->first('password_confirm', '<p class="help-block">:message</p>') }}
				</div>
			</div>
		</div>
	</fieldset>
	
	<fieldset>
		<legend>Character Information</legend>
		
		<div class="row">
			<div class="col-lg-6">
				<div class="form-group{{ ($errors->has('first_name')) ? ' has-error' : '' }}">
					<label>First Name</label>
					{{ Form::text('first_name', Input::old('first_name'), ['class' => 'form-control input-with-feedback']) }}
					{{ $errors->first('first_name', '<p class="help-block">:message</p>') }}
				</div>
			</div>
				
			<div class="col-lg-6">
				<div class="form-group">
					<label>Last Name</label>
					{{ Form::text('last_name', false, ['class' => 'form-control']) }}
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-lg-6">
				<div class="form-group{{ ($errors->has('position')) ? ' has-error' : '' }}">
					<label>Position</label>
					{{ Form::position('position', Input::old('position'), ['class' => 'form-control input-with-feedback', 'id' => 'positionDrop'], 'open.playing', true) }}
					{{ $errors->first('position', '<p class="help-block">:message</p>') }}
				</div>
			</div>
			<div class="col-lg-6">
				<div id="positionDescPanel" class="hide">
					<label>Position Description</label>
					<p id="positionDesc" class="text-muted font-small"></p>
				</div>
				<div id="positionLoader" class="hide">
					<br>
					{{ HTML::image('nova/views/design/images/loading.gif') }}
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-lg-6">
				<div class="form-group{{ ($errors->has('rank')) ? ' has-error' : '' }}">
					<label>Rank</label>
					{{ Form::rank('rank', Input::old('rank'), ['class' => 'form-control input-with-feedback', 'id' => 'rankDrop'], true) }}
					{{ $errors->first('rank', '<p class="help-block">:message</p>') }}
				</div>
			</div>
			<div class="col-lg-6">
				<label>&nbsp;</label>
				<div id="rankImg">{{ $defaultRank }}</div>
			</div>
		</div>
	</fieldset>