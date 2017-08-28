<template>
	<div class="avatar-container" v-cloak>
		<div class="avatar-image">
			<a :href="joinLink" :class="classes" :style="'background-image:url(' + url + ')'" v-if="type == 'link'"></a>
			<div :class="classes" :style="'background-image:url(' + url + ')'" v-if="type == 'image'"></div>
		</div>

		<div v-if="hasContent">
			<div class="avatar-label ml-2" v-if="size == 'lg'" v-cloak>
				<span class="h1" v-if="showName" v-text="positionName"></span>
				<a :href="joinLink" class="text-muted" v-if="showMetadata">Apply Now</a>
			</div>

			<div class="avatar-label ml-2" v-if="size == 'md'" v-cloak>
				<span class="h4" v-if="showName" v-text="positionName"></span>
				<a :href="joinLink" class="text-muted" v-if="showMetadata">Apply Now</a>
			</div>

			<div class="avatar-label ml-2" v-if="size == 'sm'">
				<span class="h5 mb-0" v-if="showName" v-text="positionName"></span>
			</div>

			<div class="avatar-label ml-2" v-if="size == 'xs'">
				<span class="h6 mb-0" v-if="showName" v-text="positionName"></span>
			</div>

			<div class="avatar-label ml-2" v-if="size == ''" v-cloak>
				<span class="h6 mb-1" v-if="showName" v-text="positionName"></span>
				<small class="text-muted" v-if="showMetadata"><a :href="joinLink" class="text-muted">Apply Now</a></small>
			</div>
		</div>
	</div>
</template>

<script>
	import md5 from 'md5';

	export default {
		props: {
			position: { type: Object, required: true },
			hasContent: { type: Boolean, default: true },
			showName: { type: Boolean, default: true },
			showMetadata: { type: Boolean, default: true },
			size: { type: String, default: '' },
			type: { type: String, default: 'link' }
		},

		computed: {
			classes () {
				return ['avatar', this.size];
			},

			joinLink () {
				return route('join');
			},

			positionName () {
				return this.position.name;
			},

			url () {
				return [
					window.Nova.system.baseUrl,
					'nova',
					'resources',
					'assets',
					'svg',
					'no-avatar.svg'
				].join('/');
			}
		},

		methods: {
			_m (key, variables = '') {
				return window._m(key, variables);
			}
		}
	};
</script>