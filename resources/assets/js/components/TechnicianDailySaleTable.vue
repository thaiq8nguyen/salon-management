<template>
	<v-card class = "elevation-1 grey lighten-4">
		<v-card-text>
			<v-data-table :headers="headers" :items="dailySales" hide-actions >
				<template slot="headers" scope="props">
					<th v-for="header in props.headers" :key="header.text">
						<p class = "subheading text-lg-center">{{ header.text }}</p>
					</th>
				</template>
				<template slot="items" scope="props">
					<td class = "text-xs-center subheading">{{ readableDate(props.item.sale_date) }}</td>
					<td class = "text-xs-right subheading">$ {{ props.item.sales }}</td>
					<td class = "text-xs-right subheading">$ {{ props.item.additional_sales }}</td>
				</template>
			</v-data-table>
		</v-card-text>
	</v-card>
</template>

<script>
    export default {
        props: ['dailySales'],

        data() {
            return {

                headers: [
                    {text: 'Date', value: 'sale_date', sortable: false},
                    {text: 'Sale', value: 'sales', sortable: false},
                    {text: 'Tip', value: 'additional_sales', sortable: false}

                ]
            }
        },
        methods: {
            readableDate(date){
                return this.$moment(date).format('MM/DD/YY dddd');
            },
        }


    }
</script>

<style>

</style>