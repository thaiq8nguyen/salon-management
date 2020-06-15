<template>
	<div id="technicians">
		<p>Technicians</p>
		<v-card>
			<v-card-text>
				<v-list>
					<v-list-item v-for="(technician, index) in technicians" :key="index">
						<v-list-item-content>
							<v-list-item-title>{{technician.fullName}}</v-list-item-title>
						</v-list-item-content>
						<v-list-item-action>
							<v-btn small @click="select(technician.technicianId)">Detail</v-btn>
						</v-list-item-action>
					</v-list-item>
				</v-list>
			</v-card-text>
		</v-card>
	</div>
</template>

<script>
  export default {
	name: "Technicians",
	data () {
	  return {}
	},
	computed: {
	  selectedPayPeriodId () {
		const payPeriod = this.$store.getters["Payday/selectedPayPeriod"]
		return payPeriod.id
	  },

	  technicians () {
		return this.$store.getters["Payday/technicianEarnings"]
	  },
	},
	watch: {
	  selectedPayPeriodId (payPeriodId) {
		this.$store.dispatch("Payday/getAllTechnicianEarnings", payPeriodId);
		this.$store.dispatch("Payday/getAllTechnicianSales", this.selectedPayPeriodId);

	  },
	},
    created(){
	  this.$store.dispatch("Payday/getAllTechnicianEarnings", this.selectedPayPeriodId);
	  this.$store.dispatch("Payday/getAllTechnicianSales", this.selectedPayPeriodId);
	  if(this.technicians.length > 0){
	    this.select(this.technicians[0].technicianId)
	  }
    },
	methods: {
	  groupBy (array, key) {
		const dates = array.reduce((result, currentValue) => {

		  if (!result[currentValue[key]]) {
			result[currentValue[key]] = []
		  }
		  result[currentValue[key]].push({
			amount: currentValue.creditAmount,
			name: currentValue.name,
			transactionId: currentValue.transactionId,
		  })
		  return result

		}, {})
		return Object.keys(dates).map(key => {
		  return { date: this.$moment(key).format("ddd MM/DD/YYYY"), transactions: dates[key] }
		})

	  },
	  select(technicianId){
		this.$store.commit("Payday/SET_SELECTED_TECHNICIAN_ID", technicianId);
	  }

	},
  }

</script>

<style scoped>

</style>
