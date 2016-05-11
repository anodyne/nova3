<template id="access-picker-template">
	<div class="form-group">
		<div class="col-xs-12">
			<div class="radio-inline">
				<label><input type="radio" name="access_type_selection" v-model="accessTypeSelection" value="roles"> Restrict by Role(s)</label>
			</div>
			<div class="radio-inline">
				<label><input type="radio" name="access_type_selection" v-model="accessTypeSelection" value="permissions"> Restrict by Permission(s)</label>
			</div>
		</div>
	</div>

	<div class="nova-access-picker" v-show="accessTypeSelection != ''">
		<input type="text" :placeholder="config.inputPlaceholder" autocomplete="off" v-model="query" class="typeaheadInput" :class="[ config.inputClasses ]">

		<div class="selected-access-items">
			<span v-for="item in items">
				<span class="label label-default">
					@{{ item.type | capitalize }}: @{{ item.name }}
					<a class="remove" role="button" @click="removeSelectedItem(item)">&times;</a>
				</span>
			</span>
		</div>

		<input type="hidden" name="access" :value="accessItems">
	</div>
</template>