<template>
	<div>
		<v-app>
			<main>
				<v-container fluid>
					<v-layout row wrap>
						<v-flex lg12>
							<v-expansion-panel>
								<v-expansion-panel-content v-for="technician in technicians" :key="technician.id" >
									<div slot="header">
										<p class = "subheading">{{technician.first_name + ' ' + technician.last_name}}</p>
									</div>
									<v-card>
										<v-card-text>
											<v-layout>
												<v-flex lg3>
													<v-card class = "elevation-1">
														<v-card-text>
															<v-data-table :headers="dailySales.headers" :items="technician.daily_sales" hide-actions>
																<template slot="items" scope="props">
																	<td class = "text-xs-center">{{ readableDate(props.item.sale_date) }}</td>
																	<td class = "text-xs-right">$ {{ props.item.sales }}</td>
																	<td class = "text-xs-right">$ {{ props.item.additional_sales }}</td>
																</template>
															</v-data-table>
														</v-card-text>
													</v-card>
												</v-flex>
												<v-flex lg6>
													<v-layout row wrap>
														<v-flex lg12>
															<v-card class = "elevation-1">
																<v-card-text>
																	<v-data-table :headers="totalSales.headers" :items="technician.total_sales_and_tips"
																	              hide-actions>
																		<template slot="items" scope="props">
																			<td class = "text-xs-right">$ {{ props.item.subTotal }}</td>
																			<td class = "text-xs-right">$ {{ props.item.subTotalTip }}</td>
																			<td class = "text-xs-right">$ {{ props.item.earnedTotal }}</td>
																			<td class = "text-xs-right">$ {{ props.item.earnedTip }}</td>
																			<td class = "text-xs-right red--text subheading">$ {{ props.item.total }}</td>
																		</template>
																	</v-data-table>
																</v-card-text>
															</v-card>

														</v-flex>
														<v-flex lg12 mt-2>
															<v-card class = "elevation-1">
																<v-card-title class = "green darken-1">
																	<p class = "headline white--text">Make Payments</p>

																</v-card-title>
																<v-card-text>
																	<template v-for="(payment,index) in payments">
																		<v-layout row>
																			<v-flex lg2><v-chip label>Payment {{ index + 1}}</v-chip></v-flex>
																			<v-flex lg2>
																				<v-text-field label = "Amount" prefix="$" disabled v-model="payment.amount"></v-text-field>
																			</v-flex>
																			<v-flex lg2>
																				<v-text-field label = "Reference" disabled v-model="payment.reference"></v-text-field>
																			</v-flex>
																			<v-flex lg2>
																				<v-text-field label = "Method" disabled v-model="payment.method"></v-text-field>
																			</v-flex>
																			<v-flex lg3>
																				<v-btn @click.native="deletePayment(index)" class = "red">
																					<v-icon class = "white--text">delete</v-icon></v-btn>
																			</v-flex>
																		</v-layout>
																	</template>
																	<v-chip label v-if="totalPayingAmount > 0" class="blue darken-1 white--text">
																		Total Paying: $ {{ totalPayingAmount }}
																	</v-chip>
																	<v-divider v-if="payments.length > 0"></v-divider>
																	<payment-form @add="addPayment"></payment-form>
																</v-card-text>
																<v-divider></v-divider>
																<v-card-actions v-if="payments.length > 0">
																	<v-btn @click.native="makePayment(technician.total_sales_and_tips)"  primary>Make Payment</v-btn>
																</v-card-actions>
															</v-card>
														</v-flex>
													</v-layout>
												</v-flex>
											</v-layout>
										</v-card-text>
									</v-card>
								</v-expansion-panel-content>
							</v-expansion-panel>
						</v-flex>
					</v-layout>
				</v-container>
			</main>
		</v-app>
	</div>
</template>
<script>


    import VExpansionPanel from "vuetify/src/components/expansion-panel/VExpansionPanel";
    import TechnicianPaymentForm from './TechnicianPaymentForm.vue';

    export default {
        components:
            {

                VExpansionPanel,
	            'payment-form':TechnicianPaymentForm

            }

	        ,
        props: [],

        data() {
            return {
                periodId:'',
				technicians:[],
	            dailySales:{
                    headers:[
                        {text:'Date', value:'sale_date', sortable:false},
                        {text:'Sale', value: 'sales', sortable:false},
                        {text:'Tip', value: 'additional_sales', sortable:false}

                    ]
	            },
	            totalSales:{
				    headers:[
					    {text:'Sub Total', value:'subTotal', sortable:false},
                        {text:'Sub Total Tip', value:'subTotalTip', sortable:false},
                        {text:'Earned Total', value:'earnedTotal', sortable:false},
                        {text:'Tip Deduction', value:'earnedTip', sortable:false},
                        {text:'Total Wages', value:'total', sortable:false},

				    ]
	            },
	            payments:[],
	            maxPayment: 3,
	            totalPayingAmount:0,


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
            readableDate(date){
                return this.$moment(date).format('MM/DD/YY dd');
            },

	        addPayment(payment) {
				if(this.payments.length < this.maxPayment){
                    this.payments.push({
                        amount:payment.amount,
                        reference:payment.reference,
                        method:payment.method,
                    });
				}
				this.getTotalAmount();
            },

	        deletePayment(index){
                this.payments.splice(index, 1);
                this.getTotalAmount();
	        },

			getTotalAmount(){
	            let sum = 0;
	            for(let i = 0; i < this.payments.length; i++){
	                sum += parseInt(this.payments[i].amount);
	            }
	            this.totalPayingAmount = sum;

			},


	        makePayment(technicianId){
		        this.$axios()
	        }
        }


    }
</script>

<style>

</style>