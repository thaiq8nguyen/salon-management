<template>
	<div id="top-navigation-bar">
		<v-app-bar>
			<v-toolbar-title>Salon Management</v-toolbar-title>
			<v-spacer></v-spacer>

			<v-toolbar-items>
				<v-btn v-for="(item, key) in items" :key="key" :to="item.path" text>
					{{item.name}}
				</v-btn>
			</v-toolbar-items>

			<v-btn text @click="logout">Logout</v-btn>
		</v-app-bar>
	</div>
</template>

<script>
  export default {
	name: "TopNavigationBar",
	props: [],

	data () {
	  return {
		items: [
		  { name: "Technicians", path: "technicians" },
		  { name: "Sales", path: "sales" },
		  { name: "Payday", path: "payday" },
		],
	  }

	},
	methods: {

	  logout () {
		this.$store.dispatch("Authentications/logout")
	  },
	},

  }
</script>

<style>

</style>
