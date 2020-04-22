<template>
	<div id="index">
		<router-view></router-view>
	</div>
</template>

<script>
  export default {
    name: "Main",
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
