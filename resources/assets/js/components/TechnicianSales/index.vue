<template>
	<div id="technician-sales" v-if="stagingSales.length > 0">
		<v-container fluid>
			<v-row :justify="'start'">
				<v-col cols="3" v-for="(technician, index) in technicians.sales" :key="technician.technicianId">
					<v-card>
						<v-card-title class="d-flex justify-space-between">
							<span>{{technician.fullName}}</span>
							<span v-if="technician.sale > 0">

							<v-icon @click="updateDialog = true">mdi-pencil</v-icon>
							<v-icon>mdi-delete</v-icon>
						</span>

						</v-card-title>
						<v-card-text>
							<v-row v-if="technician.sale > 0">
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
		<update-technician-sale-dialog :open="updateDialog" :sale="updatingSale"></update-technician-sale-dialog>
	</div>
</template>

<script>
  import UpdateTechnicianSaleDialog from "Components/TechnicianSales/UpdateTechnicianSaleDialog"

  export default {
	name: "TechnicianSales",
	props: ["technicians", "date"],
    components: {UpdateTechnicianSaleDialog},
	data () {
	  return {
		stagingSales: [],
		saleDate: this.date,
	    updatingSale: "",
		updateDialog: false,
		deleteDialog: false,
	  }
	},
	computed: {},
	watch: {
	  date (newDate) {
		this.saleDate = newDate
	  },
	  technicians (technicians) {
		this.stagingSales = technicians.sales.map(technician => {
		  return {
			technicianId: technician.technicianId,
			saleAmount: technician.sale,
			tipAmount: technician.tip,
		  }
		})
	  },
	},
	methods: {
	  submit () {
		const finalSales = this.stagingSales.filter(stagingSale => {
		  return !this.technicians.sales.some(
			sale => (sale.technicianId === stagingSale.technicianId && sale.sale === stagingSale.saleAmount &&
			  sale.tip === stagingSale.tipAmount))
		})
		//console.log(finalSales)
		this.$store.dispatch("TechnicianSales/addTechnicianSale",
		  { transactions: finalSales, date: this.date }).
		  then(() => {

		  })
	  },
	},
  }

</script>

<style scoped>

</style>
