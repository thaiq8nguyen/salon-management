<template>
	<div id="pay-period-select">
		<v-card>
			<v-card-text>
				<v-row align="center">
					<v-col cols="3">
						<v-select :items="payPeriods" label="Pay Periods" single-line class = "blue--text"
						          v-model="selectedPayPeriodId" item-text="name" item-value="id" bottom >
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
    props: ['payPeriods'],
	data () {
	  return {

	  }
	},
	computed: {

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
    watch:{

    },
	methods: {

	},
  }

</script>

<style scoped>

</style>
