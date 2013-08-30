<p>From here, you can see the status of genres and install or uninstall them as needed. The only limitation you have is that you can't uninstall the current active genre. If you want to uninstall the current active genre, first install a new genre, change the genre code in your Nova config file <code>app/config/nova.php</code>, save and upload the file, then come back here to uninstall the genre.</p>

<hr>

@if (isset($genres))
	<div class="row">
	@foreach ($genres as $key => $genre)
		<div class="col col-lg-4">
			<div class="thumbnail">
				<h4>{{ $genre['name'] }} <small>{{ strtoupper($key) }}</small></h4>

				<p class="pull-right">
					<?php $installHide = ($genre['installed']) ? 'hide' : '';?>
					<?php $uninstallHide = ( ! $genre['installed']) ? 'hide' : '';?>
					<?php $uninstallDisable = ($key == Config::get('nova.genre')) ? true : false;?>

					<button data-genre="{{ $key }}" class="js-do-install btn btn-primary btn-mini {{ $installHide }}">Install</button>
					<button data-genre="{{ $key }}" class="js-do-uninstall btn btn-danger btn-mini {{ $uninstallHide }}"<?php if ($uninstallDisable){ echo ' disabled="disabled"'; }?>>Uninstall</button>
				</p>

				<p class="pull-right hide" style="padding-bottom:2px;">{{ $loading }}</p>

				<p>
					<?php $activeHide = ($key != Config::get('nova.genre')) ? 'hide' : '';?>
					<?php $installHide = ( ! $genre['installed']) ? 'hide' : '';?>
					<?php $uninstallHide = ($genre['installed']) ? 'hide' : '';?>

					<span class="label label-info {{ $activeHide }}">Active Genre</span>
					<span class="label label-success {{ $installHide }}">Installed</span>
					<span class="label label-default {{ $uninstallHide }}">Not Installed</span>
				</p>

				<div style="clear:both"></div>
			</div>
		</div>
	@endforeach
	</div>

	@if (is_array($additional))
		<h3>Additional Genres</h3>

		<div class="row">
		@foreach ($additional as $key => $genre)
			<div class="col col-lg-4">
				<div class="thumbnail">
					<h4>{{ $genre['name'] }}</h4>

					<p class="pull-right">
						<?php $installHide = ($genre['installed']) ? 'hide' : '';?>
						<?php $uninstallHide = ( ! $genre['installed']) ? 'hide' : '';?>
						<?php $uninstallDisable = ($key == Config::get('nova.genre')) ? true : false;?>

						<button data-genre="{{ $key }}" class="js-do-install btn btn-primary btn-mini {{ $installHide }}">Install</button>
						<button data-genre="{{ $key }}" class="js-do-uninstall btn btn-danger btn-mini {{ $uninstallHide }}"<?php if ($uninstallDisable){ echo ' disabled="disabled"'; }?>>Uninstall</button>
					</p>

					<p class="pull-right hide" style="padding-bottom:2px;">{{ $loading }}</p>

					<p>
						<?php $activeHide = ($key != Config::get('nova.genre')) ? 'hide' : '';?>
						<?php $installHide = ( ! $genre['installed']) ? 'hide' : '';?>
						<?php $uninstallHide = ($genre['installed']) ? 'hide' : '';?>

						<span class="label label-info {{ $activeHide }}">Active Genre</span>
						<span class="label label-success {{ $installHide }}">Installed</span>
						<span class="label label-default {{ $uninstallHide }}">Not Installed</span>
					</p>

					<div style="clear:both"></div>
				</div>
			</div>
		@endforeach
		</div>
	@endif
@endif