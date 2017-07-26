<template>
	<v-layout row class = "grey lighten-4">
		<v-flex lg1>
			<v-card flat>
				<v-card-text>
					<i class = "fa fa-calendar fa-4x white--tec"></i>
				</v-card-text>
			</v-card>

		</v-flex>
		<v-flex lg4>
			<v-card flat>
				<v-card-text>
					<h4>Pay Period</h4>
					<p>{{ payPeriod.beginDate + ' - ' + payPeriod.endDate}}</p>
				</v-card-text>
			</v-card>
		</v-flex>
		<v-flex lg4>
			<v-card flat>
				<v-card-text>
					<h4>Pay Date</h4>
					<p>{{ payPeriod.payDate }}</p>
				</v-card-text>
			</v-card>
		</v-flex>
	</v-layout>
</template>

<script>
    export default{



        data(){
            return {
				payPeriod:''
            }
        },

	    mounted(){
            this.getCurrentPayPeriod();
	    },

	    methods:{
            getCurrentPayPeriod(){
                this.$axios.get('/api/pay-period/current').then(response => {
                    this.payPeriod = response.data;
                    this.$emit('period', response.data);
                });
            },
        }
    }


</script>

<style>

</style>