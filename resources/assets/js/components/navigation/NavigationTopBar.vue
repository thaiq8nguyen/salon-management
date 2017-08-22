<template>
	<div>
		<v-toolbar>
			<v-btn icon :href="home">
				<v-icon>home</v-icon>
			</v-btn>
			<v-spacer></v-spacer>
			<v-btn icon :href="logout">
				<v-icon>exit_to_app</v-icon>
			</v-btn>
		</v-toolbar>
	</div>
</template>

<script>
    export default {
        props: [],

        data() {
            return {
                home:'/home',
	            logout:'/logout',

            }


        },
        methods: {}


    }
</script>

<style>

</style>