<template>
	<div>
		<v-card>
			<v-card-title class = "display-1" v-text="title">

			</v-card-title>
			<v-card-text>
				<v-btn @click.native="voiding" primary>Confirm</v-btn>
				<v-btn @click.native="cancel">Cancel</v-btn>
			</v-card-text>
		</v-card>
	</div>
</template>

<script>
    export default {
        props: ['id','title'],

        data() {
            return {

            }


        },
        methods: {
            voiding(){
                this.$axios.post('/api/gift-certificate/void',{id:this.id})
	                .then(response => {
	                    if(response.data.success){
                            this.$emit('completed',response.data.amount);
	                    }
	                });
            },
	        cancel(){
                this.$emit('cancel');
	        }
        }


    }
</script>

<style>

</style>