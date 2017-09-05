<template>
	<div>
		<v-app>
			<v-container fluid>
				<v-layout>
					<v-flex lg4>
						<v-card flat>
							<v-card-text>
								<v-select :items="technicians" v-model="selectTechnician"
								          item-value="id" item-text="first_name"
								          label="Select Technician" autocomplete
								>
									<template slot = "item" scope = "data">
										{{ data.item.first_name + ' ' + data.item.last_name }}
									</template>

								</v-select>
							</v-card-text>
						</v-card>
						<v-card flat v-if="reports">
							<v-card-text>
								<v-list>
									<template v-for="(report,index) in reports">
										<v-layout row>
											<v-flex lg12>
												<v-card tile>
													<v-card-text>
														<v-layout row>
															<v-flex lg6>
																Pay Date: {{ formatDate(report.pay_date) }}
															</v-flex>
															<v-flex lg6>
																Period: {{ formatDate(report.begin_date) + ' to ' + formatDate(report.end_date) }}
															</v-flex>
															<v-flex lg4 mt-2>
																<v-btn class = "green darken-1 white--text "@click="reportSrc =  report.pivot.payment_report_url">View</v-btn>
															</v-flex>
														</v-layout>
													</v-card-text>
												</v-card>
											</v-flex>
										</v-layout>
									</template>
								</v-list>
							</v-card-text>
						</v-card>
					</v-flex>
					<v-flex lg8>
						<iframe :src = "reportSrc" style="width:100%; height:800px;" frameborder="5px" v-if="reportSrc"></iframe>
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

	            technicians:[],
	            selectTechnician:null,
				technician:null,
	            reports: null,
	            reportSrc:null,

            }


        },
	    mounted(){

            this.getReports();

	    },
	    watch:{
	        selectTechnician(){
	            this.technician = this.technicians.find(this.findTechnician);
		        this.reports = this.technician.payment_report;

	        }
	    },
        methods: {
			getReports(){

			    this.$http.get('/technician-payment/report/show-all').then(response => {
					this.technicians = response.data;
			        console.log(response.data);

			    });
			},

	        findTechnician(technician){
				return technician.id === this.selectTechnician;
	        },

	        formatDate(date){

	            return this.$moment(date,'YYYY-MM-DD').format('MM/DD/YY');
	        }
        }


    }
</script>

<style>

</style>