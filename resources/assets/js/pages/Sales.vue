<template>
	<div id="sales">
		<v-content>
			<v-container>
				<v-row>
					<v-col>
						<date-picker v-on:date="setDate"></date-picker>
					</v-col>
					<v-col>

					</v-col>
				</v-row>
				<v-row>
					<v-col>
						<technician-sales :technicians="technicianSales"></technician-sales>
					</v-col>
				</v-row>
			</v-container>
		</v-content>
	</div>
</template>

<script>
  import DatePicker from "Components/DatePicker"
  import TechnicianSales from "Components/TechnicianSales"


  export default {
	name: "Sales",
	components: { TechnicianSales, DatePicker },
	props: [],

	data () {
	  return {
		date: "2020-05-24"//this.$moment().format("YYYY-MM-DD"),
	  }

	},
	computed: {
	  technicianSales () {
		return this.$store.getters["TechnicianSales/technicianSales"]
	  },
	},
	created () {
	  this.$store.dispatch("TechnicianSales/getTechnicianSales", this.date)
	},
	watch: {
	  date: function (val) {
		this.$store.dispatch("TechnicianSales/getTechnicianSales", val)
	  },
	},
	methods: {
	  setDate (date) {
		this.date = date
	  },
	},

  }
</script>

<style>

</style>
