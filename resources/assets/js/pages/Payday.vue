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

					<v-col>
						<technician-sales></technician-sales>
					</v-col>
				</v-row>
			</v-container>
		</v-content>
	</div>
</template>

<script>
	import PayPeriodSelect from "Components/Payday/PayPeriodSelect"
	import TechnicianSales from "Components/Payday/TechnicianSales"

  export default {
	name: "Payday",
    components: {  PayPeriodSelect, TechnicianSales },
	data () {
	  return {}
	},
	computed: {},
	methods: {},
  }

</script>

<style scoped>

</style>
