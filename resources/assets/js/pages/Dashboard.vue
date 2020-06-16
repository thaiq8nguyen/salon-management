<template>
	<div id="dashboard-page">



		<v-card></v-card>


	</div>
</template>

<script>


  export default {
    name: "Dashboard",
    components: {  },
	props: [],

	data () {
	  return {}

	},
    created(){
        this.$store.dispatch("init");
    },

	methods: {},

  }
</script>

<style>

</style>
