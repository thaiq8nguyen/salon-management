<template>
	<div>
		<v-toolbar>
			<v-btn icon :href="main">
				<v-icon>home</v-icon>
			</v-btn>
		</v-toolbar>
	</div>
</template>

<script>
    export default {
        props: [],

        data() {
            return {
                main:'/home'

            }


        },
        methods: {}


    }
</script>

<style>

</style>