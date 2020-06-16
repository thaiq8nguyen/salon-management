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
								<v-col>Total Sale:</v-col>
								<v-col>${{technician.earning.totalSale}}</v-col>
							</v-row>
							<v-row>
								<v-col>Total Tip:</v-col>
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
					<v-col>
						<p class="subtitle-2">Payments</p>
						<payment @payment="addPayment" :payment-methods="paymentMethods"></payment>
					</v-col>
					<v-col>
						<p class="subtitle-2">Payment List</p>
						<v-list dense>
							<v-list-item v-for="(payment, index) in payments" :key="index" three-line>
								<v-list-item-content>
									<v-list-item-title>Payment # {{index + 1}}</v-list-item-title>
									<v-list-item-subtitle>
										<v-row>
											<v-col>Amount: ${{payment.amount}}</v-col>
											<v-col>By: {{payment.method}}</v-col>
										</v-row>
									</v-list-item-subtitle>
									<v-list-item-subtitle>Ref: {{payment.reference}}</v-list-item-subtitle>
								</v-list-item-content>
								<v-list-item-action>
									<v-btn small @click="deletePayment(index)">Delete</v-btn>
								</v-list-item-action>
							</v-list-item>
						</v-list>
					</v-col>
				</v-row>
			</v-card-text>
		</v-card>
	</div>
</template>

<script>
  import Payment from "./Payment"

  export default {
	name: "EarningDetails",
	props: ["technician"],
	components: { Payment },

	data () {
	  return {
		numberOfPayments: 2,
		payments: [],
	  }
	},
	computed: {
	  paymentMethods () {
		return this.$store.getters["paymentMethods"]
	  },
	  payPeriod () {
		return this.$store.getters["Payday/selectedPayPeriod"]
	  },
	  totalWage () {
		const { saleWage, tipWage } = this.technician.earning
		return saleWage + tipWage
	  },
	},
	methods: {
	  addPayment (payment) {
		this.payments.push(payment)
	  },
	  deletePayment (paymentIndex) {
		this.payments.splice(paymentIndex, 1)
	  },
	  pay () {
		/*
		{
			technicianId: 1,
			payPeriodId: 1.
			payments: [
				{
					amount: 5,
					methodId: 1,
					reference: 123
				}
			]
		}
		 */

		let paymentPackage = {
		  technicianId: this.technician.earning.technicianId,
		  payPeriodId: this.payPeriod.id,
		  payments: this.payments,
		}
	  },
	},
  }

</script>

<style scoped>

</style>
