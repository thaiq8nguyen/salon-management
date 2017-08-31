<template>
	<div>
		<v-app id = "wage-report-app">
			<v-card flat>
				<v-card-text>
					<v-layout row>
						<v-flex lg1>
							<v-subheader class = "subheading">Times</v-subheader>
						</v-flex>
						<v-flex lg2>
							<v-select :items="times" label="Select" single-line class = "select"
							          v-model="selectTime" item-text="time" item-value="id" @input="setTime">

							</v-select>
						</v-flex>
						<v-flex lg3>
							<v-text-field label="From" class = "time-input" v-model="fromDate" readonly></v-text-field>
							<v-text-field label="To" class = "time-input" v-model="toDate" readonly></v-text-field>
						</v-flex>
						<v-flex lg1>
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
													<v-layout row wrap>
														<v-flex lg3>
															<div class = "subheading">Payment # {{ index + 1}}</div>
														</v-flex>
														<v-flex lg6 offset-lg3>
															<div class = "subheading">Pay Date: <strong>{{ readableDate(payment.pay_date)}}</strong></div>
														</v-flex>
														<v-flex lg6 offset-lg4 mt-3>
															<div class = "headline">$ {{ payment.amount}}</div>
														</v-flex>
														<v-flex lg4 mt-3>
															<div class = "subheading">By {{ payment.method}}</div>
														</v-flex>
														<v-flex lg4 offset-lg3 mt-3>
															<div class = "subheading" v-if="payment.reference !== null">Reference: {{ payment.reference }}</div>
														</v-flex>
													</v-layout>
													<v-layout row>
														<v-flex lg3>
															<v-btn icon class = "red--text" @click.native.once="deletePayment(index)"><v-icon>fa-trash</v-icon></v-btn>
														</v-flex>
													</v-layout>
												</v-card-text>
											</v-card>
										</v-card-text>
									</template>
								</div>

								<div v-else>
									<v-card-text>
										<v-alert value="true" class = "green darken-1 text-xs-center"><p class = "subheading">No payments found at this time</p></v-alert>
									</v-card-text>
								</div>

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
                times:[
	                {
	                    id:0,
		                time:'this month',
		                from: this.$moment().startOf('month'),
		                to: this.$moment().endOf('month'),
	                },
	                {
	                    id:1,
		                time:'last pay period',
		                from: null,
		                to: null,

	                },
	                {
	                    id:2,
		                time:'last month',
		                from: this.$moment().subtract(1,'months').startOf('month'),
	                    to: this.$moment().subtract(1,'months').endOf('month'),

	                },
                ],
	            selectTime:null,
	            selectTechnician: null,
	            technicians: [],
	            payPeriods:[],
	            fromDate:null,
	            toDate:null,
	            payments:[],

            }
        },

	    mounted(){
            this.getTechnicians();
            this.getPayPeriod();
            this.defaultTime();
	    },
	    computed:{
	        lastPayPeriod(){
	            return this.payPeriods[this.payPeriods.length - 2];
	        },
		    formattedFromDate(){
	            return this.$moment(this.fromDate,'MM/DD/YYYY').format('YYYY-MM-DD');
		    },
		    formattedToDate(){
                return this.$moment(this.toDate,'MM/DD/YYYY').format('YYYY-MM-DD');
		    }
	    },
	    watch:{
	        selectTime(){
	            if(this.selectTechnician !== null){
	                this.getPayments();
	            }
		    },
		    selectTechnician(){
	            if(this.selectTime !== null){
	                this.getPayments();
	            }
		    }

	    },

        methods: {

			defaultTime(){

			    this.selectTime = 0;

			},
			setTime(){
				if(this.selectTime === 1){
				    this.fromDate = (this.lastPayPeriod.periods).substr(0,10);
				    this.toDate = (this.lastPayPeriod.payDate);
 				}
				else{
                    this.fromDate =  (this.times[this.selectTime].from).format('MM/DD/YYYY');
                    this.toDate = (this.times[this.selectTime].to).format('MM/DD/YYYY');
				}


			},
            getTechnicians(){
                this.$http.get('technician-detail/by-position?category=employee').then(response => {

                    this.technicians = response.data;
                    this.selectTechnician = this.technicians[0].id;
                });
            },
            getPayPeriod(){
				this.$http.get('pay-period/list').then(response =>{
				this.payPeriods = response.data;
				});


			},

	        getPayments(){
				this.$http.get('technician-payment/search/by-date?technicianId='
					+ this.selectTechnician + '&from=' + this.formattedFromDate + '&to=' + this.formattedToDate)
					.then(response => {
				        this.payments = response.data;
				});

	        },

	        deletePayment(index){
	            const payment = {paymentId:this.payments[index].id,
		            payPeriodId:this.payments[index].pay_period_id,
		            technicianId: this.payments[index].technician_id
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
		width: 200px !important;
	}
	.time-input{
		float:left;
		margin-right:20px !important;
		display: inline-block;
		width: 150px !important;
		font-size: 18px !important;
	}
</style>