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
							          v-model="selectTechnician" item-text="full_name" last item-value="id" autocomplete>

							</v-select>
						</v-flex>
					</v-layout>
				</v-card-text>
			</v-card>
			<v-container fluid>
				<v-layout row v-if="report == null">
					<v-flex lg6 offset-lg3>
						<v-alert value="true" class = "green darken-1 text-xs-center">
							<p class = "headline">Select a technician</p>
						</v-alert>
					</v-flex>
				</v-layout>
				<v-layout row v-else>
					<v-flex lg4>
						<v-card>
							<v-card-title class = "green darken-1">
								<v-flex lg6>
									<h3 class = "headline white--text">
										<strong>Payments</strong>
									</h3>
								</v-flex>
								<v-flex lg2 offset-lg4>
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
													</v-layout>
												</v-container>
											</v-card-text>
										</v-card>
									</v-card-text>
								</template>
								<v-card-text>
									<v-btn class = "red--text" @click.native="deletePayment">
										Delete</v-btn>
								</v-card-text>
							</div>
							<div v-else>
								<v-card-text>
									<v-alert value="true" class = "green darken-1 text-xs-center"><p class = "subheading">
										No payments found at this pay period</p></v-alert>
								</v-card-text>
							</div>
						</v-card>
					</v-flex>
					<v-flex lg4>
						<v-card>
							<v-card-title class = "indigo darken-1">
								<v-flex lg6>
									<h3 class = "headline white--text">
										<strong>Wage Report</strong>
									</h3>
								</v-flex>
								<v-flex lg2 offset-lg4>
									<v-icon class = "white--text">fa-sticky-note-o</v-icon>
								</v-flex>
							</v-card-title>
							<v-card-text v-if="existingReport">
								<v-layout row wrap>
									<v-flex lg6>
										<v-btn @click.native = "openReport" primary>View Report</v-btn>
									</v-flex>
									<v-flex lg6>
										<v-btn @click.native = "loader = updateReport()" :loading="updating" :disabled="updating">
											Update Report <span slot = "loader">Updating...</span>
										</v-btn>
									</v-flex>
								</v-layout>
							</v-card-text>
							<v-card-text v-else>
								<v-alert value="true" class = "orange darken-1 text-xs-center"><p class = "subheading">
									No wage report found at this pay period</p></v-alert>
							</v-card-text>
						</v-card>
					</v-flex>
					<v-flex lg4>
						<v-card>
							<v-card-title class = "amber darken-1">
								<v-flex lg6>
									<h3 class = "headline white--text">
										<strong>Balances</strong>
									</h3>
								</v-flex>
								<v-flex lg2 offset-lg4>
									<v-icon class = "white--text">fa-dollar</v-icon>
								</v-flex>
							</v-card-title>
							<v-card-text>
								<p class = "subheading">Period Balance: <span>$ {{ payPeriodBalance }}</span></p>
								<p class = "subheading">Total Balance: <span>$ {{ totalBalance }}</span></p>
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

	            selectTechnician: null,
	            technicians: [],
	            payPeriods:[],
	            report: null,
	            currentPeriod: null,
	            payments:[],
	            selectPayPeriodId:null,
	            reportUrl:null,
	            updating:false,
	            payPeriodBalance: null,
	            totalBalance: null,

            }
        },

	    mounted(){

            this.getPayPeriod();
            this.getTechnicians();

	    },
	    computed:{
			existingReport(){
			    return (this.report.wage_report_url !== null);
			}
	    },

	    watch: {

            selectPayPeriodId() {
                sessionStorage.setItem('selectedPayPeriodId', this.selectPayPeriodId);
                if (this.selectTechnician !== null) {

                    this.getReport();

                }

            },
            selectTechnician() {
                if (this.selectPayPeriodId !== null) {
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

				this.$http.get('technician-pay-period/search?technicianId='
					+ this.selectTechnician + '&payPeriodId=' + this.selectPayPeriodId)
					.then(response => {
					    console.log(response.data);
					    this.report = response.data;
						this.payPeriodBalance = this.report.pay_period_balance === null?'0.00':this.report.pay_period_balance.balance;
						this.totalBalance = this.report.total_balance === null?'0.00':this.report.total_balance.balance;
				        this.payments = this.report.wage_payment;
                        this.reportUrl = this.report.wage_report_url === null?null:this.report.wage_report_url.payment_report_url;

				});

	        },

	        openReport(){

	            window.open(this.reportUrl);

	        },

	        updateReport(){

				this.updating = true;
	            this.$http.get('technician-pay-period/update?technicianId=' +  this.selectTechnician + '&payPeriodId='
	            + this.selectPayPeriodId).then(response => {

	                this.updating = false;

	            })
	        },

	        deletePayment(){
	            const payment = { technicianId: this.selectTechnician,payPeriodId:this.selectPayPeriodId };
	            this.$http.post('technician-payment/delete',payment).then(response => {
	                    if(response.data.success){
                            this.payments =[];
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