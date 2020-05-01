<template>
	<div id="index">
		<v-app>
			<top-navigation-bar></top-navigation-bar>
			<router-view></router-view>
		</v-app>

	</div>
</template>

<script>
	import TopNavigationBar from "Components/TopNavigationBar"
  export default {
    name: "Main",
    components: {TopNavigationBar},
	props: [],

	data () {
	  return {}

	},
	methods: {},
    created(){
      this.$store.commit("INITIALIZE_STATE")
    }

  }
</script>

<style>

</style>
