<template>
	<div>
		<v-app class = "blue lighten-4">
			<v-content>
                <primary-nav-bar></primary-nav-bar>
				<v-container fluid >
					<v-layout row wrap>
						<v-flex lg12>
                            <pay-period-header></pay-period-header>
							<template v-if="technicians.length > 0">
								<v-card>
									<v-card-text>
										<v-expansion-panel>
											<v-expansion-panel-content v-for="(technician,index) in technicians" :key="technician.id">
												<div slot="header" @click.capture="selectedPanel(index)">
													<p>
														<span class = "headline technician-name" :class="{'amber--text text--darken-1':activePanel(index)}">{{technician.full_name}}</span>
														<span v-if="technician.daily_sales.length > 0" class = "chip-container">
															<template v-if="technician.payment_report.length > 0">
																<v-chip label small class = "green darken-1 white--text subheading elevation-4">
																<v-icon class = "white--text">done</v-icon>Paid</v-chip>
															</template>
															<template v-else>
																<v-chip label small class = "amber darken-1 white--text subheading">
																<v-icon class = "white--text">monetization_on</v-icon>{{ technician.total_sales_and_tips[0].total}}</v-chip>
															</template>
														</span>
														<span v-else class = "chip-container">
															<v-chip label small class = "grey darken-1 white--text subheading">
																<v-icon class = "white--text">money_off</v-icon>No Sales</v-chip>
														</span>
													</p>
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
																		<template v-else-if="technician.payments.length == 0">
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
																				<v-card-actions v-if = "technician.payment_report.length == 0">
																					<v-btn @click.native ="createPaymentReport(index)">Create Report</v-btn>
																				</v-card-actions>
																				<v-card-actions v-else>
																					<v-btn @click.native ="viewPaymentReport(index)" primary>View Report</v-btn>
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
			</v-content>
		</v-app>
	</div>
</template>
<script>

    import PrimaryNavBar from './PrimaryNavBar';
    import PayPeriodHeader from '../partials/PayPeriodHeader';
    import TechnicianPaymentPanelHeader from './TechnicianPaymentPanelHeader.vue';
    import MakePayment from './MakeTechnicianPayment.vue';
    import TechnicianDailySaleTable from '../common/TechnicianDailySaleTable.vue';
    import TechnicianTotalSaleTable from '../common/TechnicianTotalSaleTable.vue';

    export default {
        components:
            {

                PrimaryNavBar,
                PayPeriodHeader,
                'panel-header': TechnicianPaymentPanelHeader,
	            'daily-sale-table': TechnicianDailySaleTable,
	            'total-sale-table': TechnicianTotalSaleTable,
	            MakePayment
            },


        props: [],

        data() {
            return {
                periodId: '',
                technicians:[],
	            activeIndex:null,

            }

        },
		mounted(){
			Event.$on('id',this.getWages);
		},

        methods: {
            getWages(periodId){
                this.$axios.get('/api/salon/payday?id=' + periodId).then(response =>{
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
			createPaymentReport(index){
	            const technicianId = this.technicians[index].id;
				this.$axios.post('/api/technician-payment/report/create',
					{technicianId: technicianId, payPeriodId: this.periodId}).then(response => {
					    if(response.data.success){
                            this.getWages(this.periodId);
					    }

				});
			},
            viewPaymentReport(index){
	            const url = this.technicians[index].payment_report[0].pivot.payment_report_url;
				window.open(url);

            },
	        paid(){
                this.getWages(this.periodId);
	        }
        }
    }
</script>

<style>
	.technician-name{
		float:left;
		width:250px;
	}
	.chip-container{
		float:right;
		width:250px;
	}
</style>