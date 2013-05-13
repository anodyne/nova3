<p>The database tables have been created and some basic data put into them. Now, just fill out the information below to update the system with it.</p>

{{ Form::open() }}
	<fieldset>
		<legend>Sim Information</legend>
		
		<div class="row">
			<div class="col col-lg-6">
				<div class="control-group{{ ($errors->has('sim_name')) ? ' has-error' : '' }}">
					<label class="control-label">Sim Name</label>
					<div class="controls">
						{{ Form::text('sim_name', Input::old('sim_name'), array('class' => 'input-with-feedback')) }}
						{{ $errors->first('sim_name', '<p class="help-block">:message</p>') }}
					</div>
				</div>
			</div>
		</div>
	</fieldset>
	
	<fieldset>
		<legend>Your Information</legend>
		
		<div class="row">
			<div class="col col-lg-6">
				<div class="control-group{{ ($errors->has('name')) ? ' has-error' : '' }}">
					<label class="control-label">Your Name</label>
					<div class="controls">
						{{ Form::text('name', Input::old('name'), array('class' => 'input-with-feedback')) }}
						{{ $errors->first('name', '<p class="help-block">:message</p>') }}
					</div>
				</div>
			</div>

			<div class="col col-lg-6">
				<div class="control-group{{ ($errors->has('email')) ? ' has-error' : '' }}">
					<label class="control-label">Your Email Address</label>
					<div class="controls">
						{{ Form::email('email', Input::old('email'), array('class' => 'input-with-feedback')) }}
						{{ $errors->first('email', '<p class="help-block">:message</p>') }}
					</div>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col col-lg-6">
				<div class="control-group{{ ($errors->has('password')) ? ' has-error' : '' }}">
					<label class="control-label">Your Password</label>
					<div class="controls">
						{{ Form::password('password', array('class' => 'input-with-feedback', 'id' => 'password')) }}
						{{ $errors->first('password', '<p class="help-block">:message</p>') }}
					</div>
				</div>
			</div>
			
			<div class="col col-lg-6">
				<div class="control-group{{ ($errors->has('password_confirm')) ? ' has-error' : '' }}">
					<label class="control-label">Confirm Your Password</label>
					<div class="controls">
						{{ Form::password('password_confirm', array('class' => 'input-with-feedback')) }}
						{{ $errors->first('password_confirm', '<p class="help-block">:message</p>') }}
					</div>
				</div>
			</div>
		</div>
	</fieldset>
	
	<fieldset>
		<legend>Character Information</legend>
		
		<div class="row">
			<div class="col col-lg-6">
				<div class="control-group{{ ($errors->has('first_name')) ? ' has-error' : '' }}">
					<label class="control-label">First Name</label>
					<div class="controls">
						{{ Form::text('first_name', Input::old('first_name'), array('class' => 'input-with-feedback')) }}
						{{ $errors->first('first_name', '<p class="help-block">:message</p>') }}
					</div>
				</div>
			</div>
				
			<div class="col col-lg-6">
				<div class="control-group">
					<label class="control-label">Last Name</label>
					<div class="controls">
						{{ Form::text('last_name', false) }}
					</div>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col col-lg-6">
				<div class="control-group{{ ($errors->has('position')) ? ' has-error' : '' }}">
					<label class="control-label">Position</label>
					<div class="controls">
						{{ Form::position('position', Input::old('position'), array('class' => 'input-with-feedback', 'id' => 'positionDrop'), 'open.playing', true) }}
						{{ $errors->first('position', '<p class="help-block">:message</p>') }}
					</div>
				</div>
			</div>
			<div class="col col-lg-6 hide" id="positionDescPanel">
				<label class="control-label">Position Description</label>
				<p id="positionDesc" class="text-muted font-small"></p>
			</div>
		</div>
		
		<div class="row">
			<div class="col col-lg-6">
				<div class="control-group{{ ($errors->has('rank')) ? ' has-error' : '' }}">
					<label class="control-label">Rank</label>
					<div class="controls">
						{{ Form::rank('rank', Input::old('rank'), array('class' => 'input-with-feedback', 'id' => 'rankDrop'), true) }}
						{{ $errors->first('rank', '<p class="help-block">:message</p>') }}
					</div>
				</div>
			</div>
			<div class="col col-lg-6">
				<label class="control-label">&nbsp;</label>
				<div id="rankImg">{{ $defaultRank }}</div>
			</div>
		</div>
	</fieldset>