<template>
	<div>
		<v-app id = "technician-payment-report-viewer-app">
			<top-nav-bar></top-nav-bar>
			<main>
				<v-container>
					<v-layout row>
						<v-flex xs12 :style="{height:contentHeight}">
							<v-card>
								<v-card-title>
									<h4>Recent Payment Reports</h4>
									<v-chip label class = "green darken-1 white--text">{{reports.length}} reports available</v-chip>
								</v-card-title>
								<hr>
								<div v-if="reports.length > 0">
									<template v-for="report in reports">
										<v-card-text :key="report.id">
											<v-layout row>
												<v-flex lg2>
													Pay Date: {{ formatDate(report.pay_date) }}
												</v-flex>
												<v-flex lg10>
													<v-btn primary @click="navigate(report.pivot.payment_report_url)">View</v-btn>
												</v-flex>
											</v-layout>
										</v-card-text>
										<hr>
									</template>
								</div>
							</v-card>
						</v-flex>
					</v-layout>
				</v-container>
			</main>
		</v-app>

	</div>
</template>

<script>
    import TopNavBar from "./TechnicianTopNavBar.vue";
    export default {
        props: [],
	    components:{

		    'top-nav-bar':TopNavBar,

	    },
        data() {
            return {
				technicianId: sessionStorage.getItem('technicianId'),
	            reports:[],
	            maxHeight: window.innerHeight,
            }


        },
	    mounted(){
            this.getReports();
	    },
	    computed:{
	        contentHeight(){
	            return this.maxHeight - 10;
	        }

	    },

        methods: {
            getReports(){

                this.$http.get('technician-payment/report/by-technician?technicianId=' + this.technicianId)

	                .then(response => {

                    this.reports = response.data[0].payment_report;
                })
            },

	        navigate(link){
		        sessionStorage.setItem('reportUrl', link);
		        location.href='/technician/reports/payment-report'
	        },

	        formatDate(date){
	            return this.$moment(date,'YYYY-MM-DD').format('MM/DD/YY');
	        }

        }


    }
</script>

<style>
	#technician-payment-report-viewer-app{
		background-color: #2196F3;
	}
</style>