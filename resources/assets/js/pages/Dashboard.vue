<template>
	<div id="dashboard">
		<top-navigation-bar></top-navigation-bar>
		<v-content>
			<v-card></v-card>
		</v-content>
	</div>
</template>

<script>
  import TopNavigationBar from "Components/TopNavigationBar"

  export default {
    name: "Dashboard",
    components: { TopNavigationBar },
	props: [],

	data () {
	  return {}

	},
	methods: {},

  }
</script>

<style>

</style>
