<template>
	<v-card class = "elevation-1">
		<v-card-title class = "green darken-1">
			<p class = "headline white--text">Make Payments</p>
		</v-card-title>
		<template v-if="isPaid">
			<v-card-text>
				<h3 class = "headline">{{ isPaidMessage }}</h3>
				<v-btn @click.native="viewPaymentReport" primary>View Reports</v-btn>
			</v-card-text>

		</template>
		<template v-else>
			<v-card-text>
				<payment v-for="(payment,index) in payments" :payment="payment" :index="index" :key="index"
				         @delete="deletePayment"></payment>
				<template v-if="totalPayingAmount > 0">
					<v-chip label v-if="totalPayingAmount > 0" outline class="black--text subheading">Total Paying: $ {{ totalPayingAmount }}</v-chip>
					<v-chip label class ="subheading":class = "paymentGauge.style">{{paymentGauge.text}}</v-chip>
					<v-divider></v-divider>
				</template>
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

	    mounted(){

			this.updateSuggestedPayment();

	    },

	    watch:{
	        technician(){
	            this.payments = [];
	            this.updateSuggestedPayment();
	        }
	    },
	    computed:{
            totalPayingAmount(){
                let sum = 0.0;
                if(this.payments.length > 0){
                    for(let i = 0; i < this.payments.length; i++){
                        sum += parseFloat(this.payments[i].amount);
                    }
                }
                return parseFloat(sum).toFixed(2);
            },
		    paymentGauge(){

                if(this.totalPayingAmount === 0){
                    return{style:'',text: ''};
                }else if(this.totalPayingAmount > 0 && parseFloat(this.totalPayingAmount < this.technician.total_sales_and_tips[0].total)){
                    return{style:'amber darken-1 white--text',text: 'Underpaying'};
                }else if(this.totalPayingAmount === parseFloat(this.technician.total_sales_and_tips[0].total).toFixed(2)){
                    return{style:'green darken-1 white--text',text: 'Right Amount!'};
                }else{
                    return{style:'purple darken-1 white--text',text: 'Overpaying by $ ' +
                    parseFloat(this.totalPayingAmount - parseFloat(this.technician.total_sales_and_tips[0].total)).toFixed(2) };
                }

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

	        updateSuggestedPayment(){
                if(this.technician.suggested_payments.length > 0){
                    for(let i = 0; i < this.technician.suggested_payments.length; i++){
                        this.payments.push(this.technician.suggested_payments[i]);
                    }
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
						this.isPaidMessage =  response.data.message;
						this.$emit('paid');
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