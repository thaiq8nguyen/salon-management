<template>
	<div id="technician-sales">
		<v-row>
			<v-col cols="4" v-for="(technician, index) in technicianSales" :key="index">
				<v-card>
					<v-card-title>{{technician.fullName}}</v-card-title>
					<v-card-text>
						<v-simple-table dense>
							<thead>
							<tr>
								<th>Date</th>
								<th>Sale</th>
								<th>Tip</th>
							</tr>

							</thead>
							<tbody>
							<tr v-for="sale in technician.sales" :key="sale.transactionId">
								<td>{{ sale.date }}</td>

								<td v-for="transaction in sale.transactions" :key="transaction.transactionId">
									$ {{transaction.amount}}
								</td>
							</tr>
							</tbody>
						</v-simple-table>
					</v-card-text>
					<v-card-actions class="d-flex justify-center">
						<v-btn class="success">Pay</v-btn>
					</v-card-actions>
				</v-card>

			</v-col>
		</v-row>

	</div>
</template>

<script>
  export default {
	name: "TechnicianSales",
	data () {
	  return {}
	},
	computed: {
	  selectedPayPeriodId () {
		const payPeriod = this.$store.getters["Payday/selectedPayPeriod"]
		return payPeriod.id
	  },

	  technicianSales () {
		let sales = this.$store.getters["Payday/technicianSales"]
		return sales.map(technician => {
		  return {
			fullName: technician.fullName,
			sales: this.groupBy(technician.sales, "date"),
		  }
		})
	  },
	},
	watch: {
	  selectedPayPeriodId (payPeriodId) {

		this.$store.dispatch("Payday/getTechnicianSales", payPeriodId)
	  },
	},
	methods: {
	  groupBy (array, key) {
		const dates = array.reduce((result, currentValue) => {

		  if (!result[currentValue[key]]) {
			result[currentValue[key]] = []
		  }
		  result[currentValue[key]].push({
			amount: currentValue.creditAmount,
			name: currentValue.name,
			transactionId: currentValue.transactionId,
		  })
		  return result

		}, {})
		return Object.keys(dates).map(key => {
		  return { date: this.$moment(key).format("ddd MM/DD/YYYY"), transactions: dates[key] }
		})

	  },
	},
  }

</script>

<style scoped>

</style>
