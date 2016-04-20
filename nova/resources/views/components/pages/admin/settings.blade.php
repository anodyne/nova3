<div class="page-header">
	<h1>Settings</h1>
</div>

<div class="row">
	<div class="col-md-6 col-md-offset-3">
		<div class="form-group">
			<input type="text" class="form-control input-lg" placeholder="Search for settings" v-model="search">
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-3">
		<div class="list-group">
			<a href="#" class="list-group-item" @click.prevent="switchOption('optionBasic')">Basic</a>
			<a href="#" class="list-group-item" @click.prevent="switchOption('optionEmail')">Email</a>
			<a href="#" class="list-group-item" @click.prevent="switchOption('optionAppearance')">Appearance</a>
		</div>
	</div>
	<div class="col-md-9">
		<div v-show="optionBasic">
			<h2>Basic Settings</h2>
		</div>

		<div v-show="optionEmail">
			<h2>Email Settings</h2>
		</div>

		<div v-show="optionAppearance">
			<h2>Appearance Settings</h2>
		</div>
	</div>
</div>