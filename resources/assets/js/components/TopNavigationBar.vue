<template>
	<div id="top-navigation-bar">
		<v-app-bar class="primary" >
			<v-toolbar-title>Salon Management</v-toolbar-title>
			<v-spacer></v-spacer>
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
	      {name: "Logout"}
	    ]
	  }

	},
	methods: {
      logout(){
		this.$store.dispatch("Authentications/logout")
      }
	},

  }
</script>

<style>

</style>
