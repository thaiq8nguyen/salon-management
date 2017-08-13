<template>
	<div>
		<v-app class = "blue lighten-4">
			<main >
				<v-container fluid >
					<v-layout row wrap>
						<v-flex lg12>
							<template v-if="technicians.length > 0">
								<v-card>
									<v-card-text>
										<v-expansion-panel>
											<v-expansion-panel-content v-for="(technician,index) in technicians" :key="technician.id">
												<div slot="header" @click.capture="selectedPanel(index)">
													<v-container>
														<v-layout row wrap>
															<v-flex lg4>
																<p class = "headline" :class="{'amber--text text--darken-1':activePanel(index)}" >{{technician.full_name}}</p>
															</v-flex>
															<v-flex lg4 v-if="technician.daily_sales.length > 0">
																<template v-if="technician.count_payments.length > 0">
																	<v-chip label small class = "green darken-1 white--text subheading elevation-4">
																	<v-icon class = "white--text">done</v-icon>Paid</v-chip>
																</template>
																<template v-else>
																	<v-chip label small class = "amber darken-1 white--text subheading">
																	<v-icon class = "white--text">monetization_on</v-icon>{{ technician.total_sales_and_tips[0].total}}</v-chip>
																</template>
															</v-flex>
															<v-flex lg4 v-else>
																<v-chip label small class = "grey darken-1 white--text subheading">
																	<v-icon class = "white--text">money_off</v-icon>No Sales</v-chip>
															</v-flex>
														</v-layout>
													</v-container>
												</div>
												<v-card>
													<v-card-text class = "blue lighten-3">
														<v-layout>
															<v-flex lg4>
																<daily-sale-table :daily-sales="technician.daily_sales"></daily-sale-table>
															</v-flex>
															<v-flex lg7>
																<v-layout row wrap>
																	<v-flex lg12>
																		<total-sale-table :total-sales="technician.total_sales_and_tips"></total-sale-table>
																	</v-flex>
																	<v-flex lg12 mt-2>
																		<template v-if="technician.daily_sales.length == 0">
																			<v-card  class = "elevation-1">
																				<v-card-title class = "green darken-1">
																					<p class = "headline white--text">Make Payments</p>
																				</v-card-title>
																				<v-card-text>
																					<h3 class = "headline">{{ technician.full_name + ' has not have any sales in this period '}}</h3>
																				</v-card-text>
																				<v-spacer></v-spacer>
																				<v-btn href="/technician-sale/quick-sale-entry" primary>Quick Sale Entry</v-btn>
																			</v-card>
																		</template>
																		<template v-else-if="technician.count_payments.length == 0">
																			<make-payment :technician="technician" :period-id="periodId" :index="index" v-on:paid="paid"></make-payment>
																		</template>
																		<template v-else>
																			<v-card  class = "elevation-1">
																				<v-card-title class = "green darken-1">
																					<p class = "headline white--text">Make Payments</p>
																				</v-card-title>
																				<v-card-text>
																					<h3 class = "headline">{{ technician.full_name + ' \'s has been paid' }}</h3>
																				</v-card-text>
																				<v-card-actions>
																					<v-btn @click.native="viewPaymentReport(technician.first_name)" primary>View Report</v-btn>
																				</v-card-actions>
																			</v-card>
																		</template>
																	</v-flex>
																</v-layout>
															</v-flex>
														</v-layout>
													</v-card-text>
												</v-card>
											</v-expansion-panel-content>
										</v-expansion-panel>
									</v-card-text>
								</v-card>
							</template>
							<template v-else>
								<v-card>
									<v-card-text>
										<h3 class = "headline text-lg-center orange--text text-darken-1"><v-icon class = "orange--text text-darken-1">info</v-icon>
											There are no technician sale been recorded for this pay period</h3>
										<v-btn href = '/technician-sale/add'primary>Technician Sale</v-btn>
									</v-card-text>
								</v-card>
							</template>
						</v-flex>
					</v-layout>
				</v-container>
			</main>
		</v-app>
	</div>
</template>
<script>

    import TechnicianPaymentPanelHeader from './TechnicianPaymentPanelHeader.vue';
    import MakePayment from './MakeTechnicianPayment.vue';
    import TechnicianDailySaleTable from './TechnicianDailySaleTable.vue';
    import TechnicianTotalSaleTable from './TechnicianTotalSaleTable.vue';

    export default {
        components:
            {

                'panel-header': TechnicianPaymentPanelHeader,
	            'daily-sale-table': TechnicianDailySaleTable,
	            'total-sale-table': TechnicianTotalSaleTable,
	            MakePayment
            },


        props: [],

        data() {
            return {
                periodId: '',
                technicians: [],
	            activeIndex:null,

            }

        },
		mounted(){
			Event.$on('id',this.getWages);
		},

        methods: {
            getWages(periodId){
                this.$axios.get('/api/salon/payday?id=' + periodId).then(response =>{
					console.log(response.data);
                    this.technicians = response.data;
                    this.periodId = periodId;
                });
            },

	        selectedPanel(index){
              this.activeIndex = index;
	        },

	        activePanel(index){
	            return this.activeIndex === index;
	        },

            viewPaymentReport(first_name){
                window.location.href='/report/'+ first_name + '/payment/' + this.periodId
            },
	        paid(){
                this.getWages(this.periodId);
	        }
        }
    }
</script>

<style>

</style>