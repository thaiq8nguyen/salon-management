<template>
	<div>
		<v-card >
			<v-card-title class = "blue darken-2">
				<h3 class = "headline white--text">Redeem Certificate</h3>
			</v-card-title>
			<v-card-text>
				<v-text-field label="Amount" prefix="$" v-model="certificate.amount"></v-text-field>
			</v-card-text>
			<v-card-actions>
				<v-btn @click.native="redeem">Redeem</v-btn>
			</v-card-actions>
			<v-spacer></v-spacer>
			<v-card-text>

				<v-alert :class="alert.status" v-model="alert.show">{{ alert.message }}</v-alert>

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
					status:'',
					message:''
				},

	            certificate:{

                    amount:0,
		            date:this.$moment().format('YYYY-MM-DD')

	            },

	            redeemed:false

            }
        },

	    watch:{
			date:function(){
			    this.certificate.date = this.date;
			    this.alert.show = false;
			}
	    },
        methods:{
            redeem(){
                this.$axios.post('/api/salon-sale/redeem-gift-certificate',
                    this.certificate).then(response =>{
                        if(response.data.success){
							this.alert.status = 'success';
							this.alert.message = response.data.message;
                            this.alert.show = true;
                            this.reset();
                            this.$emit('redeemed');
                        }
                        else{
                            this.alert.status = 'error';
                            this.alert.message = 'Input errors';
                            this.alert.show = true;
                        }

                }).catch(error => {
                    if(error.response){
                        console.log(error.response.data);
                        this.alert.status = 'error';
                        this.alert.message = 'Input errors';
                        this.alert.show = true;
                    }
                })
            },

	        reset(){
                this.certificate.amount = 0;
	        }


        }

    }
</script>

<style>

</style>