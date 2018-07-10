<page-header>
	<template slot="pretitle">API</template>
	<template slot="title">Manage Tokens</template>
	<template slot="controls">
		<div class="flex items-center">
			<a href="#"
			   :class="navItemClass('clients')"
			   @click.prevent="switchSection('clients')"
			>
				Clients
			</a>

			<a href="#"
			   :class="navItemClass('authorized-clients')"
			   @click.prevent="switchSection('authorized-clients')"
			>
			   Authorized Clients
			</a>

			<a href="#"
			   :class="navItemClass('personal-access-tokens')"
			   @click.prevent="switchSection('personal-access-tokens')"
			>
			   Personal Access Tokens
			</a>
		</div>
	</template>
</page-header>

<div class="block" v-show="section == 'clients'">
	<passport-clients></passport-clients>
</div>

<div class="block" v-show="section == 'authorized-clients'">
	<passport-authorized-clients></passport-authorized-clients>
</div>

<div class="block" v-show="section == 'personal-access-tokens'">
	<passport-personal-access-tokens></passport-personal-access-tokens>
</div>
