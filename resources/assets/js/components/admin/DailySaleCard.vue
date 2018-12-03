<template>
	<div id = "daily-sale-card">
		<v-card>
			<v-card-text class = "mt-0">
				<template v-if="saleExists">
					<v-data-table
							:headers="headers"
							:items="items" hide-actions>
						<template slot="items" slot-scope="props">
							<td>{{ props.item.name}}</td>
							<td class = "text-md-right">$ {{ props.item.square}}</td>
							<td class = "text-md-right">$ {{ props.item.technician }}</td>
							<td class = "text-md-right">$ {{ props.item.difference }}</td>
						</template>
					</v-data-table>
				</template>
				<template v-else>
					<v-alert error value="true">
						There is no sale recorded for {{ readableSaleDate }}
						<v-btn href="/salon-sales">Salon Sale</v-btn>
					</v-alert>
				</template>
			</v-card-text>
		</v-card>
	</div>
</template>

<script>

    export default {
        props: ['date','refresh'],

        data() {

            return {
                saleExists:null,
				saleDate:this.$moment().format('YYYY-MM-DD'),
	            headers:[
		            {text:'', value:'name',sortable:false},
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
			            name: 'Raw Technician Sales',
			            square:0,
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


        },

	    mounted(){
            this.getSales()
	    },

	    watch:{
            date(){
                this.saleDate = this.date;
                this.getSales();
            },
		    refresh(){
                if(this.refresh === true){
                    this.getSales();
                }

		    }
	    },

		computed:{
	        readableSaleDate(){
	            if(this.saleDate !== null){
                    return this.$moment(this.saleDate,'YYYY-MM-DD').format('MM/DD/YYYY');
	            }

	        }
		},
        methods: {
			getSales(){
                this.$axios('/api/salon/daily-sale?date=' + this.saleDate).then(this.updateSales);

			},
			updateSales(response){
				if(response.data.success) {
                    this.saleExists = true;
                    this.items[0].square = response.data.sales['Square Gross Sales'];
                    this.items[0].technician = response.data.sales['Technician Gross Sales'];
                    this.items[0].difference = response.data.sales['Gross Sales Difference'];

                    this.items[1].technician = response.data.sales['Technician Sales'];

                    this.items[2].square = response.data.tips['Square Tips'];
                    this.items[2].technician = response.data.tips['Technician Tips'];
                    this.items[2].difference = response.data.tips['Tips Difference'];

                    this.items[4].square = response.data.sales['Gift Certificate Redeemed'];
                    this.items[5].square = response.data.sales['Convenience Fee'];
                }else{
				    this.saleExists = false;
				}




            }
        }


    }
</script>

<style>

</style>