<template>
	<div>
		<v-card>
			<v-card-title class = "grey lighten-4">
				<h3 class = "headline">Salon Sale with <img :src="squareLogo" height="60">
				</h3>
				<v-btn flat @click.native="syncData" outline><v-icon>cached</v-icon>Sync</v-btn>
			</v-card-title>
			<v-card-text>
				<v-data-table :headers="sales.headers" :items="sales.items" hide-actions class="text-md-center">

					<template slot="headers" scope="props">

						<th v-for="header in props.headers" :key="header.name" class="text-lg-center">
							<p class = "subheading blue--text">{{ header.name }}</p>
						</th>
					</template>

					<template slot="items" scope="props">
						<td class = "subheading"><strong>{{ props.item.name}}</strong></td>
						<td class = "text-md-center subheading">$ {{ props.item.square}}</td>
						<td class = "text-md-center subheading">$ {{ props.item.technician }}</td>
						<td class = "text-md-center subheading">$ {{ props.item.difference }}</td>
					</template>
				</v-data-table>
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
			                difference: '0.00'
		                },
		                { //Index 1
		                    value:false,
			                name: 'Refund',
                            square: '0.00',
                            technician: '0.00',
                            difference: '0.00'

		                },
                        { //Index 2
                            value:false,
                            name: 'Net Sales',
                            square: '0.00',
                            technician: '0.00',
                            difference: '0.00'

                        },
		                { //Index 3
		                    value:false,
			                name:'Tips on Card',
			                square: '0.00',
			                technician:'0.00',
			                difference:'0.00'

		                },
		                { //Index 4
		                    value:false,
			                name:'Gift Sales',
			                square:'0.00',
			                technician: '0.00',
			                difference: '0.00'

		                },
                        { //Index 5
                            value:false,
                            name:'Total Collected',
                            square:'0.00',
                            technician:'0.00',
                            difference:'0.00'

                        },
		                { //Index 6
		                    value:false,
			                name:'Gift Redeems',
			                square: '0.00',
			                technician:'0.00',
			                difference:'0.00'
		                },
		                { //Index 7
		                    value:false,
			                name:'Convenience Fees',
			                square:'0.00',
			                technician: '0.00',
			                difference: '0.00'
		                },
		                { //Index 8
		                    value:false,
			                name:'Processing Fees',
			                square:'0.00',
			                technician: '0.00',
			                difference:'0.00'
		                }
	                ]
                }
            }
        },
	    watch:{
            saleData:function(){
                this.sale = this.saleData;
                this.updateSale();
            }
	    },
        methods: {

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

                this.sales.items[6].square = this.sale.sales['Gift Certificate Redeemed'];
				this.sales.items[6].technician = this.sale.sales['Gift Certificate Redeemed'];

				this.sales.items[7].square = this.sale.sales['Convenience Fee'];
				this.sales.items[7].technician = this.sale.sales['Convenience Fee'];

				this.sales.items[8].square = this.sale.sales['CC Fees'];
				this.sales.items[8].technician =  this.sale.sales['CC Fees'];


            },
	        syncData(){

	        }
        }


    }
</script>

<style>

</style>