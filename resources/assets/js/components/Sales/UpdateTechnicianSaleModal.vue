<template>
	<div id="update-technician-sale-dialog">
		<v-dialog v-model="dialog" width="500">
			<v-card>
				<v-card-title class="display-1 grey lighten-2" primary-title>Update Sale & Tip</v-card-title>
				<v-form>
					<v-card-text>
						<v-container>
							<p class="headline">Current Amount</p>
							<v-row>
								<v-col>
									<p>Sale</p>
								</v-col>
								<v-col>
									<p>$ {{ transaction.sales.sale.amount }}</p>
								</v-col>
								<v-col>
									<v-btn color="error" small @click="deleteTransaction('sale')">Delete</v-btn>
								</v-col>
							</v-row>
							<v-row v-if="transaction.sales.tip">
								<v-col>
									<p>Tip</p>
								</v-col>
								<v-col>
									<p>$ {{transaction.sales.tip.amount}}</p>
								</v-col>
								<v-col>
									<v-btn color="error" small @click="deleteTransaction('tip')">Delete</v-btn>
								</v-col>
							</v-row>
						</v-container>
						<v-divider></v-divider>
						<v-container>
							<p class="headline">Update existing sale & tip</p>
							<v-row align="center">
								<v-col cols="4">
									<v-text-field label="Sale" prefix="$" v-model="saleAmount"></v-text-field>
								</v-col>
								<v-col cols="8" class="d-flex justify-start">
									<v-btn color="primary" small @click="updateTransaction('sale')">Update
									</v-btn>
								</v-col>
							</v-row>
							<v-row align="center" v-if="transaction.sales.tip">
								<v-col cols="4">
									<v-text-field label="Tip" prefix="$"
									              v-model.number="updateTipAmount"></v-text-field>
								</v-col>
								<v-col cols="8" class="d-flex justify-start">
									<v-btn color="primary" small @click="updateTransaction('tip')">Update
									</v-btn>
								</v-col>
							</v-row>
						</v-container>
						<div v-if="!transaction.sales.tip">
							<v-divider></v-divider>
							<v-container>
								<p>There is no existing tip, you can add it below</p>
								<v-row align="center">

									<v-col cols="4">
										<ValidationProvider name="Tip amount" :rules="{regex:/^\d*\.?\d*$/,min_value:1}"
										                    v-slot="{errors}">
											<v-text-field :error="errors.length > 0" :error-messages="errors[0]"
											              label="Tip"
											              prefix="$" v-model.number="newTipAmount"></v-text-field>
										</ValidationProvider>

									</v-col>
									<v-col cols="8" class="d-flex justify-start">
										<v-btn color="success" small @click="addTipTransaction">Add</v-btn>
									</v-col>

								</v-row>
							</v-container>
						</div>
					</v-card-text>
					<v-card-actions>
						<v-spacer></v-spacer>
						<v-btn text @click="dialog = false">Close</v-btn>
					</v-card-actions>
				</v-form>

			</v-card>
		</v-dialog>
	</div>
</template>

<script>
  export default {
	name: "UpdateTechnicianSaleModal",
	props: {
	  open:{
	    type: Boolean,
	    default: false
	  },
	  transaction: {
	    type: Object,
	    required: true,

	  }

	},
	data () {
	  return {

		saleAmount: "",
		newTipAmount: "",
		updateTipAmount: "",
		dialog: false,

	  }
	},
	computed: {
	  date () {
		return this.$store.getters["TechnicianSales/date"]
	  },
	  updateSaleTransaction () {
		let result = null
		if (this.saleAmount > 0 && this.saleAmount !== this.transaction.sales.sale.amount) {
		  result = { transactionId: this.transaction.sales.sale.id, amount: this.saleAmount }
		}

		return result

	  },
	  updateTipTransaction () {
		let result = null
		if (this.updateTipAmount > 0 && this.updateTipAmount !== this.transaction.sales.tip.amount) {
		  result = { transactionId: this.transaction.sales.tip.id, amount: this.updateTipAmount }
		}

		return result

	  },
	  newTipTransaction () {
		return [
		  {
			technicianId: this.transaction.technicianId,
			tipAmount: this.newTipAmount,
		  }]
	  },
	},
	watch: {
	  open: function () {

		this.dialog = this.open
	  },
	  dialog: function (val) {
		if (!val) {
		  this.$emit("close")
		}
	  },
	},
	methods: {
	  addTipTransaction () {

		this.$store.dispatch("TechnicianSales/addTechnicianSale",
		  { transactions: this.newTipTransaction, date: this.date }).then(() => {
		  this.newTipAmount = ""
		  this.$emit("close")
		})
	  },
	  updateTransaction (transaction) {

		let updateTransaction = this.updateSaleTransaction
		if (transaction === "tip") {
		  updateTransaction = this.updateTipTransaction
		}

		this.$store.dispatch("TechnicianSales/updateTechnicianSale", updateTransaction).then((response) => {
		  this.updateTipAmount = ""
		  this.saleAmount = ""
		  this.$emit("close")

		})

	  },

	  deleteTransaction (transaction) {
		let deleteTransactionId = this.transaction.sales.sale.id
		if (transaction === "tip") {
		  deleteTransactionId = this.transaction.sales.tip.id
		}
		this.$store.dispatch("TechnicianSales/deleteTechnicianSale", deleteTransactionId).then(() => {
		  this.$emit("close")
		})

	  },

	},
  }

</script>

<style scoped>

</style>
