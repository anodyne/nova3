<template>
	<div class="row">
		<div class="col-3" v-for="layout in layouts[section]">
			<div class="flex flex-col text-center mb-4">
				<img :src="layout.image" alt="" class="block mb-2">
				<div class="font-medium text-sm">{{ layout.name }}</div>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	props: {
		section: { type: String, required: true }
	},

	data () {
		return {
			layouts: {
				app: [
					{ name: 'Top Nav', image: '/nova/resources/assets/svg/layout-app-topnav.svg', component: '' },
					{ name: 'Sidebar', image: '/nova/resources/assets/svg/layout-app-sidebar.svg', component: '' },
					{ name: 'Sidebar w/ Top Nav', image: '/nova/resources/assets/svg/layout-app-sidebar-topnav.svg', component: ''  },
					{ name: 'Hero', image: '/nova/resources/assets/svg/layout-app-hero.svg', component: ''  },
				],
				auth: [
					{ name: 'Basic', image: '/nova/resources/assets/svg/layout-auth-basic.svg', component: '' },
					{ name: 'Cover Image', image: '/nova/resources/assets/svg/layout-auth-cover.svg', component: '' },
					{ name: 'Content Block', image: '/nova/resources/assets/svg/layout-auth-content.svg', component: ''  },
				],
			}
		}
	}
}
</script>
