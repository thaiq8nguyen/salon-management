<template>
	<div>
		<v-card>
			<v-card-title class = "blue darken-2">
				<h3 class = "headline white--text">Salon Sale</h3>
			</v-card-title>
			<v-card-text>
				<v-data-table :headers="sales.headers"
				              :items="sales.items" hide-actions class="text-md-center">
					<template slot="items" scope="props">
						<td>{{ props.item.name}}</td>
						<td class = "text-md-right">$ {{ props.item.square}}</td>
						<td class = "text-md-right">$ {{ props.item.technician }}</td>
						<td class = "text-md-right">$ {{ props.item.difference }}</td>
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

                sales:{
                    headers:[
	                    {text:'', value:"name", sortable:false},
	                    {text:'Square', value:'square', sortable:false},
	                    {text:'Technician', value:'technician', sortable:false},
	                    {text:'Difference', value:'difference', sortable:false}

                    ],
	                items:[
		                {
		                    value:false,
		                    name:'Gross Sales',
			                square: 0,
			                technician: 0,
			                difference: 0
		                },
		                {
		                    value:false,
			                name:'Tips on Card',
			                square: 0,
			                technician:0,
			                difference:0

		                },
		                {
		                    value:false,
			                name:'Certificates Sold',
			                square:0,
			                technician:0,
			                difference:0

		                },
		                {
		                    value:false,
			                name:'Certificates Redeemed',
			                square:0,
			                technician:0,
			                difference:0
		                },
		                {
		                    value:false,
			                name:'Convenience Fees',
			                square:0,
			                technician:0,
			                difference:0
		                },
		                {
		                    value:false,
			                name:'Processing Fees',
			                square:0,
			                technician:0,
			                difference:0
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
                this.sales.items[0].technician = this.sale.sales['Technician Gross Sales'];
				this.sales.items[0].difference = this.sale.sales['Gross Sales Difference'];

				this.sales.items[1].square =  this.sale.tips['Square Tips'];
				this.sales.items[1].technician = this.sale.tips['Technician Tips'];
				this.sales.items[1].difference =  this.sale.tips['Tips Difference'];

				this.sales.items[3].square = this.sale.sales['Gift Certificate Redeemed'];
				this.sales.items[4].square = this.sale.sales['Convenience Fee'];


            }
        }


    }
</script>

<style>

</style>