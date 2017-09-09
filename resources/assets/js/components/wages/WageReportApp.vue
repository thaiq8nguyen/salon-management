<template>
	<div>
		<v-app id = "wage-report-app">
			<v-card flat>
				<v-card-text>
					<v-layout row>
						<v-flex lg2>
							<v-subheader class = "subheading">Pay Periods</v-subheader>
						</v-flex>
						<v-flex lg4>
							<v-select :items="payPeriods" label="Select" single-line class = "select"
							          v-model="selectPayPeriodId" item-text="periods" item-value="id" >

							</v-select>
						</v-flex>
						<v-flex lg2>
							<v-subheader class = "subheading">Technicians</v-subheader>
						</v-flex>
						<v-flex lg2>
							<v-select :items="technicians" label="Select" single-line class = "select"
							          v-model="selectTechnician" item-text="full_name" last item-value="id">

							</v-select>
						</v-flex>
					</v-layout>
				</v-card-text>
			</v-card>
			<v-container fluid>
				<v-layout row>
					<v-flex lg4>
						<v-container fluid>
							<v-layout row>
								<v-flex lg12>
									<v-card>
										<v-card-title class = "green darken-1">
											<v-flex lg6>
												<h3 class = "headline white--text">
													<strong>Payments</strong>
												</h3>
											</v-flex>
											<v-flex lg2 xs2 offset-lg4 offset-xs4>
												<v-icon class = "white--text">fa-money</v-icon>
											</v-flex>
										</v-card-title>
										<div v-if="payments.length > 0">
											<template v-for="(payment,index) in payments">
												<v-card-text>
													<v-card flat>
														<v-card-text>
															<v-container>
																<v-layout row>
																	<v-flex lg2>
																		<div class = "subheading"># {{ index + 1}}</div>
																	</v-flex>
																	<v-flex lg3>
																		<div class = "subheading">$ {{ payment.amount}}</div>
																	</v-flex>
																	<v-flex lg3>
																		<div class = "subheading">{{ payment.method}}</div>
																	</v-flex>
																	<v-flex lg3>
																		<v-btn class = "red--text" @click.native.once="deletePayment(index)">
																			Delete</v-btn>
																	</v-flex>
																</v-layout>
															</v-container>
														</v-card-text>
													</v-card>
												</v-card-text>
											</template>
										</div>
										<div v-else>
											<v-card-text>
												<v-alert value="true" class = "green darken-1 text-xs-center"><p class = "subheading">
													No payments found at this time</p></v-alert>
											</v-card-text>
										</div>
									</v-card>
								</v-flex>
								<v-flex lg12 mt-2>
									<v-card>
										<v-card-text>
											<v-btn @click.native.once="updateReport">Update Report</v-btn>
										</v-card-text>
									</v-card>
								</v-flex>
							</v-layout>
						</v-container>
					</v-flex>
					<v-flex lg8>
						<div v-if="reportSrc !== null">
							<iframe :src = "reportSrc" style="width:100%; height:800px;" frameborder="0" ></iframe>
						</div>
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

	            selectTechnician: null,
	            technicians: [],
	            payPeriods:[],
	            currentPeriod: null,
	            payments:[],
	            selectPayPeriodId:null,
	            reportSrc: null,

            }
        },

	    mounted(){
            this.getPayPeriod();
            this.getTechnicians();



	    },
	    computed:{

	    },
	    watch:{
			selectPayPeriodId(){
			    sessionStorage.setItem('selectedPayPeriodId', this.selectPayPeriodId);
			    if(this.selectTechnician !== null){
			        this.getReport();
			    }

			},
		    selectTechnician(){
	            if(this.selectPayPeriodId !== null){
	                this.getReport();
	            }
		    }

	    },

        methods: {

            getPayPeriod(){
                this.$http.get('pay-period/list').then(response => {

                    this.payPeriods = response.data;
                    this.currentPeriod = response.data[response.data.length-1];

                    //retrieve the last selected period id in a session variable
                    const selectedPeriodId = sessionStorage.getItem('selectedPayPeriodId');
                    if(selectedPeriodId === null){
                        this.selectPayPeriodId = this.currentPeriod.id;

                    }else{
                        this.selectPayPeriodId = parseInt(selectedPeriodId);
                    }

                });
            },

            getTechnicians(){
                this.$http.get('technician-detail/by-position?category=employee').then(response => {

                    this.technicians = response.data;

                });
            },

	        getReport(){

				this.$http.get('technician-report/search/by-pay-period?technicianId='
					+ this.selectTechnician + '&payPeriodId=' + this.selectPayPeriodId)
					.then(response => {
						console.log(response.data);
						if(response.data.pay_period !== null){
                            this.reportSrc = response.data.pay_period.payment_report_url;
						}

				        this.payments = response.data.payments;
				});

	        },

	        updateReport(){

	            this.$http.get('technician-wage/report/update?technicianId=' +  this.selectTechnician + '&payPeriodId='
	            + this.selectPayPeriodId).then(response => {

	                this.reportSrc = response.data;
	            })
	        },

	        deletePayment(index){
	            const payment = {paymentId:this.payments[index].id,
		            payPeriodId:this.selectPayPeriodId,
		            technicianId: this.selectTechnician
	            };
	            this.$http.post('technician-payment/delete',payment).then(response => {
	                    if(response.data === 1){
                            this.payments.splice(index,1);
	                    }
		            });

	        },
	        readableDate(date){
	            return this.$moment(date).format('MM/DD/YYYY');
	        }
        }


    }
</script>

<style>
	#wage-report-app{
		background-color: #2196F3 !important;
	}
	.select{
		width: 250px !important;
	}
</style>