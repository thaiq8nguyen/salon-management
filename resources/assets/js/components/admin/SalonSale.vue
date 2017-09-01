<template>
	<div>
		<v-app>
			<v-container fluid>
				<v-layout row wrap>
					<v-flex lg3>
						<v-date-picker v-model="date"></v-date-picker>
					</v-flex>
					<v-flex lg6>
						<template v-if="isSquareData">
							<salon-sale-table :saleData="squareData"></salon-sale-table>
						</template>
						<template v-else>
							<v-card>
								<v-card-text class = "text-lg-center">
									<v-icon large class = "red--text">info</v-icon>
									<p class = "subheading">There is no data recorded for this datex</p>
								</v-card-text>
							</v-card>
						</template>
					</v-flex>
					<v-flex lg3>
						<redeem-certificate :date="date" v-on:redeemed="refresh"></redeem-certificate>
					</v-flex>
				</v-layout>
			</v-container>
		</v-app>
	</div>
</template>

<script>

    import SalonSaleTable from './SalonSaleTable.vue';
    import redeemCertificate from './RedeemCertificate.vue';

    export default{

        props: [],

        data(){
            return {
                date: this.$moment().format('YYYY-MM-DD'),
	            isSquareData:false,
	            squareData:[]
            }
        },
	    watch:{

            date:function(){
                sessionStorage.setItem('saleDate',this.date);
				this.getSquareData();
            }

	    },
	    components:{

            'salon-sale-table': SalonSaleTable,

		    'redeem-certificate':redeemCertificate

	    },
		mounted(){

            this.handleDate();
            this.getSquareData();

		},

        methods: {
            handleDate(){

                let saleDate = sessionStorage.getItem('saleDate');
				console.log(saleDate);
                if(saleDate === null || saleDate === 'undefined'){

                    sessionStorage.setItem('saleDate', this.date);

                }else{

                    this.date = saleDate;

                }

            },
            getSquareData(){
                this.$axios('/api/salon/daily-sale?date=' + this.date).then(response=>{
                    this.isSquareData = response.data.success;
                    console.log(response.data);
                    if(this.isSquareData){
                        this.squareData = response.data;

                    }
                });
            },

            refresh(){
                this.getSales();
            }
        }
    }


</script>

<style>

</style>