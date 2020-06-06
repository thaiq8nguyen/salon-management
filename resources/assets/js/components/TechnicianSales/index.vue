<template>
	<div id="technician-sales" v-if="stagingSales.length > 0">
		<v-container fluid>
			<v-row :justify="'start'">
				<v-col cols="3" v-for="(technician, index) in technicians.sales" :key="technician.technicianId">
					<v-card>
						<v-card-title class="d-flex justify-space-between">
							<span>{{technician.fullName}}</span>
							<span v-if="technician.sale">
							<v-icon @click="setUpdatingSale(index)">mdi-pencil</v-icon>

						</span>

						</v-card-title>
						<v-card-text>
							<v-row v-if="technician.sale">
								<v-col>
									<v-list-item>
										<v-list-item-title>Sale</v-list-item-title>
										<v-list-item-subtitle>$ {{stagingSales[index].saleAmount}}
										</v-list-item-subtitle>
									</v-list-item>
									<v-list-item>
										<v-list-item-title>Tip</v-list-item-title>
										<v-list-item-subtitle>$ {{stagingSales[index].tipAmount}}</v-list-item-subtitle>
									</v-list-item>
								</v-col>
							</v-row>
							<v-row v-else>
								<v-col>
									<v-form>
										<ValidationProvider name="Sale" rules="" v-slot="{errors}">
											<v-text-field label="New Sale" prefix="$"
											              v-model.number="stagingSales[index].saleAmount"
											              @focus="clearSaleAmount(index)"
											              @blur="validateSaleAmount(index)"
											></v-text-field>
										</ValidationProvider>

										<v-text-field label="New Tip" prefix="$"
										              v-model.number="stagingSales[index].tipAmount"></v-text-field>
									</v-form>
								</v-col>
							</v-row>
						</v-card-text>
					</v-card>
				</v-col>
			</v-row>
		</v-container>
		<v-toolbar flat class="d-flex justify-center">
			<v-btn @click="submit">Submit</v-btn>
		</v-toolbar>
		<update-technician-sale-modal :open="updateDialog" :transaction="updatingSale"
		                              @close="updateDialog = false"></update-technician-sale-modal>
	</div>
</template>

<script>
  import UpdateTechnicianSaleModal from "Components/TechnicianSales/UpdateTechnicianSaleModal"

  export default {
	name: "TechnicianSales",
	props: ["technicians", "date"],
	components: { UpdateTechnicianSaleModal },
	data () {
	  return {
		updatingSale: "",
		updateDialog: false,
		activeSaleEntry: false,
		stagingSales: [],
	  }
	},
	computed: {

	  newSales () {
		return (this.stagingSales.filter(
		  stagingSale => (!this.technicians.sales.some(
			sale => (sale.technicianId === stagingSale.technicianId && sale.sale === stagingSale.saleAmount &&
			  sale.tip === stagingSale.tipAmount)))))
	  },
	}
	,
	watch: {
	  technicians (technicians) {
		this.stagingSales = technicians.sales.map(technician => ({
		  technicianId: technician.technicianId,
		  saleId: technician.sale ? technician.sale.id : null,
		  tipId: technician.tip ? technician.tip.id : null,
		  saleAmount: technician.sale ? technician.sale.amount : 0,
		  tipAmount: technician.tip ? technician.tip.amount : 0,
		}))
	  },

	},
	methods: {
	  setUpdatingSale (index) {
		this.updatingSale = this.stagingSales[index]
		this.updateDialog = true
	  },
	  submit () {

		this.$store.dispatch("TechnicianSales/addTechnicianSale",
		  { transactions: this.newSales, date: this.date }).
		  then(() => {

		  })
	  },
	  clearSaleAmount (currentEntryIndex) {
		this.activeSaleEntry = true
		//let lastEntryIndex = currentEntryIndex;
		console.log(currentEntryIndex)
		this.stagingSales[currentEntryIndex].saleAmount = ""

		console.log("hey")
	  },
	  validateSaleAmount (currentEntryIndex) {
		if (this.stagingSales[currentEntryIndex].saleAmount === 0) {
		  console.log("Zero!!")
		}
	  },
	},
  }

</script>

<style scoped>

</style>
