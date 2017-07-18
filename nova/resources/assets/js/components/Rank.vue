<template>
	<div class="rank-container">
		<div class="rank-overlay" :style="overlayStyle()"></div>
		<div class="rank-base" :style="baseStyle()"></div>
	</div>
</template>

<script>
	export default {
		props: {
			item: {
				type: Object
			},
			base: {
				type: String
			},
			overlay: {
				type: String
			}
		},

		methods: {
			baseStyle () {
				let image = (this.item) ? this.item.base : this.base
				let imagePath = [window.Nova.siteUrl, 'ranks', window.Nova.genre, 'duty', 'base', image].join('/')

				return 'background-image:url(' + imagePath + ')'
			},

			overlayStyle () {
				let image = (this.item) ? this.item.overlay : this.overlay
				let imagePath = [window.Nova.siteUrl, 'ranks', window.Nova.genre, 'duty', 'overlay', image].join('/')

				return 'background-image:url(' + imagePath + ')'
			}
		}
	}
</script>