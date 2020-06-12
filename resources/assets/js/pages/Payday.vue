<template>
	<div id="payday">
		<v-content>
			<v-container fluid>
				<v-row>
					<v-col>
						<pay-period-select></pay-period-select>
					</v-col>
				</v-row>
				<v-row>
					<v-col cols="3">
						<technicians></technicians>
					</v-col>
				</v-row>
			</v-container>
		</v-content>
	</div>
</template>

<script>
	import PayPeriodSelect from "Components/Payday/PayPeriodSelect"
	//import TechnicianSales from "Components/Payday/TechnicianSales"
	import Technicians from "Components/Payday/Technicians"

  export default {
	name: "Payday",
    components: {  PayPeriodSelect, Technicians  },
	data () {
	  return {}
	},
	computed: {},
	methods: {},
  }

</script>

<style scoped>

</style>
