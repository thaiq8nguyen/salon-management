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
										<v-text-field label="New Sale"
										              v-model.number="stagingSales[index].saleAmount"></v-text-field>
										<v-text-field label="New Tip"
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
	  }
	},
	computed: {

	  stagingSales () {
		return (this.technicians.sales.map(technician => ({
		  technicianId: technician.technicianId,
		  saleId: technician.sale ? technician.sale.id : null,
		  tipId: technician.tip ? technician.tip.id : null,
		  saleAmount: technician.sale ? technician.sale.amount : 0,
		  tipAmount: technician.tip ? technician.tip.amount : 0,
		})))
	  },
	  newSales () {
		return (this.stagingSales.filter(
		  stagingSale => (!this.technicians.sales.some(
			sale => (sale.technicianId === stagingSale.technicianId && sale.sale === stagingSale.saleAmount &&
			  sale.tip === stagingSale.tipAmount)))))
	  },
	}
	,
	watch: {},
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
	},
  }

</script>

<style scoped>

</style>
