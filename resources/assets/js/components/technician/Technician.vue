<template>
	<div id = "technician-home">
		<v-app class = "white">
			<v-toolbar class = "blue">
				<v-btn icon :href="home">
					<v-icon class = "white--text">home</v-icon>
				</v-btn>
				<v-btn icon :href="sale">
					<v-icon class = "white--text">attach_money</v-icon>
				</v-btn>
				<v-spacer></v-spacer>
				<v-btn icon :href="logout">
					<v-icon class = "white--text">exit_to_app</v-icon>
				</v-btn>
			</v-toolbar>
			<v-container fluid>
				<v-layout>
					<v-flex xs12>
						<v-card flat>
							<v-card-title>
								<p class = "title">Welcome {{ formattedName }}!</p>
							</v-card-title>
							<v-card-text>
								<v-layout row wrap>
									<v-flex xs12>
										<v-btn class = "green white--text" block :href="sale">
											<v-icon class = "white--text">attach_money</v-icon>
											<span>How much do I make?</span>
										</v-btn>
									</v-flex>
									<v-flex xs12>
										<v-btn class = "amber white--text" block :href="logout">
											<v-icon class = "white--text">exit_to_app</v-icon>
											<span>Log Out</span>
										</v-btn>
									</v-flex>
								</v-layout>
							</v-card-text>
						</v-card>
					</v-flex>
				</v-layout>
			</v-container>
		</v-app>
	</div>
</template>

<script>
    export default {
        props: [],

        data() {
            return {
				home:'/technician',
	            logout:'/logout',
	            sale: '/technician/sale',
	            firstName: null,
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
				    this.firstName = response.data;
				    sessionStorage.setItem('firstName',response.data);
				});
			}
        }


    }
</script>

<style>

</style>