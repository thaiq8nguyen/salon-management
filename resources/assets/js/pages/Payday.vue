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
					<v-col>Technician Sales Details</v-col>
					<v-col>List of Technicians</v-col>
				</v-row>
			</v-container>
		</v-content>
	</div>
</template>

<script>
	import PayPeriodSelect from "Components/Payday/PayPeriodSelect"
  export default {
	name: "Payday",
    components: { PayPeriodSelect },
	data () {
	  return {}
	},
	computed: {},
	methods: {},
  }

</script>

<style scoped>

</style>
