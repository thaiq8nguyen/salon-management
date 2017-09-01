<template>
	<div>
		<v-alert info :value="true">{{ message }}</v-alert>
	</div>
</template>

<script>

    export default {
        props: ['message'],

    }
</script>

<style>

</style>