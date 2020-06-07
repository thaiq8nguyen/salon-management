<template>
	<div id="update-technician-sale-dialog">

		<v-dialog v-model="dialog" width="500">
			<v-card>
				<v-card-title class="headline grey lighten-2" primary-title>Update Sale & Tip</v-card-title>
				<v-form>
					<v-card-text>
						<v-row>
							<v-col>
								<h3>Current</h3>
								<v-list>
									<v-list-item>
										<v-list-item-content class="d-flex">
											<v-list-item-title>Sale</v-list-item-title>
											<v-list-item-subtitle>$ {{transaction.saleAmount}}</v-list-item-subtitle>
										</v-list-item-content>
										<v-list-item-action>
											<v-btn color="error" small @click="deleteTransaction('sale')">Delete</v-btn>
										</v-list-item-action>

									</v-list-item>
									<v-list-item v-show="transaction.tipAmount">
										<v-list-item-content>
											<v-list-item-title>Tip</v-list-item-title>
											<v-list-item-subtitle>$ {{transaction.tipAmount}}</v-list-item-subtitle>

										</v-list-item-content>

										<v-list-item-action>
											<v-btn color="error" small @click="deleteTransaction('tip')">Delete</v-btn>
										</v-list-item-action>

									</v-list-item>
								</v-list>
							</v-col>
						</v-row>
						<v-divider></v-divider>
						<v-row>
							<v-col>
								<h3>Update existing sale & tip</h3>
								<v-list>
									<v-list-item>
										<v-list-item-content>
											<v-text-field label="Sale" v-model="saleAmount"></v-text-field>
										</v-list-item-content>
										<v-list-item-action>
											<v-btn color="primary" small @click="updateTransaction('sale')">Update
											</v-btn>
										</v-list-item-action>
									</v-list-item>
									<v-list-item v-show="transaction.tipId">
										<v-list-item-content>
											<v-text-field label="Tip" v-model.number="updateTipAmount"></v-text-field>
										</v-list-item-content>
										<v-list-item-action>
											<v-btn color="primary" small @click="updateTransaction('tip')">Update
											</v-btn>
										</v-list-item-action>
									</v-list-item>
								</v-list>
							</v-col>
						</v-row>
						<div v-show="!transaction.tipId">
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
	props: ["date", "open", "transaction"],
	data () {
	  return {

		saleAmount: "",
		newTipAmount: "",
		updateTipAmount: "",
		dialog: false,

	  }
	},
	computed: {
	  saleTransaction () {
		let result = null
		if (this.saleAmount > 0 && this.saleAmount !== this.transaction.saleAmount) {
		  result = { transactionId: this.transaction.saleId, amount: this.saleAmount }
		}

		return result

	  },
	  updateTipTransaction () {
		let result = null
		if (this.updateTipAmount > 0 && this.updateTipAmount !== this.transaction.tipAmount) {
		  result = { transactionId: this.transaction.tipId, amount: this.updateTipAmount }
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
	    console.log(transaction)
		let updateTransaction = this.saleTransaction
		if (transaction === "tip") {
		  updateTransaction = this.updateTipTransaction
		}

		this.$store.dispatch("TechnicianSales/updateTechnicianSale", updateTransaction).then(() => {
		  this.updateTipAmount = ""
		  this.$emit("close")
		})

	  },

	  deleteTransaction (transaction) {
		let deleteTransactionId = this.transaction.saleId
		if (transaction === "tip") {
		  deleteTransactionId = this.transaction.tipId
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
