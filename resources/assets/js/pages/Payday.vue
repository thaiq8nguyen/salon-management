<template>
	<div id="payday">
		<v-content>
			<v-container fluid>
				<v-row>
					<v-col>
						<pay-period-select :pay-periods="payPeriods"></pay-period-select>
					</v-col>
				</v-row>
				<v-row v-if="technicians.length > 0">
					<v-col cols="3">
						<technicians :technicians="technicians" v-on:technicianId="selectTechnician"></technicians>
					</v-col>
					<v-col>
						<earning-details v-if="technician" :technician="technician"></earning-details>
					</v-col>
				</v-row>
				<v-row v-else>
					<v-col>
						<v-card>
							<v-card-text class="d-flex justify-center">
								<p class="subtitle-1">There are no technician earnings under this pay period yet</p>
							</v-card-text>
						</v-card>
					</v-col>
				</v-row>
			</v-container>
		</v-content>
	</div>
</template>

<script>
  import PayPeriodSelect from "Components/Payday/PayPeriodSelect"
  import Technicians from "Components/Payday/Technicians"
  import EarningDetails from "Components/Payday/EarningDetails"

  export default {
	name: "Payday",
	components: { EarningDetails, PayPeriodSelect, Technicians },
	data () {
	  return {}
	},
	computed: {
	  payPeriods () {
		return this.$store.getters["Payday/payPeriods"]
	  },
	  selectedPayPeriodId () {
		const payPeriod = this.$store.getters["Payday/selectedPayPeriod"]
		return payPeriod.id
	  },
	  technicians () {
		return this.$store.getters["Payday/technicians"]
	  },
	  technician () {
		return this.$store.getters["Payday/selectedTechnician"]
	  },

	},
	watch: {
	  selectedPayPeriodId (payPeriodId) {
		this.init(payPeriodId)

	  },
	},

	created () {
	  this.$store.dispatch("Payday/getPayPeriods")
	  this.init(this.selectedPayPeriodId)
	},

	methods: {
	  init (payPeriodId) {

		this.$store.dispatch("Payday/getAllTechnicianEarnings", payPeriodId)
		this.$store.dispatch("Payday/getAllTechnicianSales", payPeriodId)
		this.$store.commit("Payday/SET_SELECTED_TECHNICIAN_ID", null)
	  },

	  selectTechnician (technicianId) {
		this.$store.commit("Payday/SET_SELECTED_TECHNICIAN_ID", technicianId)
	  },

	},
  }

</script>

<style scoped>

</style>
