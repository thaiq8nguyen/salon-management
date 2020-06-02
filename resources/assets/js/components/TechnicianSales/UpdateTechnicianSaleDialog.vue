<template>
	<div id="update-technician-sale-dialog">
		<v-dialog v-model="open" width="500">
			<v-card>
				<v-card-title>Update Sale & Tip</v-card-title>
				<v-form>
					<v-card-text>
						<v-row>
							<v-col cols="4">
								<h3>Current</h3>
								<v-list-item>
									<v-list-item-title>Sale</v-list-item-title>
									<v-list-item-subtitle>$ {{transaction.saleAmount}}</v-list-item-subtitle>
								</v-list-item>
								<v-list-item>
									<v-list-item-title>Tip</v-list-item-title>
									<v-list-item-subtitle>$ {{transaction.tipAmount}}</v-list-item-subtitle>
								</v-list-item>
							</v-col>
						</v-row>
						<v-row>
							<v-col>
								<h3>New</h3>
								<v-list>
									<v-list-item>
										<v-list-item-content>
											<v-text-field label="Sale" v-model="saleAmount"></v-text-field>
										</v-list-item-content>
										<v-list-item-action>
											<v-list-item-group>
												<v-btn small style="margin-right: 5px" @click="update('sale')">Update</v-btn>
												<v-btn small>Delete</v-btn>
											</v-list-item-group>
										</v-list-item-action>
									</v-list-item>
									<v-list-item>
										<v-list-item-content>
											<v-text-field label="Tip" v-model="tipAmount"></v-text-field>
										</v-list-item-content>
										<v-list-item-action>
											<v-list-item-group>
												<v-btn small style="margin-right: 5px" @click="update('tip')">Update</v-btn>
												<v-btn small>Delete</v-btn>
											</v-list-item-group>
										</v-list-item-action>
									</v-list-item>
								</v-list>
							</v-col>
						</v-row>
					</v-card-text>
				</v-form>

			</v-card>
		</v-dialog>
	</div>
</template>

<script>
  export default {
	name: "UpdateTechnicianSaleDialog",
	props: ["open", "transaction"],
	data () {
	  return {

		saleAmount: "",
		tipAmount: "",

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
	  tipTransaction () {
		let result = null
		if (this.tipAmount > 0 && this.tipAmount !== this.transaction.tipAmount) {
		  result = { transactionId: this.transaction.tipId, amount: this.tipAmount }
		}

		return result

	  },

	},
	methods: {
	  update (transaction) {
		let updateTransaction = this.saleTransaction;
		if(transaction === "tip"){
		  updateTransaction = this.tipTransaction
		}
		//console.log(transactions);
		this.$store.dispatch("TechnicianSales/updateTechnicianSale", updateTransaction).then(() => {
		  this.$emit("close")
		})

	  },

	},
  }

</script>

<style scoped>

</style>
