<template>
	<div>
		<v-card >
			<v-card-title class = "green">
				<h3 class = "headline white--text">Redeem Certificate</h3>
			</v-card-title>
			<v-card-text>
				<v-form>
					<v-layout>
						<v-flex lg8>
                            <v-form>
                                <v-text-field label="Amount"
                                              prefix="$"
                                              v-model="certificate.amount"
                                              v-validate="'required|decimal'"
                                              :error-messages="errors.collect('amount')"
                                              required
                                              data-vv-name="amount"

                                ></v-text-field>
                                <v-btn color="success" @click="validate">{{ redeemButtonText }}</v-btn>

                            </v-form>
						</v-flex>
					</v-layout>
				</v-form>
			</v-card-text>
			<v-card-text>
				<v-alert :type="alert.status" v-model="alert.show" dismissible>{{ alert.message }}</v-alert>
			</v-card-text>
		</v-card>
	</div>


</template>
<script>

    export default {

        props:['date'],

        data() {
            return {

				alert:{

                    show:false,
					status: null,
					message: null
				},

	            certificate:{

                    amount:null,
		            date:this.$moment().format('YYYY-MM-DD')

	            },

                //vee-validate custom message
                dictionary:{
                    custom:{
                        amount:{
                            required: 'Amount is required',
                            decimal: 'Amount must be a number'


                        }

                    }
                },

                //redeem button text
	            redeemButtonText:'Redeem',

            }
        },
        mounted(){

            this.$validator.localize('en', this.dictionary);

        },
	    watch:{
			date:function(){
			    this.certificate.date = this.date;
			    this.alert.show = false;
			}
	    },
        methods:{
            redeem(){
                this.redeemButtonText='Please wait...';
                this.$axios.post('/api/salon-sale/redeem-gift-certificate', this.certificate).then(response => {
                    if (response.data.success) {
                        this.alert.status = 'success';
                        this.alert.message = response.data.message;
                        this.alert.show = true;
                        this.reset();
                        this.$emit('redeemed');
                    }
                    else {
                        this.alert.status = 'error';
                        this.alert.message = 'Server errors';
                        this.alert.show = true;
                    }
                    this.redeemButtonText='Redeem';
                }

                ).catch(error => {
                    if (error.response) {
                        console.log(error.response.data);
                        this.alert.status = 'error';
                        this.alert.message = 'Input errors';
                        this.alert.show = true;
                    }
                });
            },


            validate(){
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        this.redeem();
                    }

                });
            },
	        reset(){
                this.certificate.amount = null;
                this.$validator.reset();
	        }


        }

    }
</script>

<style>

</style>