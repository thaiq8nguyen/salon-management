<template>
	<div>
		<v-app>
			<main>
				<v-container fluid>
					<v-layout row wrap>
						<v-flex lg4 xs12>
							<v-card>
								<v-card-title class = "amber darken-1">
									<v-flex lg6 xs6 >
										<h3 class = "headline white--text">
											<strong>Reminders</strong>
										</h3>
									</v-flex>
									<v-flex lg2 xs2 offset-lg4 offset-xs4>
										<v-icon class = "white--text">event_note</v-icon>
									</v-flex>
								</v-card-title>
								<v-card-text>
									<pay-day-reminder></pay-day-reminder>
									<v-divider></v-divider>
								</v-card-text>
							</v-card>
						</v-flex>
						<v-flex lg4 xs12 class="margin-top" hidden-xs-only>
							<v-card>
								<v-card-title class = "green darken-1">
									<v-flex lg6 xs6>
										<h3 class = "headline white--text">
											<strong>New Features</strong>
										</h3>
									</v-flex>
									<v-flex lg2 xs2 offset-lg4 offset-xs4>
										<v-icon medium class = "white--text">view_headline</v-icon>
									</v-flex>
								</v-card-title>
								<v-card-text>

								</v-card-text>
							</v-card>
						</v-flex>
						<v-flex lg4 xs12 class = "margin-top">
							<v-card>
								<v-card-title class = "deep-purple darken-1">
									<v-flex lg6 xs6>
										<h3 class = "headline white--text">
											<strong>Shortcuts</strong>
										</h3>
									</v-flex>
									<v-flex lg2 xs2 offset-lg4 offset-xs4>
										<v-icon medium class = "white--text">bookmark</v-icon>
									</v-flex>
								</v-card-title>
								<v-card-text>
									<template v-for="shortcut in shortcuts">
										<v-btn :class="shortcut.color":href="shortcut.href" primary block>{{shortcut.name}}</v-btn>
									</template>
								</v-card-text>
							</v-card>
						</v-flex>
						<v-flex lg4 xs12 hidden-xs-only class = "margin-top">
							<v-card>
							<v-card-title class = "indigo darken-1">
								<v-flex lg6 xs6>
									<h3 class = "headline white&#45;&#45;text">
										<strong>Trends</strong>
									</h3>
								</v-flex>
								<v-flex lg2 xs2 offset-lg4 offset-xs4>
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
	                {name:'Add Technician Sale', href:'/technician-sale/add', color:'blue darken-4'},
	                {name:'Pay Technicians', href:'/wages/pay',color:'blue darken-4'},
	                {name:'Salon Sale', href:'/salon-sales',color:'blue darken-4'},
	                {name:'Quick Sale Entry', href:'/technician-sale/quick-sale-entry',color:'red darken-4'}

                ]
            }


        },
        methods: {}


    }
</script>

<style>
	@media only screen
	and (min-device-width: 414px)
	and (max-device-width: 736px)
	and (-webkit-min-device-pixel-ratio: 3)
	and (orientation: portrait) {

		.margin-top{

			margin-top: 10px;

		}
	}
</style>