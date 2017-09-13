<template>
	<div id = "technician-balance-report">
		<v-card v-if="showBalance">
			<template v-for = "balance in balances">
				<v-card-text>
					<v-layout row>
						<v-flex lg8>
							{{ balance.label }}
						</v-flex>
						<v-flex lg4>
							$ {{ balance.value }}
						</v-flex>
					</v-layout>
				</v-card-text>
			</template>
		</v-card>
	</div>
</template>

<script>
    export default {
        props: ['payPeriodId','technicianId'],

        data() {
            return {

	            balances: [],

            }
        },
	    watch:{
            payPeriodId(){

                this.getBalance();

            },

	    },
	    computed:{
            showBalance(){

	            return this.balances.length > 0;
            }
	    },
        methods: {
            getBalance(){

                this.$axios.get('/api/technician-sale/balance/?technicianId=' + this.technicianId + "&payPeriodId="
                    + this.payPeriodId).then(response => {
						console.log(response.data);
						this.balances =  response.data;

                });
            },

        }


    }
</script>

<style>

</style>