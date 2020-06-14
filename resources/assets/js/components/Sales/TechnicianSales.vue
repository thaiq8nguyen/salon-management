<template>
	<div id="technician-sales">
		<v-container fluid>
			<v-row>
				<v-col cols="3" v-if="techniciansWithSale.length > 0">
					<v-list>
						<v-subheader>Technicians With Sale</v-subheader>
						<v-list-item v-for="(technician, index) in techniciansWithSale" :key="index">
							<v-list-item three-line>
								<v-list-item-content>
									<v-list-item-title>{{technician.fullName}}</v-list-item-title>
									<v-list-item-subtitle>Sale: $ {{technician.sale.amount}}</v-list-item-subtitle>
									<v-list-item-subtitle>Tip: $ {{technician.tip ? technician.tip.amount: "None"}}</v-list-item-subtitle>
								</v-list-item-content>
								<v-list-item-action>
									<v-icon @click="setUpdatingSale(index)">mdi-pencil</v-icon>
								</v-list-item-action>
							</v-list-item>
						</v-list-item>
					</v-list>
				</v-col>
				<v-col>
					<v-row>
						<v-col cols="3" v-for="(technician, index) in stagingSales" :key="index">
							<v-card>
								<v-card-title primary-title class="subtitle-1 grey lighten-2">
									<span>{{technician.fullName}}</span>
								</v-card-title>
								<v-card-text>
									<v-row>
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
												<ValidationProvider name="Tip amount"
												                    :rules="{regex:/^\d*\.?\d*$/,min_value:1}"
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
					<v-toolbar flat class="d-flex justify-center">
						<v-btn color="primary" :disabled="!haveNewTechnicianSales" @click="submit">Submit</v-btn>
					</v-toolbar>
				</v-col>
			</v-row>
		</v-container>

		<update-technician-sale-modal :date="date" :open="updateDialog" :transaction="updatingSale"
		                              @close="updateDialog = false"></update-technician-sale-modal>
	</div>
</template>

<script>
  import UpdateTechnicianSaleModal from "Components/Sales/UpdateTechnicianSaleModal"

  export default {
	name: "TechnicianSales",

	components: { UpdateTechnicianSaleModal },
	data () {
	  return {
		updatingSale: {},
		updateDialog: false,
		activeSaleEntry: false,
		stagingSales: [],

	  }
	},
	computed: {
	  date () {
		return this.$store.getters["TechnicianSales/date"]
	  },
	  allTechnicianSales () {
		return  this.$store.getters["TechnicianSales/allTechnicianSales"]

	  },
	  techniciansWithSale () {
		return this.allTechnicianSales.filter(technician => technician.sales !== null)
	  },
	  techniciansWithoutSale () {
		if (this.allTechnicianSales.length) {
		  return this.allTechnicianSales.filter(technician => technician.sales === null)
		}

	  },
	  haveNewTechnicianSales () {
		return this.stagingSales.some(technician => technician.saleAmount)
	  },

	}
	,
	created () {
	  this.$store.dispatch("TechnicianSales/getAllTechnicianSales", this.date)
	},
	watch: {
	  date(newDate){
		this.$store.dispatch("TechnicianSales/getAllTechnicianSales", newDate)
	  },
	  techniciansWithoutSale (technicians) {
		if (technicians.length > 0) {
		  this.stagingSales = technicians.map(technician => ({
			fullName: technician.fullName,
			technicianId: technician.technicianId,
			saleAmount: "",
			tipAmount: "",
		  }))
		}

	  },
	},
	methods: {
	  setUpdatingSale (index) {
		this.updatingSale = {
		  technicianId: this.techniciansWithSale[index].technicianId,
		  saleId: this.techniciansWithSale[index].sale.id,
		  saleAmount: this.techniciansWithSale[index].sale.amount,
		  tipId: this.techniciansWithSale[index].tip ? this.techniciansWithSale[index].tip.id : null ,
		  tipAmount: this.techniciansWithSale[index].tip ? this.techniciansWithSale[index].tip.amount : null,
		  fullName: this.techniciansWithSale[index].fullName
		}
		this.updateDialog = true
	  },
	  submit () {

		this.$store.dispatch("TechnicianSales/addTechnicianSale",
		  { transactions: this.stagingSales, date: this.date }).
		  then(() => {

		  })
	  },
	  filteringKey (event) {

		let charCode = event.keyCode
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
