<template>
	<div id = "technician-balance-report">
		<v-card v-if="showBalance">
			<v-card-text>
				<v-layout row>
					<v-flex lg8>
						Period Balance:
					</v-flex>
					<v-flex lg4>
						$ {{ payPeriodBalance.period_balance}}
					</v-flex>
				</v-layout>
			</v-card-text>
			<v-card-text>
				<v-layout row>
					<v-flex lg8>
						Total Balance:
					</v-flex>
					<v-flex lg4>
						$ {{ totalBalance.total_balance}}
					</v-flex>
				</v-layout>
			</v-card-text>
		</v-card>
	</div>
</template>

<script>
    export default {
        props: ['payPeriodId','firstName'],

        data() {
            return {
				payPeriodBalance:null,
	            totalBalance:null,
	            id:null,
	            name:null,
	            balances:false,

            }
        },
	    watch:{
            payPeriodId(){

                this.getBalance();

            },
		    firstName(){

                this.getBalance();

		    }
	    },
	    computed:{
            showBalance(){
                return this.payPeriodBalance !== null && this.totalBalance !== null
            }
	    },
        methods: {
            getBalance(){
                this.$axios.get('/api/technician-payment/balance/pay-period/' + this.payPeriodId + '/technician/'
                    + this.firstName).then(response => {
                    this.payPeriodBalance = response.data.pay_period_balance;
                    this.totalBalance = response.data.total_balance;
                });
            },
        }


    }
</script>

<style>

</style>