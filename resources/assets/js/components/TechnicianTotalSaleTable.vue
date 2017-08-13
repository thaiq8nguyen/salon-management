<template>
	<v-card class = "elevation-1 grey lighten-4">
		<v-card-text>
			<v-data-table :headers="headers" :items="totalSales"
			              hide-actions>
				<template slot="headers" scope="props">
					<th v-for="header in props.headers" :key="header.text">
						<p class = "subheading text-lg-center">{{ header.text }}</p>
					</th>
				</template>
				<template slot="items" scope="props">
					<td class = "text-xs-right subheading">$ {{ props.item.subTotal }}</td>
					<td class = "text-xs-right subheading">$ {{ props.item.subTotalTip }}</td>
					<td class = "text-xs-right subheading">$ {{ props.item.earnedTotal }}</td>
					<td class = "text-xs-right subheading">$ {{ props.item.earnedTip }}</td>
					<td class = "text-lg-center red--text headline">$ {{ props.item.total }}</td>
				</template>
			</v-data-table>
		</v-card-text>
	</v-card>
</template>

<script>
    export default {
        props: ['totalSales'],

        data() {
            return {
                headers: [
                    {text: 'Sub Total', value: 'subTotal', sortable: false},
                    {text: 'Sub Total Tip', value: 'subTotalTip', sortable: false},
                    {text: 'Earned Total', value: 'earnedTotal', sortable: false},
                    {text: 'Tip Deduction', value: 'earnedTip', sortable: false},
                    {text: 'To Pay', value: 'total', sortable: false},

                ]
            }


        },
        methods: {}


    }
</script>

<style>

</style>