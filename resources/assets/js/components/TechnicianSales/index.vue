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
										<ValidationProvider name="Sale amount"
										                    :rules="{regex:/^\d*\.?\d*$/,min_value:1}"
										                    v-slot="{errors}">
											<v-text-field :error="errors.length > 0" :error-messages="errors[0]"
											              label="New Sale" prefix="$"
											              v-model.number="stagingSales[index].saleAmount"
											              @keypress="filteringKey"


											></v-text-field>
										</ValidationProvider>
										<ValidationProvider name="Tip amount" :rules="{regex:/^\d*\.?\d*$/,min_value:1}"
										                    v-slot="{errors}">
											<v-text-field :error="errors.length > 0" :error-messages="errors[0]"
											              label="New Tip" prefix="$"
											              v-model.number="stagingSales[index].tipAmount"></v-text-field>
										</ValidationProvider>

									</v-form>
								</v-col>
							</v-row>
						</v-card-text>
					</v-card>
				</v-col>
			</v-row>
		</v-container>
		<v-toolbar flat class="d-flex justify-center">
			<v-btn color="primary" @click="submit" :disabled="newSales.length === 0">Submit</v-btn>
		</v-toolbar>
		<update-technician-sale-modal :date="date" :open="updateDialog" :transaction="updatingSale"
		                              @close="updateDialog = false"></update-technician-sale-modal>
	</div>
</template>

<script>
  import UpdateTechnicianSaleModal from "Components/TechnicianSales/UpdateTechnicianSaleModal"

  export default {
	name: "TechnicianSales",

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
	  date () {
		return this.$store.getters["TechnicianSales/date"]
	  },
	  technicians () {
		return this.$store.getters["TechnicianSales/allTechnicianSales"]
	  },


	  newSales () {
		return (this.stagingSales.filter(
		  stagingSale => (!this.technicians.sales.some(
			sale => (sale.technicianId === stagingSale.technicianId && sale.sale === stagingSale.saleAmount &&
			  sale.tip === stagingSale.tipAmount)))))
	  },
	}
	,
	created () {
	  this.$store.dispatch("TechnicianSales/getAllTechnicianSales", this.date)
	},
	watch: {
	  technicians:{
	    handler(technicians){
		  this.stagingSales = technicians.sales.map(technician => ({
			technicianId: technician.technicianId,
			saleId: technician.sale ? technician.sale.id : null,
			tipId: technician.tip ? technician.tip.id : null,
			saleAmount: technician.sale ? technician.sale.amount : null,
			tipAmount: technician.tip ? technician.tip.amount : null,
		  }))
	    },
	    deep: true
	  }
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
	  filteringKey (event) {
		let charCode = (typeof event.which == "number") ? event.which : event.keyCode
		if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46 && charCode !== 127) {
		  event.preventDefault()
		} else {
		  return true

		}
	  },
	},
  }

</script>

<style scoped>

</style>
