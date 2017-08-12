<template>
	<div>
		<v-card>
			<v-card-text class = "grey lighten-4">
				<v-layout row >
					<v-flex lg5>
						<v-layout row>
							<v-flex lg3>
								<p class = "subheading">Pay Periods:</p>
							</v-flex>
							<v-flex lg6>
								<v-select :items="periods" label="Select" single-line class = "blue--text"
								          v-model="selectID" item-text="periods" item-value="id" bottom @input="setPayPeriodID">

								</v-select>
							</v-flex>
						</v-layout>
					</v-flex>
					<v-flex lg3>
						<v-chip label class = "blue darken-1 subheading white--text"><strong>Current Period: </strong> {{ currentPeriod.periods }}</v-chip>
					</v-flex>
					<v-flex lg4 ml-2>
						<v-chip label class = "blue darken-1 subheading white--text" v-if="countDown > 0"><strong>Upcoming Pay Date: </strong> {{ currentPeriod.payDate }} in {{countDown}} days </v-chip>
						<v-chip label class = "amber darken-1 subheading white--text" v-else-if="countDown == 0">Today</v-chip>
					</v-flex>
				</v-layout>
			</v-card-text>
		</v-card>

	</div>

</template>

<script>
    export default{
        data(){
            return {
				currentPeriod:'',
				selectID:null,
	            periods:[]

            }
        },
	    mounted(){
            this.getPayPeriod();
	    },

		computed:{
	        countDown(){
	            let today = this.$moment();
	            return this.$moment(this.currentPeriod.payDate, 'MM/DD/YYYY').diff(today,'days');


	        }
		},

	    watch:{
			selectID(){
			    //store the last selected period id in a session variable
                sessionStorage.setItem('lastSelectedPeriodIdPayDay',this.selectID);
		    }
	    },
	    methods:{
            getPayPeriod(){
                this.$axios.get('/api/pay-period/list').then(response => {
                    this.periods = response.data;
                    this.currentPeriod = response.data[response.data.length-1];

					//retrieve the last selected period id in a session variable
                    let lastSelectedPeriodId = sessionStorage.getItem('lastSelectedPeriodIdPayDay');
                    if(lastSelectedPeriodId === null){
                        this.selectID = this.currentPeriod.id;

                    }else{
                        this.selectID = parseInt(lastSelectedPeriodId);
                    }

                });
            },
		    setPayPeriodID(){
                this.$emit('id', this.selectID);
                Event.$emit('id', this.selectID);
		    }
        }
    }
</script>

<style>

</style>