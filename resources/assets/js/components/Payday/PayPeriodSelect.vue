<template>
	<div id="pay-period-select">
		<v-card>
			<v-card-text>
				<v-row align="center">
					<v-col cols="3">
						<v-select :items="payPeriods" label="Pay Periods" single-line class = "blue--text"
						          v-model="selectedPayPeriodId" item-text="periodName" item-value="id" bottom>
						</v-select>
					</v-col>
					<v-col class="d-flex justify-center">
						<p class="subtitle-1">Pay Date: <span>{{ selectedPayPeriod.payDate }}</span></p>
					</v-col>
				</v-row>

			</v-card-text>
		</v-card>
	</div>
</template>
<script>
  export default {
	name: "PayPeriodSelect",
	data () {
	  return {

	  }
	},
	computed: {
	  payPeriods(){
	    return this.$store.getters["Payday/payPeriods"]
	  },
	  selectedPayPeriod(){
	    return this.$store.getters["Payday/selectedPayPeriod"];
	  },
	  selectedPayPeriodId:{
	    get(){
		  return this.selectedPayPeriod.id
	    },
	    set(newPayPeriodId){
			this.$store.commit("Payday/SET_PAY_PERIOD", newPayPeriodId)
	    }

	  }
	},
    created(){
	  this.$store.dispatch("Payday/getPayPeriods");
    },
    watch:{

    },
	methods: {
	  setPayPeriod(){
		//console.log(this.selectedPayPeriodId)
	  }
	},
  }

</script>

<style scoped>

</style>
