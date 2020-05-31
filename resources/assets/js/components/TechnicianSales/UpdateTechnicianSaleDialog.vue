<template>
	<div id="update-technician-sale-dialog">
		<v-dialog v-model="open" width="500">
			<v-card>
				<v-card-title>Update</v-card-title>
				<v-form>
					<v-card-text>
						<v-row>
							<v-col>
								<h3>Current Sale & Tip</h3>
								<v-list-item>
									<v-list-item-title>Sale</v-list-item-title>
									<v-list-item-subtitle>$ {{sale.saleAmount}}</v-list-item-subtitle>
								</v-list-item>
								<v-list-item>
									<v-list-item-title>Tip</v-list-item-title>
									<v-list-item-subtitle>$ {{sale.tipAmount}}</v-list-item-subtitle>
								</v-list-item>
							</v-col>
							<v-col>
								<h3>New Sale & Tip</h3>
								<v-list>
									<v-list-item>
										<v-list-item-content>
											<v-text-field label="Sale"
											              v-model.number="updating.saleAmount"></v-text-field>
										</v-list-item-content>
										<v-list-item-action>
											<v-btn small>Update</v-btn>
										</v-list-item-action>
									</v-list-item>
									<v-list-item>
										<v-list-item-content>
											<v-text-field label="Tip"
											              v-model.number="updating.tipAmount"></v-text-field>
										</v-list-item-content>
										<v-list-item-action>
											<v-btn small>Update</v-btn>
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
	props: ["open", "sale"],
	data () {
	  return {
		saleId: "",
		updating: {

		  saleAmount: "",
		  tipAmount: "",
		},

	  }
	},
	computed: {},
	watch: {
	  sale (sale) {
		this.saleId = sale.saleId
	  },

	},
	methods: {
	  update () {
		this.$store.dispatch("Technicians/updateTechnician", { saleId: this.saleId, sale: this.updating })

	  },

	},
  }

</script>

<style scoped>

</style>
