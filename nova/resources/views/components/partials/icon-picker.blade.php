<icon-picker selected="{{ $icon }}"></icon-picker>

<template id="icon-picker-template">
	<div class="nova-icon-picker">
		<div class="row">
			<div class="col-md-10">
				<select name="icon" class="form-control input-lg" v-model="selectedIcon">
					<option value="">None</option>
					<option v-for="icon in icons" :value="icon.key">@{{ icon.key }}</option>
				</select>
			</div>
			<div class="col-md-2">
				<p class="form-control-static">@{{{ iconPreview }}}</p>
			</div>
		</div>
	</div>
</template>