<template>
	<div id = "technician-payment-report">
		<v-card class = "elevation-1 white" v-if="pays.length">
			<v-card-text>
				<v-data-table :headers="headers" :items="payments" hide-actions >
					<template slot="headers" slot-scope="props">
						<th v-for="header in props.headers" :key="header.text">
							<p class = "subheading text-lg-center">{{ header.text }}</p>
						</th>
					</template>
					<template slot="items" slot-scope="props">
						<td class = "text-xs-left subheading">$ {{ props.item.amount }}</td>
						<td class = "text-xs-left subheading">{{ props.item.method }}</td>
					</template>
				</v-data-table>
			</v-card-text>

		</v-card>
		<v-alert v-else warning value="true"><div class = "title">No Payments Found</div></v-alert>
	</div>
</template>

<script>
    export default {
        props: ['payments'],

        data() {
            return {
                pays: this.payments,
                headers: [
                    {text: 'Amount', value: 'amount', sortable: false},
                    {text: 'Method', value: 'method', sortable: false},

                ],

            }
        },

		computed:{


        },
        watch:{
			payments(){
			    this.pays = this.payments;
			}
        },
        methods: {

        }


    }
</script>

<style>

</style>