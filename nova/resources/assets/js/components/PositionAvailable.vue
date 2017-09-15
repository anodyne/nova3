<template>
	<div :class="containerClasses" v-cloak>
		<div class="avatar-image">
			<a :class="imageClasses"
			   :href="joinLink"
			   :style="'background-image:url(' + imageUrl + ')'"
			   v-if="type == 'link'">
			</a>

			<div :class="imageClasses"
				 :style="'background-image:url(' + imageUrl + ')'"
				 v-if="type == 'image'">
			</div>
		</div>

		<div class="avatar-label" v-if="showContent">
			<span class="avatar-title" v-if="showName" v-text="positionName"></span>
			<span class="avatar-meta" v-if="showMetadata">
				<slot><a :href="joinLink" class="text-muted">Apply Now</a></slot>
			</span>
		</div>
	</div>
</template>

<script>
	import md5 from 'md5';

	export default {
		props: {
			layout: { type: String, default: 'spread' },
			position: { type: Object, required: true },
			showContent: { type: Boolean, default: true },
			showName: { type: Boolean, default: true },
			showMetadata: { type: Boolean, default: true },
			size: { type: String, default: '' },
			type: { type: String, default: 'link' }
		},

		computed: {
			containerClasses () {
				return [
					'avatar-container',
					'avatar-' + this.layout,
					'avatar-' + this.size
				];
			},

			imageClasses () {
				return ['avatar', this.size];
			},

			imageUrl () {
				return [
					window.Nova.system.baseUrl,
					'nova',
					'resources',
					'assets',
					'svg',
					'no-avatar.svg'
				].join('/');
			},

			joinLink () {
				return route('join');
			},

			positionName () {
				return this.position.name;
			}
		},

		methods: {
			lang (key, variables = '') {
				return window.lang(key, variables);
			}
		}
	};
</script>