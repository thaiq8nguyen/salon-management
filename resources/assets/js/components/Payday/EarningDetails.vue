<template>
	<div id="earning-details">
		<p>Earning Details</p>
		<v-card>
			<v-card-text>
				<v-row>
					<v-col cols="6" class="mr-3">
						<p class="subtitle-2">Sales</p>
						<v-container fluid>
							<v-row>
								<v-col>
									<v-simple-table dense>
										<thead>
										<tr>
											<th>Date</th>
											<th>Sale</th>
											<th>Tip</th>
										</tr>
										</thead>
										<tbody>
										<tr v-for="sale in technician.sales">
											<td>{{ sale.date }}</td>
											<td v-for="transaction in sale.transactions">
												<span :key="transaction.transactionId">${{transaction.amount}}</span>
											</td>
										</tr>
										</tbody>
									</v-simple-table>
								</v-col>
							</v-row>
						</v-container>
					</v-col>
					<v-col cols="4">
						<p class="subtitle-2">Earning</p>
						<v-container fluid>
							<v-row>
								<v-col>Total Sale: </v-col>
								<v-col>${{technician.earning.totalSale}}</v-col>
							</v-row>
							<v-row>
								<v-col>Total Tip: </v-col>
								<v-col>${{technician.earning.totalTip}}</v-col>
							</v-row>
							<v-row>
								<v-col>
									Sale Wage:
								</v-col>
								<v-col>
									${{technician.earning.saleWage}}
								</v-col>
							</v-row>
							<v-row>
								<v-col>
									Tip Wage:
								</v-col>
								<v-col>
									${{technician.earning.tipWage}}
								</v-col>
							</v-row>
							<v-row>
								<v-col>Total Wage:</v-col>
								<v-col>${{ totalWage }}</v-col>
							</v-row>
						</v-container>
					</v-col>
				</v-row>
				<v-row>
					<v-col cols="6">
						<p class="subtitle-2">Payments</p>
						<v-container>
							<v-row>
								<v-col></v-col>
							</v-row>
						</v-container>
					</v-col>
				</v-row>
			</v-card-text>
		</v-card>
	</div>
</template>

<script>
  export default {
	name: "EarningDetails",
    props: ["technician"],
	data () {
	  return {}
	},
	computed: {

	  totalWage(){
	    const {saleWage, tipWage} = this.technician.earning;
		return saleWage + tipWage;
	  }
	},
	methods: {},
  }

</script>

<style scoped>

</style>
