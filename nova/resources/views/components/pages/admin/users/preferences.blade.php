<div class="row" v-cloak>
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="list-group">
				<a href="#" class="list-group-item" @click.prevent="switchOption('optionGeneral')">General</a>
				<a href="#" class="list-group-item" @click.prevent="switchOption('optionAppearance')">Appearance</a>
				<a href="#" class="list-group-item" @click.prevent="switchOption('optionNotifications')">Notifications</a>
			</div>
		</div>
	</div>
	<div class="col-md-9">
		<form class="form-horizontal">
			<div v-show="optionGeneral">
				<h2>General</h2>
			</div>

			<div v-show="optionAppearance">
				<h2>Appearance</h2>

				<div class="form-group">
					<label class="control-label col-md-2">Theme</label>
					<div class="col-md-6">
						{!! Form::select('theme', [], null, ['class' => 'form-control input-lg']) !!}
						{{ d($_user->preference('theme')) }}
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-2">Variant</label>
					<div class="col-md-6">
						{!! Form::select('theme_variant', [], null, ['class' => 'form-control input-lg']) !!}
						{{ d($_user->preference('theme_variant')) }}
					</div>
				</div>
			</div>

			<div v-show="optionNotifications">
				<h2>Notifications</h2>

				<fieldset>
					<legend>Site Notifications</legend>

					<div class="form-group">
						<label class="control-label col-md-4">New Story Entry</label>
						<div class="col-md-6"></div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-4">Update to Story Entry</label>
						<div class="col-md-6"></div>
					</div>
				</fieldset>

				<fieldset>
					<legend>Email Notifications</legend>
				</fieldset>
			</div>
		</form>
	</div>
</div>