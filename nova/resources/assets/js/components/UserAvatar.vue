<template>
	<div class="avatar-container" v-cloak>
		<a :href="profileLink" :class="classes" :style="'background-image:url(' + url + ')'" v-if="type == 'link'"></a>
		<div :class="classes" :style="'background-image:url(' + url + ')'" v-if="type != 'link'"></div>

		<div v-if="hasLabel">
			<div class="avatar-label ml-2" v-if="size == 'lg'" v-cloak>
				<span class="h1">{{ this.user.displayName }}</span>
				<span class="text-muted">
					<slot name="beforeLabel"></slot>
					<span class="px-1" v-if="hasBeforeLabel">&bull;</span>
					<span class="px-1" v-if="hasAfterLabel">&bull;</span>
					<slot name="afterLabel"></slot>
				</span>
			</div>

			<div class="avatar-label ml-2" v-if="size == 'md'" v-cloak>
				<span class="h4">{{ this.user.displayName }}</span>
				<span class="text-muted">
					<slot name="beforeLabel"></slot>
					<span class="px-1" v-if="hasBeforeLabel">&bull;</span>
					<span class="px-1" v-if="hasAfterLabel">&bull;</span>
					<slot name="afterLabel"></slot>
				</span>
			</div>

			<div class="avatar-label ml-2" v-if="size == 'sm'">
				<span class="h5 mb-0">{{ this.user.displayName }}</span>
			</div>

			<div class="avatar-label ml-2" v-if="size == 'xs'">
				<span class="h6 mb-0">{{ this.user.displayName }}</span>
			</div>

			<div class="avatar-label ml-2" v-if="size == ''" v-cloak>
				<span class="h6 mb-1">{{ this.user.displayName }}</span>
				<small class="text-muted">
					<slot name="beforeLabel"></slot>
					<span class="px-1" v-if="hasBeforeLabel">&bull;</span>
					<span class="px-1" v-if="hasAfterLabel">&bull;</span>
					<slot name="afterLabel"></slot>
				</small>
			</div>
		</div>
	</div>
</template>

<script>
	import md5 from 'md5';
	import humanize from 'humanize-number';

	export default {
		props: {
			hasLabel: { type: Boolean, default: false },
			size: { type: String, default: '' },
			type: { type: String, default: 'link' },
			user: { type: Object, required: true }
		},

		computed: {
			classes () {
				return ['avatar', this.size];
			},

			hasAfterLabel () {
				return this.$slots.afterLabel != null;
			},

			hasBeforeLabel () {
				return this.$slots.beforeLabel != null;
			},

			profileLink () {
				return route('profile.show', {user:this.user.id});
			},

			url () {
				return this.user.avatarImage;
			}
		}
	};
</script>
