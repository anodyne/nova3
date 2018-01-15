<h1>Extensions</h1>

<div class="card border-info">
	<h4 class="card-header border-info bg-info text-white">Extensions to be Installed</h4>
	<div class="card-body text-info">
		Show a list of any extensions that are in the extensions folder, but not in the database. Provide a link to install them if they have a QuickInstall file. If they don't have a QuickInstall file, we'll bounce them over to the create page and possibly set some flash data to help with creating the extension manually.
	</div>
</div>

@if ($extensions->count() > 0)
@else
	<div class="alert alert-info">
		There are no extensions installed. You can find extensions at AnodyneXtras.
	</div>
@endif