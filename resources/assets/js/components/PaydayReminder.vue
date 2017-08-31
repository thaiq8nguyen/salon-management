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
	            reminder:{},
	            reminders:[],
	            date: this.$moment().format('MM/DD/YYYY')

            }

        },
		computed:{
            endDate(){
                if(this.payDate !== null){
                    return this.$moment(this.current.payDate,'MM/DD/YYYY').
                    subtract(2,'days').format('dddd, MM/DD/YYYY ');
                }
                return 'There are errors occured while processing end date';
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

                    if(this.date === this.payDate){
                        this.reminder.name = 'pay_date';
                        this.reminder.text = 'Pay Date is today!';

                    }else{
                        this.reminder.name = 'end_date';
                        this.reminder.text = 'This pay period ends in ' + this.endDate;

                    }


                    this.addReminder();

                }).catch(error =>{
                    if(error.response){
                        if(error.response.status === 422){
                            this.reminder.name = 'error';
                            this.reminder.text = error.response.data;

                            this.addReminder();
                        }
                    }
                })


            },
	        addReminder(){
                this.reminders.push(this.reminder)
	        }
        }


    }
</script>

<style>

</style>