<template>
	<div>
		<v-app>
			<main>
				<v-container>
					<v-layout row wrap>
						<v-flex lg4>
							<v-card>
								<v-card-title class = "amber darken-1">
									<v-flex lg6>
										<h3 class = "headline white--text">
											<strong>Reminders</strong>
										</h3>
									</v-flex>
									<v-flex lg2 offset-lg4>
										<v-icon class = "white--text">event_note</v-icon>
									</v-flex>
								</v-card-title>
								<v-card-text>
									<pay-day-reminder></pay-day-reminder>
									<v-divider></v-divider>
								</v-card-text>
							</v-card>
						</v-flex>
						<v-flex lg4>
							<v-card>
								<v-card-title class = "green darken-1">
									<v-flex lg6>
										<h3 class = "headline white--text">
											<strong>New Features</strong>
										</h3>
									</v-flex>
									<v-flex lg2 offset-lg4>
										<v-icon medium class = "white--text">view_headline</v-icon>
									</v-flex>
								</v-card-title>
								<v-card-text>

								</v-card-text>
							</v-card>
						</v-flex>
						<v-flex lg4>
							<v-card>
								<v-card-title class = "deep-purple darken-1">
									<v-flex lg6>
										<h3 class = "headline white--text">
											<strong>Shortcuts</strong>
										</h3>
									</v-flex>
									<v-flex lg2 offset-lg4>
										<v-icon medium class = "white--text">bookmark</v-icon>
									</v-flex>
								</v-card-title>
								<v-card-text>
									<template v-for="shortcut in shortcuts">
										<v-btn :href="shortcut.href" primary block>{{shortcut.name}}</v-btn>
									</template>
								</v-card-text>
							</v-card>
						</v-flex>
						<v-flex lg4 mt-2>
							<v-card>
							<v-card-title class = "indigo darken-1">
								<v-flex lg6>
									<h3 class = "headline white--text">
										<strong>Trends</strong>
									</h3>
								</v-flex>
								<v-flex lg2 offset-lg4>
									<v-icon medium class = "white--text">trending_up</v-icon>
								</v-flex>
							</v-card-title>
							<v-card-text>

							</v-card-text>
						</v-card>
						</v-flex>
					</v-layout>
				</v-container>
			</main>
		</v-app>
	</div>
</template>

<script>

	import PayDayReminder from './PaydayReminder.vue';
    export default {
        props: [],

	    components:{
            PayDayReminder
	    },

        data() {
            return {
                shortcuts:[
	                {name:'Add Technician Sale', href:'/technician-sale/add'},
	                {name:'Pay Technicians', href:'/wages/pay'},
	                {name:'Salon Sale', href:'/salon-sales'},
	                {name:'Quick Daily Sales', href:'/technician-sale/quick-sale-entry'}

                ]
            }


        },
        methods: {}


    }
</script>

<style>

</style>