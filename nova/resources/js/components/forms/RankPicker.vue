<template>
	<nova-picker :items="ranksToPass" :selected="selected">
		<template slot="picker-selected-item" slot-scope="{ item: item }">
			<rank :item="item"></rank>
			<span class="meta" v-text="item.info.name"></span>
		</template>

		<template slot="picker-nothing-selected">
			<rank></rank>
		</template>

		<template slot="picker-field" slot-scope="{ item: item }">
			<input type="text" class="hidden" name="fieldName" v-model="item.id">
		</template>

		<template slot="picker-list-empty-message">
			No ranks found
		</template>

		<template slot="picker-list-item" slot-scope="{ item: item }">
			<rank :item="item"></rank>
			<span class="meta">{{ item.info.name }}</span>
		</template>
	</nova-picker>
</template>

<script>
import Rank from '../Rank.vue'
import NovaPicker from './Picker.vue'

export default {
	props: ['selected', 'ranks', 'character'],

	components: { Rank, NovaPicker },

	data () {
		return {
			ranksToPass: []
		}
	},

	created () {
		if (this.ranks != null) {
			this.ranksToPass = this.ranks
		} else {
			axios.get(route('api.ranks')).then(({data}) => {
				this.ranksToPass = data;
			})
		}
	}
}
</script>
