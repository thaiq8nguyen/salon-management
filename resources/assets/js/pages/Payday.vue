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
					<v-col>
						<earning-details></earning-details>
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
    components: { EarningDetails,  PayPeriodSelect, Technicians  },
	data () {
	  return {}
	},
	computed: {},
	methods: {},
  }

</script>

<style scoped>

</style>
