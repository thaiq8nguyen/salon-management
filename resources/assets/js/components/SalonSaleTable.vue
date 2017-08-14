<template>
	<div>
		<v-card>
			<v-card-title class = "grey lighten-4">
				<v-layout>
					<v-flex lg11>
						<p class = "headline">Salon Sale with <img :src="squareLogo" height="60"></p>
					</v-flex>
					<v-flex lg1 ml-4>
						<v-btn flat @click.native="syncData" outline><v-icon>cached</v-icon></v-btn>
					</v-flex>
				</v-layout>
			</v-card-title>
			<v-card-text>
				<template v-if="isSquareData">
					<v-data-table :headers="sales.headers" :items="sales.items" hide-actions class="text-md-center">

						<template slot="headers" scope="props">

							<th v-for="header in props.headers" :key="header.name" class="text-lg-center">
								<p class = "subheading blue--text">{{ header.name }}</p>
							</th>
						</template>

						<template slot="items" scope="props">
							<td class = "subheading">
								<v-icon v-if="props.item.icon" :class = "props.item.style">{{props.item.icon}}</v-icon>
								<strong>{{ props.item.name}}</strong></td>
							<td class = "text-md-center subheading">$ {{ props.item.square}}</td>
							<td class = "text-md-center subheading">$ {{ props.item.technician }}</td>
							<td class = "text-md-center subheading">$ {{ props.item.difference }}</td>
						</template>
					</v-data-table>
				</template>
				<template v-else>
					<v-card>
						<v-card-text class = "text-lg-center">
							<v-icon large class = "red--text">info</v-icon>
							<p class = "subheading">There is no data recorded for this date</p>
						</v-card-text>
					</v-card>
				</template>

			</v-card-text>
		</v-card>
	</div>

</template>

<script>
    export default{
        props: ['saleData'],

        data(){
            return {
                sale:null,
				isSquareData: true,
	            date: this.$moment().format('YYYY-MM-DD'),
	            squareLogo:'/images/square-logo.png',

                sales:{
                    headers:[

	                    {name:'', sortable:false},
	                    {name:'Square', sortable:false, align:'right'},
	                    {name:'Technician', sortable:false},
	                    {name:'Difference', sortable:false}

                    ],
	                items:[
		                { //Index 0
		                    value:false,
		                    name:'Gross Sales',
			                square: '0.00',
			                technician: '0.00',
			                difference: '0.00',
			                icon:'',
			                style:'',
		                },
		                { //Index 1
		                    value:false,
			                name: 'Refund',
                            square: '0.00',
                            technician: '0.00',
                            difference: '0.00',
                            icon:'',
                            style:'',

		                },
                        { //Index 2
                            value:false,
                            name: 'Net Sales',
                            square: '0.00',
                            technician: '0.00',
                            difference: '0.00',
                            icon:'',
                            style:'',

                        },
		                { //Index 3
		                    value:false,
			                name:'Tips on Card',
			                square: '0.00',
			                technician:'0.00',
			                difference:'0.00',
                            icon:'',
                            style:'',

		                },
		                { //Index 4
		                    value:false,
			                name:'Gift Sales',
			                square:'0.00',
			                technician: '0.00',
			                difference: '0.00',
                            icon:'',
                            style:'',

		                },
                        { //Index 5
                            value:false,
                            name:'Total Collected',
                            square:'0.00',
                            technician:'0.00',
                            difference:'0.00',
                            icon:'',
                            style:'',

                        },
		                {
		                    //Index 6
			                value:false,
			                name:'Cash',
			                square:'0.00',
			                technician: '0.00',
			                difference: '0.00',
                            icon:'attach_money',
                            style:'green--text',
		                },
                        {
                            //Index 7
                            value:false,
                            name:'Card',
                            square:'0.00',
                            technician: '0.00',
                            difference: '0.00',
                            icon:'credit_card',
                            style:'blue--text',
                        },
		                { //Index 8
		                    value:false,
			                name:'Gift Redeems',
			                square: '0.00',
			                technician:'0.00',
			                difference:'0.00',
                            icon:'',
                            style:'',
		                },
		                { //Index 9
		                    value:false,
			                name:'Convenience Fees',
			                square:'0.00',
			                technician: '0.00',
			                difference: '0.00',
                            icon:'',
                            style:'',
		                },
		                { //Index 10
		                    value:false,
			                name:'Processing Fees',
			                square:'0.00',
			                technician: '0.00',
			                difference:'0.00',
                            icon:'',
                            style:'',
		                }
	                ]
                }
            }
        },

	    mounted(){
            this.getSquareData();

	    },
	    watch:{
            saleData:function(){
                this.sale = this.saleData;
                this.updateSale();
            }
	    },

        methods: {
			getSquareData(){
                this.$axios('/api/salon/daily-sale?date=' + this.date).then(response=>{
                    if(response.data.success){
                        this.sale = response.data;
                        this.updateSale();
						this.squareData = true;
                    }else{
                        this.squareData = false;
                    }

                });
			},
            updateSale(){

                this.sales.items[0].square = this.sale.sales['Square Gross Sales'];
                this.sales.items[0].technician = this.sale.sales['Technician Sales'];
				this.sales.items[0].difference = this.sale.sales['Gross Sales Difference'];

				this.sales.items[1].square = this.sale.sales['Refunded'];
                this.sales.items[1].technician = this.sale.sales['Refunded'];


				this.sales.items[2].square = this.sale.sales['Square Net Sales'];
				this.sales.items[2].technician =  this.sale.sales['Technician Net Sales'];
				this.sales.items[2].difference = this.sale.sales['Net Sales Difference'];

				this.sales.items[3].square =  this.sale.tips['Square Tips'];
				this.sales.items[3].technician = this.sale.tips['Technician Tips'];
				this.sales.items[3].difference =  this.sale.tips['Tips Difference'];

				this.sales.items[4].square = this.sale.sales['Gift Certificate'];
				this.sales.items[4].technician = this.sale.sales['Gift Certificate'];

				this.sales.items[5].square = this.sale.sales['Square Total Collected'];
                this.sales.items[5].technician = this.sale.sales['Technician Total Collected'];
                this.sales.items[5].difference = this.sale.sales['Total Collected Difference'];

                this.sales.items[6].square = this.sale.sales['Cash Collected'];

                this.sales.items[7].square = this.sale.sales['Card Collected'];

                this.sales.items[8].square = this.sale.sales['Gift Certificate Redeemed'];
				this.sales.items[8].technician = this.sale.sales['Gift Certificate Redeemed'];

				this.sales.items[9].square = this.sale.sales['Convenience Fee'];
				this.sales.items[9].technician = this.sale.sales['Convenience Fee'];

				this.sales.items[10].square = this.sale.sales['CC Fees'];
				this.sales.items[10].technician =  this.sale.sales['CC Fees'];


            },
	        syncData(){


	        }
        }


    }
</script>

<style>

</style>