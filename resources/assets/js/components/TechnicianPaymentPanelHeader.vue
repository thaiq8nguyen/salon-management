<template>
	<div slot="header" @click.capture="selectedPanel(index)">
		<v-container>
			<v-layout row wrap>
				<v-flex lg4>
					<p class = "headline" :class="{'amber--text text--darken-1':activePanel(index)}" >{{technician.full_name}}</p>
				</v-flex>
				<v-flex lg4 v-if="technician.daily_sales.length > 0">
					<span v-if="technician.count_payments.length > 0">
							<v-chip label small class = "green darken-1 white--text subheading elevation-4">
							<v-icon class = "white--text">done</v-icon>Paid</v-chip>
					</span>
					<span v-else>
							<v-chip label small class = "amber darken-1 white--text subheading">
							<v-icon class = "white--text">monetization_on</v-icon>{{ technician.total_sales_and_tips[0].total}}</v-chip>
					</span>
				</v-flex>
				<v-flex lg4 v-else>
					<v-chip label small class = "grey darken-1 white--text subheading">
					<v-icon class = "white--text">money_off</v-icon>No Sales</v-chip>
				</v-flex>
			</v-layout>
		</v-container>
	</div>
</template>

<script>
    export default {
        props: [
            'technician','index'
        ],

        data() {
            return {
                activePanelIndex:null,
            }


        },
        methods: {
            selectedPanel(index){
                this.activePanelIndex = index;
            },
	        activePanel(index){
                return this.activePanelIndex === index;
	        }
        }


    }
</script>

<style>

</style>