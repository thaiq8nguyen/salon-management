<template>
	<div id="pay-period-select">
		<v-card>
			<v-card-text>
				<v-select :items="payPeriods" label="Pay Periods" single-line class = "blue--text"
				          v-model="selectPeriodId" item-text="periodName" item-value="id" bottom @input="setPayPeriod">
				</v-select>
			</v-card-text>
		</v-card>
	</div>
</template>

<script>
  export default {
	name: "PayPeriodSelect",
	data () {
	  return {
	    periods:[],
	    selectPeriodId:null
	  }
	},
	computed: {
	  payPeriods(){
	    return this.$store.getters["Payday/payPeriods"]
	  }
	},
    created(){
	  this.$store.dispatch("Payday/getPayPeriods");
    },
	methods: {
	  setPayPeriod(){

	  }
	},
  }

</script>

<style scoped>

</style>
