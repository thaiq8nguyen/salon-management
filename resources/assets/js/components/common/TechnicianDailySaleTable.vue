<template>
	<div id = "technician-daily-sale">
		<v-card class = "elevation-1 white" v-if="sales.length">
			<v-card-text >
				<v-data-table :headers="headers" :items="sales" hide-actions >
					<template slot="headers" scope="props">
						<th v-for="header in props.headers" :key="header.text">
							<p class = "subheading text-xs-center">{{ header.text }}</p>
						</th>
					</template>
					<template slot="items" scope="props">
						<td class = "text-xs-center subheading">{{ readableDate(props.item.sale_date) }}</td>
						<td class = "text-xs-center subheading">$ {{ props.item.sales }}</td>
						<td class = "text-xs-center subheading">$ {{ props.item.additional_sales }}</td>
					</template>
				</v-data-table>
			</v-card-text>

		</v-card>
		<v-alert v-else warning value="true"><div class = "title">No Sales Found</div></v-alert>
	</div>

</template>

<script>
    export default {
        props: ['dailySales'],

        data() {
            return {
				sales: this.dailySales,
                headers: [

                    {text: 'Date', value: 'sale_date', sortable: false},
                    {text: 'Sale', value: 'sales', sortable: false},
                    {text: 'Tip', value: 'additional_sales', sortable: false}

                ],
	            screenWidth:window.innerWidth,
                screenHeight:window.innerHeight,

            }
        },

	    watch:{
			dailySales(){
                this.sales = this.dailySales;
			}
	    },


        methods: {
            readableDate(date){
                if(this.screenWidth < 768){ //for iPhone 5,6,6+
                    return this.$moment(date).format('M/D/YY');
                }
                else{
                    return this.$moment(date).format('M/D/YY dd');
                }

            },
        }


    }
</script>

<style>

</style>