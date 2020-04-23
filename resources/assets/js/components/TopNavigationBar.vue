<template>
	<div id="top-navigation-bar">
		<v-app-bar class="primary" >
			<v-toolbar-title>Salon Management</v-toolbar-title>
			<v-spacer></v-spacer>

<!--			<v-list>-->
<!--				<v-list-item v-for="(item, key) in items" :key="key" @click="handleMenuClick">-->
<!--					<v-list-item-title>{{item.name}}</v-list-item-title>-->
<!--				</v-list-item>-->
<!--			</v-list>-->
			<v-btn text @click="logout">Logout</v-btn>
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
      addTechnician(){

      },
      logout(){
		this.$store.dispatch("Authentications/logout")
      }
	},

  }
</script>

<style>

</style>
