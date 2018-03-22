<template>
	<div>
		<template v-if="this.isSquareDataExist">
			<v-layout row wrap>
				<v-flex lg3>
					<v-card height="178">
						<v-card-title><h4>Total Collected</h4></v-card-title>
						<v-card-text>
							<h3 class ="text-lg-center subheading">$ {{ this.squareData.sales['Total Collected Difference'].toLocaleString()}}</h3>
						</v-card-text>
						<v-card-text>
							<v-layout>
								<v-flex lg6 text-lg-left>
									<p>Square: $ {{ this.squareData.sales['Square Total Collected'].toLocaleString()}}</p>
								</v-flex>
								<v-flex lg6 text-lg-right>
									<p>Entered: $ {{ this.squareData.sales['Technician Total Collected'].toLocaleString()}}</p>
								</v-flex>
							</v-layout>
						</v-card-text>
					</v-card>
				</v-flex>
                <v-flex lg3>
                    <v-card height="178">
						<v-card-title><h4>Expected Cash Received</h4></v-card-title>
						<v-card-text>
							<h3 class ="text-lg-center subheading">$ {{ this.expectedCashReceivedDelta.toLocaleString()}}</h3>
						</v-card-text>
						<v-card-text>
							<v-layout>
								<v-flex lg6 text-lg-left>
									<p>Collected: $ {{ this.squareData.sales['Cash Collected'].toLocaleString()}}</p>
								</v-flex>
								<v-flex lg6 text-lg-right>
									<p>Tip: $ {{ this.squareData.tips['Square Tips'].toLocaleString()}}</p>
								</v-flex>
							</v-layout>
						</v-card-text>
					</v-card>
                </v-flex>
				<v-flex lg3>
					<v-card height="178">
						<v-card-title><h4>Gift Certificates</h4></v-card-title>
						<v-card-text>
							<v-layout>
								<v-flex>
									<p><v-icon color="green" medium>fa-gift</v-icon>&nbspSold: $ {{ this.squareData.sales['Gift Certificate']}}</p>
									<p><v-icon color="purple" medium>fa-gift</v-icon>&nbspRedeemed: $ {{ this.squareData.sales['Gift Certificate Redeemed']}}</p>
								</v-flex>
							</v-layout>
						</v-card-text>
					</v-card>
				</v-flex>
				<v-flex lg3>
					<v-card height="178">
						<v-card-title><h4>Payment Types</h4></v-card-title>
						<v-card-text>
							<v-layout>
								<v-flex>
									<p><v-icon medium>fa-credit-card</v-icon>&nbspCredit Card: $ {{ this.squareData.sales['Card Collected'].toLocaleString()}}</p>
									<p><v-icon medium>fa-money</v-icon>&nbspCash: $ {{ this.squareData.sales['Cash Collected'].toLocaleString()}}</p>
								</v-flex>
							</v-layout>
						</v-card-text>
					</v-card>
				</v-flex>
			</v-layout>
		</template>
		<template v-else>
			<v-card flat>
				<v-card-text>
					<div>
						<v-layout row wrap>
							<v-flex lg12>
								<v-icon x-large>info_outline</v-icon>
							</v-flex>
							<v-flex lg12>
								<h2>No sale took place on {{ this.formattedDate }}</h2>
							</v-flex>
						</v-layout>

					</div>
				</v-card-text>
			</v-card>
		</template>


	</div>
</template>

<script>


    export default{

        props: ['date','refresh'],

        data(){
            return {
	            isSquareDataExist:false,
	            squareData:[],

            }
        },
	    watch:{

			date(chosenDate){
			    this.getSquareData(chosenDate);
			},

			refresh(confirm){
			    if(confirm){
			        this.getSquareData(this.date)
                }
                //console.log(value);
            }

	    },

		computed:{
            formattedDate(){
                return this.$moment(this.date).format('dddd MM/DD/YYYY');
            },
            expectedCashReceivedDelta(){

                return this.squareData.sales['Cash Collected'] - this.squareData.tips['Square Tips'];
            }
		},

        methods: {

            getSquareData(date){
                this.$axios('/api/salon/daily-sale?date='+ date).then(response=>{
                    this.isSquareDataExist = response.data.success;
                    if(this.isSquareDataExist){

                        this.squareData = response.data;
                        this.$emit('complete','sale-available');

                    }
                    else{
                        this.$emit('complete','no-sale');
                    }


                });
            },


        }
    }


</script>

<style scoped>

</style>