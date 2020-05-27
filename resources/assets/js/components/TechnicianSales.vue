<template>
	<div id="technician-sales">
		<v-container fluid>
			<v-row :justify="'start'">
				<v-card v-for="technician in technicians.sales" :key="technician.technicianId" width="344"
				        class="mr-3 mb-3">
					<v-card-title class="d-flex justify-space-between">
						<span>{{technician.fullName}}</span>
						<span v-if="technician.sale > 0">

							<v-icon>mdi-pencil</v-icon>
							<v-icon>mdi-delete</v-icon>
						</span>

					</v-card-title>
					<v-card-text>
						<v-row v-if="technician.sale > 0">
							<v-col>
								<v-list-item two-line>
									<v-list-item-content>
										<v-list-item-title>Sale</v-list-item-title>
										<v-list-item-subtitle>$ {{technician.sale}}</v-list-item-subtitle>
									</v-list-item-content>
								</v-list-item>


							</v-col>
							<v-col>
								<v-list-item two-line>
									<v-list-item-content>
										<v-list-item-title>Tip</v-list-item-title>
										<v-list-item-subtitle>$ {{technician.tip}}</v-list-item-subtitle>
									</v-list-item-content>
								</v-list-item>
							</v-col>
						</v-row>
						<v-row v-else>
							<v-col>
								<v-form>
									<v-text-field label="New Sale" v-model="technicianSale.sale"></v-text-field>
									<v-text-field label="New Tip" v-model="technicianSale.tip"></v-text-field>
									<span class="d-flex flex-row-reverse">
										<v-btn small @click="add(technician.technicianId)">Submit</v-btn>
									</span>

								</v-form>
							</v-col>
						</v-row>
					</v-card-text>
				</v-card>
			</v-row>
		</v-container>
	</div>
</template>

<script>
  export default {
	name: "TechnicianSales",
	props: ["technicians", "date"],
	data () {
	  return {
		technicianSale: {

		  sale: "",
		  tip: "",
		},
		saleDate: this.date,
	  }
	},
	computed: {},
	watch: {
	  date (newDate) {
		this.saleDate = newDate
	  },
	},
	methods: {
	  add (technicianId) {

		this.$store.dispatch("TechnicianSales/addTechnicianSale",
		  { technicianId, transactions: this.technicianSale, date: this.date }).
		  then(() => {

		  })
	  },
	},
  }

</script>

<style scoped>

</style>
