<template>
	<v-layout row>
		<v-flex lg3>
			<v-text-field type = "number" max = "4" label="Amount" prefix="$" v-model="amount"></v-text-field>
		</v-flex>
		<v-flex lg3 ml-3>
			<v-text-field label="Reference" v-model="ref"></v-text-field>
		</v-flex>
		<v-flex lg3 ml-3>
			<v-select
					:items="methods"
					v-model="method"
					label="Method"
					single-line
					bottom
			></v-select>
		</v-flex>
		<v-flex lg3 ml-3>
			<v-btn @click.native="addPayment" class = "green white--text"><v-icon>add</v-icon>Payment</v-btn>
		</v-flex>
	</v-layout>
</template>

<script>
    export default {
        props: [],
        data() {
            return {
                amount:null,
	            ref:null,
	            method:null,
	            methods:[
	                'cash','check','direct deposit'
	            ]
            }

        },
        methods: {
			addPayment(){

				let payment = {amount:this.amount, reference:this.ref, method:this.method};
			    this.$emit('add',payment);
			    this.resetInputs();
			},

			resetInputs(){

				this.amount = null;
			    this.ref = null;
			    this.method = null;

			}
        }


    }
</script>

<style>

</style>