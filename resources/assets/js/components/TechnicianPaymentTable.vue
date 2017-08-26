<template>
	<div id = "technician-payment-record">
		<v-card class = "elevation-1 grey lighten-4">
			<v-card-text v-if="loadingSale">
				<p class = "title">Loading Payment...</p>
			</v-card-text>
			<v-card-text v-if="paymentsExist">
				<v-data-table :headers="headers" :items="payments" hide-actions >
					<template slot="headers" scope="props">
						<th v-for="header in props.headers" :key="header.text">
							<p class = "subheading text-lg-center">{{ header.text }}</p>
						</th>
					</template>
					<template slot="items" scope="props">
						<td class = "text-xs-left subheading">$ {{ props.item.amount }}</td>
						<td class = "text-xs-left subheading">{{ props.item.method }}</td>
					</template>
				</v-data-table>
			</v-card-text>
			<v-card-text v-else>
				<p class = "title">No Payments Found</p>
			</v-card-text>
		</v-card>
	</div>
</template>

<script>
    export default {
        props: ['payments'],

        data() {
            return {
                headers:[
                    {text: 'Amount', value:'amount', sortable:false},
                    {text: 'Method', value:'method', sortable:false},

                ],
                loadingSale:true,
            }


        },
        watch:{
            payments(){
                if((this.payments).length >= 0){
                    this.loadingSale = false;
                }
            }
        },

        computed:{
            paymentsExist(){
                return (this.payments).length > 0;
            }
        },
        methods: {

        }


    }
</script>

<style>

</style>