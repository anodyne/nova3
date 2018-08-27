<template>
	<div class="page-header">
		<div class="page-header-content">
			<div class="page-header-pretitle" v-if="hasSlot('pretitle')">
				<slot name="pretitle"></slot>
			</div>

			<div class="page-header-title">
				<slot name="title">{{ pageTitle }}</slot>
			</div>
		</div>

		<div class="page-header-controls" v-if="hasSlot('controls')">
			<slot name="controls"></slot>
		</div>
	</div>
</template>

<script>
import slots from '../mixins/slots'

export default {
	mixins: [slots],

	computed: {
		pageTitle () {
			return 'TESTING'
			return Nova.page.name
		}
	}
}
</script>
