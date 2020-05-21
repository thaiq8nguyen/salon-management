<template>
	<div id="index">
		<v-app>
			<top-navigation-bar v-if="currentRouteName !== 'Login'"></top-navigation-bar>
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
    computed:{
      currentRouteName(){
			return this.$route.name;
      }

    },
	methods: {},
    created(){
      this.$store.commit("INITIALIZE_STATE")

    }

  }
</script>

<style>

</style>
