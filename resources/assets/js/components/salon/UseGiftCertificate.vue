<template>
	<div>
		<v-card>
			<v-card-title class = "display-1" v-text="title">

			</v-card-title>
			<v-card-text>
				<v-layout row>
					<v-flex lg5 md5>
						<v-subheader class = "headline">Amount: </v-subheader>
					</v-flex>
					<v-flex lg4 md4>
						<v-text-field prepend-icon="attach_money" v-model="amount"></v-text-field>
					</v-flex>
				</v-layout>
				<v-layout row>
					<v-flex lg5 md5>
						<v-subheader class = "headline">Comments: </v-subheader>
					</v-flex>
					<v-flex lg6 md6>
						<v-text-field prepend-icon="comment" v-model="comments" multi-line></v-text-field>
					</v-flex>
				</v-layout>
			</v-card-text>
			<v-card-text>
				<v-btn @click.native="useCertificate" primary>Use</v-btn>
				<v-btn @click.native="cancel">Cancel</v-btn>
			</v-card-text>
		</v-card>
	</div>
</template>

<script>


    export default {
        components: {},
        props: ['id','title'],

        data() {
            return {
				amount:null,
	            comments:null,
            }


        },
        methods: {
            useCertificate(){
                let detail = {amount: this.amount, comments: this.comments};

                this.$axios.post('/api/gift-certificate/use',{id: this.id, detail: detail}).
                then(response =>{
                    if(response.data.success){
                        this.amount = null;
                        this.comments = null;
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