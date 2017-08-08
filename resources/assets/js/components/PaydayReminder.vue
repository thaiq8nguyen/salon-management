<template>
	<div>
		<template v-for="reminder in reminders">
			<v-chip label outline class = "amber black--text">
				<v-icon class = "amber--text">star</v-icon>{{reminder.text}}
			</v-chip>
		</template>
	</div>
</template>

<script>
    export default {
        props: [

        ],

        data() {
            return {
                periods:[],
	            current:null,
	            payDate:null,
	            reminders:[],

            }

        },
		computed:{
            endDate(){
                if(this.payDate !== null){
                    return this.$moment(this.current.payDate,'MM/DD/YYYY').
                    subtract(2,'days').format('dddd, MM/DD/YYYY ');
                }
                return 'Error';
            }
		},
	    mounted(){
            this.getPayPeriod();
	    },
        methods: {
            getPayPeriod(){
                this.$axios.get('/api/pay-period/list').then(response => {
                    this.periods = response.data;
                    this.current = response.data[response.data.length-1];
                    this.payDate = this.current.payDate;
                    let reminder = {
                        name: 'end date',
	                    text: 'This pay period ends in ' + this.endDate
                    };
                    this.addReminder(reminder);

                });
            },
	        addReminder(reminder){
                this.reminders.push(reminder)
	        }
        }


    }
</script>

<style>

</style>