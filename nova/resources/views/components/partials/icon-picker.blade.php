<icon-picker></icon-picker>

<template id="icon-picker-template">
	<div class="nova-icon-picker">
		<div class="row">
			<div class="col-md-10">
				<select :name="config.inputName" :class="[ config.inputClasses ]" v-model="selectedIcon">
					<option value="">None</option>
					<option v-for="icon in icons" :value="icon.value">@{{ icon.key }}</option>
				</select>
			</div>
			<div class="col-md-2">
				<p class="form-control-static">@{{{ iconPreview }}}</p>
			</div>
		</div>
	</div>
</template>