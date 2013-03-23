<p>The database tables have been created and some basic data put into them. Now, just fill out the information below to update the system with it.</p>

{{ Form::open() }}
	<fieldset>
		<legend>Sim Information</legend>
		
		<div class="control-group">
			<label class="control-label">Sim Name</label>
			<div class="controls">
				{{ Form::text('sim_name', false, array('class' => 'span4')) }}
			</div>
		</div>
	</fieldset>
	
	<fieldset>
		<legend>Your Information</legend>
		
		<div class="row">
			<div class="span6">
				<div class="control-group">
					<label class="control-label">Your Name</label>
					<div class="controls">
						{{ Form::text('name', false, array('class' => 'span5')) }}
					</div>
				</div>
			</div>

			<div class="span6">
				<div class="control-group">
					<label class="control-label">Your Email Address</label>
					<div class="controls">
						{{ Form::email('email', false, array('class' => 'span5')) }}
					</div>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="span6">
				<div class="control-group">
					<label class="control-label">Your Password</label>
					<div class="controls">
						{{ Form::password('password', array('class' => 'span5', 'id' => 'password')) }}
					</div>
				</div>
			</div>
			
			<div class="span6">
				<div class="control-group">
					<label class="control-label">Confirm Your Password</label>
					<div class="controls">
						{{ Form::password('password_confirm', array('class' => 'span5')) }}
					</div>
				</div>
			</div>
		</div>
	</fieldset>
	
	<fieldset>
		<legend>Character Information</legend>
		
		<div class="row">
			<div class="span6">
				<div class="control-group">
					<label class="control-label">First Name</label>
					<div class="controls">
						{{ Form::text('first_name', false, array('class' => 'span5')) }}
					</div>
				</div>
			</div>
				
			<div class="span6">
				<div class="control-group">
					<label class="control-label">Last Name</label>
					<div class="controls">
						{{ Form::text('last_name', false, array('class' => 'span5')) }}
					</div>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="span6">
				<div class="control-group">
					<label class="control-label">Position</label>
					<div class="controls">
						{{ Form::position('position', null, array('class' => 'span5'), 'open.playing', true) }}
					</div>
				</div>
			</div>
			<div class="span6 hide" id="positionDescPanel">
				<label class="control-label">Position Description</label>
				<p id="positionDesc" class="muted font-small"></p>
			</div>
		</div>
		
		<div class="row">
			<div class="span6">
				<div class="control-group">
					<label class="control-label">Rank</label>
					<div class="controls">
						{{ Form::rank('rank', null, array('class' => 'span5'), true) }}
					</div>
				</div>
			</div>
			<div class="span6">
				<label class="control-label">&nbsp;</label>
				<div id="rankImg">{{ $defaultRank }}</div>
			</div>
		</div>
	</fieldset>