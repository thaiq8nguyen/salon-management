<template>
	<div>
		<v-card>
			<v-card-title class = "display-1 green darken-1 white--text" v-text="title">

			</v-card-title>
			<v-card-text>
				<v-layout row>
					<v-flex lg5 md5>
						<v-subheader class = "headline">Amount: </v-subheader>
					</v-flex>
					<v-flex lg6 md6>
						<v-text-field prepend-icon="attach_money"
						              v-model="amount"
						              id = "amount-input" type="tel"
						              @keypress="numberFilter"
						              maxlength="3">

						</v-text-field>
						<p class="red--text darken-1 subheading" v-if="amountError">
							The amount is greater than the certificate value
						</p>
					</v-flex>
				</v-layout>
				<v-layout row>
					<v-flex lg5 md5>
						<v-subheader class = "headline">Comments: </v-subheader>
					</v-flex>
					<v-flex lg6 md6>
						<v-text-field prepend-icon="comment" v-model="comments"></v-text-field>
					</v-flex>
				</v-layout>
			</v-card-text>
			<v-card-text>
				<v-btn @click.native="useCertificate" primary large>Use</v-btn>
				<v-btn @click.native="cancel" large>Cancel</v-btn>
			</v-card-text>
		</v-card>
	</div>
</template>

<script>


    export default {
        components: {},
        props: ['gift','title'],

	    computed:{
            amountError(){
                if(this.amount){
                    return this.amount > this.gift.amount;
                }

            }
	    },

        data() {
            return {
				amount:null,
	            comments:null,
            }
        },
        methods: {
            useCertificate(){
				if(!this.amountError){
                    this.$axios.post('/api/gift-certificate/use',{id: this.gift.id,
	                    detail: {amount: this.amount, comments: this.comments}}).
                    then(response =>{
                        if(response.data.success){
                            this.amount = null;
                            this.comments = null;
                            this.$emit('completed',response.data.amount);
                        }

                    });
				}
            },
	        cancel(){
                this.$emit('cancel');
	        },

	        numberFilter(event){
                let charCode = (typeof event.which == "number") ? event.which : event.keyCode;
                if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46 && charCode !== 127) {
                    event.preventDefault();
                }
                else {
                    return true;

                }
	        }
        }


    }
</script>

<style>
	#amount-input{
		font-size: 36px;
	}
</style>