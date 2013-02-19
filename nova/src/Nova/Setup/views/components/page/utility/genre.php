<p>From here, you can see the status of genres and either install or uninstall them as needed. The only limitation you have is that you cannot uninstall the current genre. If you want to uninstall the current genre, you'll need to change the genre code in your Nova config file <code>app/config/nova.php</code>, save and upload the file, then come back here to uninstall the genre.</p>

<p><a href="<?php echo Uri::create('setup/main/index');?>" class="btn-alt">&laquo; Back to Setup Center</a></p>

<?php if (isset($genres)): ?>
	<table class="table table-bordered table-striped">
		<thead>
			<tr>
				<th>Genre</th>
				<th class="span2 align-center">Status</th>
				<th class="span2 align-center">Action</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($genres as $key => $g): ?>
			<tr>
				<td class="align-middle">
					<?php echo $g['name'];?>
					<span class="muted"><?php echo strtoupper($key);?></span>
				</td>
				<td class="align-center align-middle">
					<span class="label<?php if ($g['installed']){ echo ' hide';}?>">Not Installed</span>
					<span class="label label-success<?php if ( ! $g['installed']){ echo ' hide';}?>">Installed</span>
				</td>
				<td class="align-center align-middle">
					<?php if ($key == \Config::get('nova.genre')): ?>
						<span class="label label-success">Active Genre</span>
					<?php else: ?>
						<button myGenre="<?php echo $key;?>" class="do-uninstall btn<?php if ( ! $g['installed']){ echo ' hide'; }?>">Uninstall</button>
					<?php endif;?>
					<button myGenre="<?php echo $key;?>" class="do-install btn<?php if ($g['installed']){ echo ' hide'; }?>">Install</button>
					<span class="loading hide"><?php echo Html::img($images['loading']['src'], $images['loading']['attr']);?></span>
				</td>
			</tr>
		<?php endforeach;?>
		
		<?php foreach ($additional as $key => $a): ?>
			<tr>
				<td class="align-middle"><?php echo $a['name'];?></td>
				<td class="align-center align-middle">
					<span class="label<?php if ($a['installed']){ echo ' hide';}?>">Not Installed</span>
					<span class="label label-success<?php if ( ! $a['installed']){ echo ' hide';}?>">Installed</span>
				</td>
				<td class="align-center">
					<?php if ($key != \Config::get('nova.genre')): ?>
						<button myGenre="<?php echo $key;?>" class="do-uninstall btn<?php if ( ! $a['installed']){ echo ' hide'; }?>">Uninstall</button>
					<?php endif;?>
					<button myGenre="<?php echo $key;?>" class="do-install btn<?php if ($a['installed']){ echo ' hide'; }?>">Install</button>
					<span class="loading hide"><?php echo Html::img($images['loading']['src'], $images['loading']['attr']);?></span>
				</td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
<?php endif;?>