<template>
	<div id = "technician-home-container">
		<v-app id = "technician-home-app">
			<top-nav-bar></top-nav-bar>
			<v-container fluid>
				<v-layout>
					<v-flex xs12>
						<v-card>
							<v-card-title class = "green">
								<p id = "welcome-text">Welcome {{ formattedName }}!</p>
							</v-card-title>
							<v-card-text id = 'welcome-message'>
								<p>Sugar Nails introduces a new web application to help every technician to:</p>
								<ul>
									<li>View sales, wages, and payments in recent pay periods</li>
									<li>View wage reports anytime </li>
									<li>Track any balance remaining on account</li>
									<li>More features will be introduced in the near future</li>
								</ul>
								<p class = "deep-purple--text">Please click on the menu <v-icon class = "deep-purple--text">menu</v-icon> above to navigate to the pages</p>
							</v-card-text>
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

	@import url('https://fonts.googleapis.com/css?family=Khula|Pacifico');

	#technician-home-app{
		background-color: #2196F3;
	}
	#welcome-text{
		font-size: 28px ;
		text-align: center;
		color: white;
		font-family: 'Pacifico', cursive;
	}
	#welcome-message{
		font-size:18px;
		font-family: 'Khula', sans-serif;
	}

</style>