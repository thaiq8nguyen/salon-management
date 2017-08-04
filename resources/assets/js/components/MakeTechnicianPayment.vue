<template>
	<v-card class = "elevation-1">
		<v-card-title class = "green darken-1">
			<p class = "headline white--text">Make Payments</p>
		</v-card-title>
		<template v-if="isPaid">
			<v-card-text>
				<h3 class = "headline">{{ isPaidMessage }}</h3>
			</v-card-text>
			<v-card-actions>
				<v-btn @click.native="viewPaymentReport" primary>View Report</v-btn>
			</v-card-actions>
		</template>
		<template v-else>
			<v-card-text>
				<payment v-for="(payment,index) in payments" :payment="payment" :index="index" :key="index"
				         @delete="deletePayment"></payment>
				<v-chip label v-if="totalPayingAmount > 0"
				        :class="{['green darken-1 white--text subheading']:totalPayingAmount == technician.total_sales_and_tips[0].total}">
					Total Paying: $ {{ totalPayingAmount }}
				</v-chip>
				<v-divider v-if="payments.length > 0"></v-divider>
				<technician-payment-form @add="addPayment"></technician-payment-form>
			</v-card-text>
			<v-divider></v-divider>
			<v-card-actions v-if="payments.length > 0">
				<v-btn @click.native="makePayment(technician.id)"  primary>Make Payment</v-btn>
			</v-card-actions>
		</template>

	</v-card>
</template>

<script>
    import TechnicianPaymentForm from './TechnicianPaymentForm.vue';
    import Payment from './TechnicianPayment.vue';

    export default {
        props: ['technician', 'periodId', 'index'],
		components:{
            TechnicianPaymentForm, Payment,
		},
        data() {
            return {
                payments: [],
                maxPayment: 3,
	            isPaid:false,
	            isPaidMessage: null,
            }


        },
	    computed:{
            totalPayingAmount(){
                let sum = 0;
                if(this.payments.length > 0){
                    for(let i = 0; i < this.payments.length; i++){
                        sum += parseInt(this.payments[i].amount);
                    }
                }
                return sum;
            }
	    },
        methods: {
            addPayment(payment) {
                if(this.payments.length < this.maxPayment){
                    this.payments.push({
                        amount:payment.amount,
                        reference:payment.reference,
                        method:payment.method,
                    });
                }
            },

            deletePayment(index){
                this.payments.splice(index, 1);
            },

            makePayment(technicianId){

                this.$axios.post('/api/technician-wage/pay',{payingTechnicianId: technicianId,
					periodId: this.periodId, payments: this.payments}).then(response => {
					if(response.data.success){
						this.isPaid = true;
						this.isPaidMessage =  response.data.message
					}
				});
            },
            viewPaymentReport(){
				window.location.href='/report/'+ this.technician.first_name + '/payment/' + this.periodId
            },
        }
    }
</script>

<style>

</style>