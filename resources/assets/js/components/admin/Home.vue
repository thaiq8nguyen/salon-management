<template>
	<div>
		<v-app>
			<v-content>
                <primary-nav-bar></primary-nav-bar>
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
								<v-card-text class = "text-lg-center text-xs-center">
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
										<v-btn :class="shortcut.color" :href="shortcut.href" block>{{shortcut.name}}</v-btn>
									</template>
								</v-card-text>
							</v-card>
						</v-flex>
						<v-flex lg4 xs12 hidden-xs-only class = "margin-top">
							<v-card>
							<v-card-title class = "indigo darken-1">
								<v-flex lg6 xs6>
									<h3 class = "headline white--text">
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
			</v-content>
		</v-app>
	</div>
</template>

<script>

    import PrimaryNavBar from './PrimaryNavBar';
	import PayDayReminder from './PaydayReminder.vue';
    export default {
        props: [],

	    components:{
            PrimaryNavBar,
            PayDayReminder
	    },

        data() {
            return {
                shortcuts:[
	                {name:'Add Technician Sale', href:'/technician-sale/add', color:'primary'},
	                {name:'Pay Technicians', href:'/wages/pay',color:'primary'},
	                {name:'Salon Sale', href:'/salon-sales',color:'primary'},
	                {name:'Quick Sale Entry', href:'/technician-sale/quick-sale-entry',color:'error '},
	                {name:'Gift Certificate', href:'/gift-certificate',color:'primary'},


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