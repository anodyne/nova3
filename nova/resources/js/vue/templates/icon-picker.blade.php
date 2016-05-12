<template id="icon-picker-template">
	<div class="nova-icon-picker">
		<select :name="config.inputName" :class="[ config.inputClasses ]" v-model="selectedIcon">
			<option v-for="icon in icons" :value="icon.value">@{{{ icon.preview }}} (@{{ icon.key }})</option>
		</select>
	</div>
</template>