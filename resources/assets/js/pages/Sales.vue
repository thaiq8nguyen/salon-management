<template>
	<div id="sales">
		<v-content>
			<v-container fluid>
				<v-row justify="center">
					<v-col md="3">
						<date-picker v-on:date="setDate"></date-picker>
					</v-col>
					<v-col>

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
  import DatePicker from "Components/DatePicker"
  import TechnicianSales from "Components/Sales/TechnicianSales"

  export default {
	name: "Sales",
	components: { TechnicianSales, DatePicker },


	data () {
	  return {}

	},

	created () {
	  this.$store.dispatch("TechnicianSales/setDate", this.$moment().format("YYYY-MM-DD"))
	},

	methods: {
	  setDate (date) {
		this.$store.dispatch("TechnicianSales/setDate", date)
	  },
	},

  }
</script>

<style>

</style>
