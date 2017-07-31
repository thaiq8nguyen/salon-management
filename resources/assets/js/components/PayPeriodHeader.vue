<template>
	<div>
		<v-layout row class = "grey lighten-4">
			<v-flex xs1>
				<v-card flat>
					<v-card-text>
						<i class = "fa fa-calendar fa-2x"></i>
					</v-card-text>
				</v-card>
			</v-flex>
			<v-flex xs1>
				<v-subheader>Pay Periods:</v-subheader>
			</v-flex>
			<v-flex xs2>
				<v-select :items="periods" label="Select" single-line class = "blue--text"
				          v-model="selectID" item-text="periods" item-value="id" bottom @input="setPayPeriodID"></v-select>

			</v-flex>
			<v-flex xs1>
				<v-subheader>Current:</v-subheader>
			</v-flex>
			<v-flex xs2>
				<v-subheader>{{ current.periods}}</v-subheader>
			</v-flex>
			<v-flex xs1>
				<v-subheader>Pay Date:</v-subheader>
			</v-flex>
			<v-flex xs1>
				<v-subheader>{{ current.payDate }}</v-subheader>
			</v-flex>
		</v-layout>
	</div>

</template>

<script>
    export default{
        data(){
            return {
				current:'',
				selectID:null,
	            periods:[]

            }
        },
	    mounted(){
            this.getPayPeriod();
	    },
	    methods:{
            getPayPeriod(){
                this.$axios.get('/api/pay-period/list').then(response => {
                    this.periods = response.data;
                    this.current = response.data[response.data.length-1];
                    this.selectID = this.current.id;
                });
            },
		    setPayPeriodID(){
                this.$emit('id', this.selectID);
		    }
        }
    }
</script>

<style>

</style>