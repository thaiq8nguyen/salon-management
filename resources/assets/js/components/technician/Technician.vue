<template>
	<div id = "technician-home-container">
		<v-app id = "technician-home-app">
			<top-nav-bar></top-nav-bar>
			<v-container fluid>
				<v-layout>
					<v-flex xs12>
						<v-card flat>
							<v-card-title>
								<p class = "title">Welcome {{ formattedName }}!</p>
							</v-card-title>
						</v-card>
					</v-flex>
				</v-layout>
			</v-container>
		</v-app>
	</div>
</template>

<script>
	import TechnicianTopNavBar from './TechnicianTopNavBar.vue'
    export default {
        props: [],
		components:{
            'top-nav-bar': TechnicianTopNavBar,
		},
        data() {
            return {
	            firstName: null,
	            technicianId: null,
            }


        },

	    mounted(){
            this.welcome();
	    },

	    computed:{
	        formattedName(){
	            if(this.firstName !== null){
                    return (this.firstName).substr(0,1).toUpperCase() + (this.firstName).slice(1);
	            }

	        }
	    },
        methods: {
			welcome(){
				this.$axios.get('/api/technician/home').then(response => {
				    this.firstName = response.data.first_name;
				    this.technicianId = response.data.technician_id;
				    sessionStorage.setItem('firstName', response.data.first_name);
				    sessionStorage.setItem('technicianId', response.data.technician_id )
				});
			}
        }


    }
</script>

<style>
	#technician-home-app{
		background-color: #2196F3;
	}
</style>