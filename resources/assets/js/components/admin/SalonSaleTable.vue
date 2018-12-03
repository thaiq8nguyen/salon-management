<template>
	<div>
		<v-card>
			<v-card-title class = "grey lighten-4">
				<v-layout>
					<v-flex lg8 md4>
						<p class = "headline">Sales Summary with <img :src = "squareLogo" height = "40px"> </p>
					</v-flex>
					<v-flex lg4 md4>
						{{readableDate(saleData.date)}}
					</v-flex>
				</v-layout>
			</v-card-title>
			<v-card-text>
				<template v-if="squareData">
					<v-data-table :headers="sales.headers" :items="sales.items" hide-actions class="text-md-center">
						<template slot="headers" slot-scope="props">
							<th v-for="header in props.headers" :key="header.name" class="text-lg-center">
								<p class = "subheading blue--text">{{ header.name }}</p>
							</th>
						</template>

						<template slot="items" slot-scope="props">
							<td class = "subheading">
								<v-icon v-if="props.item.icon" :class = "props.item.style">{{props.item.icon}}</v-icon>
								<strong>{{ props.item.name}}</strong></td>
							<td class = "text-md-center subheading" :class="props.item.square_style">{{ props.item.square}}</td>
							<td class = "text-md-center subheading">{{ props.item.technician }}</td>
							<td class = "text-md-center subheading">{{ props.item.difference }}</td>
						</template>
					</v-data-table>
				</template>
				<template v-else>
					<v-card>
						<v-card-text class = "text-lg-center">
							<v-icon large class = "red--text">info</v-icon>
							<p class = "subheading">There is no data recorded for this datex</p>
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
				squareData: true,

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
			                square: this.formatMoney(this.saleData.sales['Square Gross Sales']),
			                technician: this.formatMoney(this.saleData.sales['Technician Sales']),
			                difference: this.formatMoney(this.saleData.sales['Gross Sales Difference']),
			                icon:'',
			                style:'',
			                square_style:'blue lighten--4 white--text',
		                },
		                { //Index 1
		                    value:false,
			                name: 'Refund',
                            square: this.formatMoney(this.saleData.sales['Refunded']),
                            technician: '$ 0.00',
                            difference: '$ 0.00',
                            icon:'',
                            style:'',

		                },
                        { //Index 2
                            value:false,
                            name: 'Net Sales',
                            square: this.formatMoney(this.saleData.sales['Square Net Sales']),
                            technician: this.formatMoney(this.saleData.sales['Technician Net Sales']),
                            difference: this.formatMoney(this.saleData.sales['Net Sales Difference']),
                            icon:'',
                            style:'',


                        },
		                { //Index 3
		                    value:false,
			                name:'Tips on Card',
			                square: this.formatMoney(this.saleData.tips['Square Tips']),
			                technician:this.formatMoney(this.saleData.tips['Technician Tips']),
			                difference:this.formatMoney(this.saleData.tips['Tips Difference']),
                            icon:'',
                            style:'',

		                },
		                { //Index 4
		                    value:false,
			                name:'Gift Sales',
			                square:this.formatMoney(this.saleData.sales['Gift Certificate']),
			                technician: '$ 0.00',
			                difference: '$ 0.00',
                            icon:'card_giftcard',
                            style:'red--text',

		                },
                        { //Index 5
                            value:false,
                            name:'Total Collected',
                            square:this.formatMoney(this.saleData.sales['Square Total Collected']),
                            technician:this.formatMoney(this.saleData.sales['Technician Total Collected']),
                            difference:this.formatMoney(this.saleData.sales['Total Collected Difference']),
                            icon:'',
                            style:'',

                        },
		                {
		                    //Index 6
			                value:false,
			                name:'Cash',
			                square:this.formatMoney(this.saleData.sales['Cash Collected']),
			                technician: '$ 0.00',
			                difference: '$ 0.00',
                            icon:'attach_money',
                            style:'green--text',
                            square_style:'blue lighten--4 white--text',
		                },
                        {
                            //Index 7
                            value:false,
                            name:'Card',
                            square:this.formatMoney(this.saleData.sales['Card Collected']),
                            technician: '$ 0.00',
                            difference: '$ 0.00',
                            icon:'credit_card',
                            style:'blue--text',
                            square_style:'blue lighten--4 white--text',
                        },
		                { //Index 8
		                    value:false,
			                name:'Gift Redeems',
			                square: this.formatMoney(this.saleData.sales['Gift Certificate Redeemed']),
			                technician:'$ 0.00',
			                difference:'$ 0.00',
                            icon:'card_giftcard',
                            style:'orange--text',
		                },
		                { //Index 9
		                    value:false,
			                name:'Convenience Fees',
			                square:this.formatMoney(this.saleData.sales['Convenience Fee']),
			                technician: '$ 0.00',
			                difference: '$ 0.00',
                            icon:'',
                            style:'',
                            square_style:'blue lighten--4 white--text',
		                },
		                { //Index 10
		                    value:false,
			                name:'Processing Fees',
			                square:this.formatMoney(this.saleData.sales['CC Fees']),
			                technician: '$ 0.00',
			                difference:'$ 0.00',
                            icon:'credit_card',
                            style:'purple--text',
		                }
	                ]
                }
            }
        },


	    watch:{
            saleData:function(){

	            if(this.saleData.success){
	                this.squareData = true;
                    this.updateSale();
	            }else{
	                this.squareData  = false;

	            }

            }
	    },

        methods: {

            formatMoney(amount){

				return('$ ' + parseFloat(amount).toFixed(2));
            },

	        readableDate(date){
              return this.$moment(date).format('dddd MM/DD/YYYY');
	        },

            updateSale(){

                this.sales.items[0].square = this.formatMoney(this.saleData.sales['Square Gross Sales']);
                this.sales.items[0].technician = this.formatMoney(this.saleData.sales['Technician Sales']);
				this.sales.items[0].difference = this.formatMoney(this.saleData.sales['Gross Sales Difference']);

				this.sales.items[1].square = this.formatMoney(this.saleData.sales['Refunded']);
                this.sales.items[1].technician = this.formatMoney(this.saleData.sales['Refunded']);


				this.sales.items[2].square = this.formatMoney(this.saleData.sales['Square Net Sales']);
				this.sales.items[2].technician =  this.formatMoney(this.saleData.sales['Technician Net Sales']);
				this.sales.items[2].difference = this.formatMoney(this.saleData.sales['Net Sales Difference']);

				this.sales.items[3].square =  this.formatMoney(this.saleData.tips['Square Tips']);
				this.sales.items[3].technician = this.formatMoney(this.saleData.tips['Technician Tips']);
				this.sales.items[3].difference =  this.formatMoney(this.saleData.tips['Tips Difference']);

				this.sales.items[4].square = this.formatMoney(this.saleData.sales['Gift Certificate']);
				this.sales.items[4].technician = this.formatMoney(this.saleData.sales['Gift Certificate']);

				this.sales.items[5].square = this.formatMoney(this.saleData.sales['Square Total Collected']);
                this.sales.items[5].technician = this.formatMoney(this.saleData.sales['Technician Total Collected']);
                this.sales.items[5].difference = this.formatMoney(this.saleData.sales['Total Collected Difference']);

                this.sales.items[6].square = this.formatMoney(this.saleData.sales['Cash Collected']);

                this.sales.items[7].square = this.formatMoney(this.saleData.sales['Card Collected']);

                this.sales.items[8].square = this.formatMoney(this.saleData.sales['Gift Certificate Redeemed']);
				this.sales.items[8].technician = this.formatMoney(this.saleData.sales['Gift Certificate Redeemed']);

				this.sales.items[9].square = this.formatMoney(this.saleData.sales['Convenience Fee']);
				this.sales.items[9].technician = this.formatMoney(this.saleData.sales['Convenience Fee']);

				this.sales.items[10].square = this.formatMoney(this.saleData.sales['CC Fees']);
				this.sales.items[10].technician =  this.formatMoney(this.saleData.sales['CC Fees']);


            },

        }


    }
</script>

<style>

</style>