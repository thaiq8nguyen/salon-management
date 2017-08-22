<template>
	<div>
		<v-card>
			<v-card-title class = "display-1 deep-purple darken-1 white--text headline" v-text="title">

			</v-card-title>
			<v-card-text class = "text-xs-center">
				<v-btn @click.native="voiding" primary>Confirm</v-btn>
				<v-btn @click.native="cancel">Cancel</v-btn>
			</v-card-text>
		</v-card>
	</div>
</template>

<script>
    export default {
        props: ['gift','title'],

        data() {
            return {

            }


        },
        methods: {
            voiding(){
                this.$axios.post('/api/gift-certificate/void',{id:this.gift.id})
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