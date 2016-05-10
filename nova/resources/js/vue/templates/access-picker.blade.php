<template id="access-picker-template">
	<div class="nova-access-picker">
		<input type="text" name="typeahead" placeholder="Start typing to search for roles and/or permissions" autocomplete="off" v-model="query" class="form-control input-lg">

		<div class="selected-access-items">
			<span v-for="item in items">
				<span class="label label-default">
					@{{ item.type | capitalize }}: @{{ item.name }}
					<a class="remove" role="button" @click="removeSelectedItem(item)">&times;</a>
				</span>
			</span>
		</div>

		<input type="hidden" name="access" :value="items">
	</div>
</template>