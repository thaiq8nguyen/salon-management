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
											<v-expansion-panel-content v-for="(technician,index) in technicians" :key="technician.id" >
												<div slot="header">
													<p class = "headline">{{technician.full_name}}
														<span v-if="technician.count_payments.length > 0">
												<v-chip label small outline class = "green--text"><v-icon class = "green--text">done</v-icon>Paid</v-chip>
											</span>
													</p>
												</div>
												<v-card>
													<v-card-text class = "blue lighten-3">
														<v-layout>
															<v-flex lg4>
																<v-card class = "elevation-1 grey lighten-4">
																	<v-card-text>
																		<v-data-table :headers="dailySales.headers" :items="technician.daily_sales" hide-actions >
																			<template slot="headers" scope="props">
																				<th v-for="header in props.headers" :key="header.text">
																					<p class = "subheading text-lg-center">{{ header.text }}</p>
																				</th>
																			</template>
																			<template slot="items" scope="props">
																				<td class = "text-xs-center subheading">{{ readableDate(props.item.sale_date) }}</td>
																				<td class = "text-xs-right subheading">$ {{ props.item.sales }}</td>
																				<td class = "text-xs-right subheading">$ {{ props.item.additional_sales }}</td>
																			</template>
																		</v-data-table>
																	</v-card-text>
																</v-card>
															</v-flex>
															<v-flex lg7>
																<v-layout row wrap>
																	<v-flex lg12>
																		<v-card class = "elevation-1 grey lighten-4">
																			<v-card-text>
																				<v-data-table :headers="totalSales.headers" :items="technician.total_sales_and_tips"
																				              hide-actions>
																					<template slot="headers" scope="props">
																						<th v-for="header in props.headers" :key="header.text">
																							<p class = "subheading text-lg-center">{{ header.text }}</p>
																						</th>
																					</template>
																					<template slot="items" scope="props">
																						<td class = "text-xs-right subheading">$ {{ props.item.subTotal }}</td>
																						<td class = "text-xs-right subheading">$ {{ props.item.subTotalTip }}</td>
																						<td class = "text-xs-right subheading">$ {{ props.item.earnedTotal }}</td>
																						<td class = "text-xs-right subheading">$ {{ props.item.earnedTip }}</td>
																						<td class = "text-lg-center red--text headline">$ {{ props.item.total }}</td>
																					</template>
																				</v-data-table>
																			</v-card-text>
																		</v-card>
																	</v-flex>
																	<v-flex lg12 mt-2>
																		<template v-if="technician.count_payments.length == 0">
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

    import VExpansionPanel from "vuetify/src/components/expansion-panel/VExpansionPanel";
    import MakePayment from './MakeTechnicianPayment.vue';

    export default {
        components:
            {
	            MakePayment
            },


        props: [],

        data() {
            return {
                periodId: '',
                technicians: [],
                dailySales: {
                    headers: [
                        {text: 'Date', value: 'sale_date', sortable: false},
                        {text: 'Sale', value: 'sales', sortable: false},
                        {text: 'Tip', value: 'additional_sales', sortable: false}

                    ]
                },
                totalSales: {
                    headers: [
                        {text: 'Sub Total', value: 'subTotal', sortable: false},
                        {text: 'Sub Total Tip', value: 'subTotalTip', sortable: false},
                        {text: 'Earned Total', value: 'earnedTotal', sortable: false},
                        {text: 'Tip Deduction', value: 'earnedTip', sortable: false},
                        {text: 'Total Wages', value: 'total', sortable: false},

                    ]
                },
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
            readableDate(date){
                return this.$moment(date).format('MM/DD/YY dddd');
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