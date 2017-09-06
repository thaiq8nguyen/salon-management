<template>
	<div>
		<v-app id = "technician-payment-report-viewer-app">
			<top-nav-bar></top-nav-bar>
			<main>
				<div :style="{width:allowedWidth, height:allowedHeight}">
					<object :data="url" name = "url" type = "application/pdf" width = "100%" height = "100%">
						No File Found
					</object>
				</div>
			</main>
		</v-app>
	</div>
</template>

<script>
	import TopNavBar from './TechnicianTopNavBar.vue';
    export default {
        props: [],

	    components:{

            'top-nav-bar':TopNavBar,

	    },

        data() {
            return {
                url: null,
	            maxHeight: window.innerHeight,
	            topNavBarHeight : null,
            }


        },
	    mounted(){
            this.handle();
            this.topNavBarHeight = document.getElementById('top-nav-bar').clientHeight;
	    },

	    computed:{
	        allowedWidth(){
	            return '100%';

	        },
	        allowedHeight(){
		        return (this.maxHeight - this.topNavBarHeight) + 'px';
	        },
	    },
        methods: {

	        handle(){
	            this.url =  sessionStorage.getItem('reportUrl');
	        }
        }


    }
</script>

<style>

</style>