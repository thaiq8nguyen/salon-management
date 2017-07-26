<template>
	<div>
		<v-app>
			<v-container fluid>
				<v-layout row wrap>
					<v-flex lg3>
						<v-date-picker v-model="saleDate"></v-date-picker>
					</v-flex>
					<v-flex lg6>
						<salon-sale-table :saleData="saleData"></salon-sale-table>
					</v-flex>
					<v-flex lg3>
						<redeem-certificate :date="saleDate" v-on:redeemed="refresh"></redeem-certificate>
					</v-flex>
				</v-layout>
			</v-container>
		</v-app>
	</div>
</template>

<script>

    import salonSaleTable from './SalonSaleTable.vue';
    import redeemCertificate from './RedeemCertificate.vue';

    export default{
        props: [],

        data(){
            return {
                saleDate: this.$moment().format('YYYY-MM-DD'),
	            saleData:null,
            }
        },
	    watch:{
            saleDate:function(){
				this.getSales();
            }
	    },
	    components:{
            'salon-sale-table':salonSaleTable,
		    'redeem-certificate':redeemCertificate

	    },


        methods: {

            getSales(){
                this.$axios('/api/salon/daily-sale?date=' + this.saleDate).then(response=>{
					this.saleData = response.data;
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